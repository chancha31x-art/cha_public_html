<?php
// /page/backend/api/dashboard_stats.php
declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

try {
  // ใช้ setting.php ของคุณตามที่ให้มา (มี $connect = new mysqli(...) แล้ว)
  require_once __DIR__ . '/../../../system/setting.php';

  if (!isset($connect) || !($connect instanceof mysqli)) {
    throw new RuntimeException('DB connection ($connect) is not available.');
  }

  // ให้แน่ใจว่า charset ถูกต้อง
  if (method_exists($connect, 'set_charset')) {
    $connect->set_charset('utf8mb4');
  } else {
    $connect->query("SET NAMES utf8mb4");
  }

  // ---- helpers (mysqli prepared) ----
  function kv_query(mysqli $conn, string $sql, string $types = '', array $params = []): array {
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
      throw new RuntimeException('Prepare failed: ' . $conn->error);
    }
    if ($types !== '' && $params) {
      $stmt->bind_param($types, ...$params);
    }
    if (!$stmt->execute()) {
      throw new RuntimeException('Execute failed: ' . $stmt->error);
    }
    $res = $stmt->get_result();
    if (!$res) {
      // สำหรับ MySQL เก่าที่ไม่มี get_result ให้ใช้ bind_result ก็ได้ แต่โฮสต์ส่วนใหญ่มี
      throw new RuntimeException('get_result failed: ' . $stmt->error);
    }
    $out = [];
    while ($row = $res->fetch_row()) {
      // คาดรูปแบบ 2 คอลัมน์ [key, value]
      $out[(string)$row[0]] = (float)$row[1];
    }
    $stmt->close();
    return $out;
  }

  // ---- read params ----
  $range  = isset($_GET['range']) ? trim((string)$_GET['range']) : '30';
  $isYear = (strtolower($range) === 'year');

  // ====== YEARLY (monthly summary) ======
  if ($isYear) {
    $year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
    if ($year < 2000 || $year > 2500) $year = (int)date('Y');

    // รายได้รายเดือนจาก pp_history_api (price: varchar, timeadd: unix)
    $sqlRev = "
      SELECT DATE_FORMAT(FROM_UNIXTIME(timeadd),'%Y-%m') AS ym,
             COALESCE(SUM(CAST(price AS DECIMAL(12,2))),0) AS total
      FROM pp_history_api
      WHERE YEAR(FROM_UNIXTIME(timeadd)) = ?
      GROUP BY ym
      ORDER BY ym ASC
    ";
    $revKV = kv_query($connect, $sqlRev, 'i', [$year]);

    // เพิ่มเงิน manual topup รายเดือน
    $sqlManual = "
      SELECT DATE_FORMAT(FROM_UNIXTIME(topuptime),'%Y-%m') AS ym,
             COALESCE(SUM(CAST(point AS DECIMAL(12,2))),0) AS total
      FROM pp_topup
      WHERE YEAR(FROM_UNIXTIME(topuptime)) = ?
        AND (topupby = 'manual' OR topupby LIKE '%admin%')
        AND status = 1
      GROUP BY ym
      ORDER BY ym ASC
    ";
    $manualKV = kv_query($connect, $sqlManual, 'i', [$year]);

    // รวมเงิน manual topup เข้ากับ revenue
    foreach ($manualKV as $ym => $val) {
      $revKV[$ym] = isset($revKV[$ym]) ? $revKV[$ym] + $val : $val;
    }

    // เติมเงินรายเดือนจาก pp_topup (ไม่ใช่ manual) (point, topuptime[unix], status=1)
    $sqlTop = "
      SELECT DATE_FORMAT(FROM_UNIXTIME(topupptime),'%Y-%m') AS ym,
             COALESCE(SUM(CAST(point AS DECIMAL(12,2))),0) AS total
      FROM (
        SELECT topuptime AS topupptime, point, status, topupby
        FROM pp_topup
      ) t
      WHERE YEAR(FROM_UNIXTIME(topupptime)) = ?
        AND status = 1
        AND topupby != 'manual'
        AND topupby NOT LIKE '%admin%'
      GROUP BY ym
      ORDER BY ym ASC
    ";
    $topKV = kv_query($connect, $sqlTop, 'i', [$year]);

    // labels 12 เดือน
    $labels = [];
    for ($m = 1; $m <= 12; $m++) {
      $labels[] = sprintf('%04d-%02d', $year, $m);
    }

    $map = function(array $kv, array $labels): array {
      $out = [];
      foreach ($labels as $k) $out[] = isset($kv[$k]) ? (float)$kv[$k] : 0.0;
      return $out;
    };

    echo json_encode([
      'mode'    => 'monthly',
      'year'    => $year,
      'labels'  => $labels,
      'revenue' => $map($revKV, $labels),
      'topup'   => $map($topKV, $labels),
    ], JSON_UNESCAPED_UNICODE);
    exit;
  }

  // ====== DAILY (ย้อนหลัง N วัน) ======
  $days = (int)$range;
  if ($days <= 0)  $days = 30;
  if ($days > 400) $days = 400;

  // รายได้รายวัน
  $sqlRevDaily = "
    SELECT DATE(FROM_UNIXTIME(timeadd)) AS d,
           COALESCE(SUM(CAST(price AS DECIMAL(12,2))),0) AS total
    FROM pp_history_api
    WHERE timeadd >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL ? DAY))
    GROUP BY DATE(FROM_UNIXTIME(timeadd))
    ORDER BY d ASC
  ";
  $revKV = kv_query($connect, $sqlRevDaily, 'i', [$days]);

  // เพิ่มเงิน manual topup รายวัน
  $sqlManualDaily = "
    SELECT DATE(FROM_UNIXTIME(topuptime)) AS d,
           COALESCE(SUM(CAST(point AS DECIMAL(12,2))),0) AS total
    FROM pp_topup
    WHERE topuptime >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL ? DAY))
      AND (topupby = 'manual' OR topupby LIKE '%admin%')
      AND status = 1
    GROUP BY DATE(FROM_UNIXTIME(topuptime))
    ORDER BY d ASC
  ";
  $manualKV = kv_query($connect, $sqlManualDaily, 'i', [$days]);

  // รวมเงิน manual topup เข้ากับ revenue
  foreach ($manualKV as $d => $val) {
    $revKV[$d] = isset($revKV[$d]) ? $revKV[$d] + $val : $val;
  }

  // เติมเงินรายวัน (ไม่ใช่ manual)
  $sqlTopDaily = "
    SELECT DATE(FROM_UNIXTIME(topupptime)) AS d,
           COALESCE(SUM(CAST(point AS DECIMAL(12,2))),0) AS total
    FROM (
      SELECT topuptime AS topupptime, point, status, topupby
      FROM pp_topup
    ) t
    WHERE topupptime >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL ? DAY))
      AND status = 1
      AND topupby != 'manual'
      AND topupby NOT LIKE '%admin%'
    GROUP BY DATE(FROM_UNIXTIME(topupptime))
    ORDER BY d ASC
  ";
  $topKV = kv_query($connect, $sqlTopDaily, 'i', [$days]);

  // labels ต่อเนื่องย้อนหลัง N วัน
  $labels = [];
  for ($i = $days; $i >= 0; $i--) {
    $labels[] = date('Y-m-d', strtotime("-{$i} day"));
  }

  $map = function(array $kv, array $labels): array {
    $out = [];
    foreach ($labels as $k) $out[] = isset($kv[$k]) ? (float)$kv[$k] : 0.0;
    return $out;
  };

  echo json_encode([
    'mode'    => 'daily',
    'days'    => $days,
    'labels'  => $labels,
    'revenue' => $map($revKV, $labels),
    'topup'   => $map($topKV, $labels),
  ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
  http_response_code(500);
  echo json_encode([
    'error'   => true,
    'message' => 'Internal Server Error',
    'detail'  => $e->getMessage(), // ปิด detail นี้ในโปรดักชันจริง
  ], JSON_UNESCAPED_UNICODE);
}
