<?php
require('../system/master.php');

// ============================
// CONFIG - ตั้งค่า API Key
// ============================
define('API_SECRET_KEY', '#8^-@Wr%^wC4=Dl,');

// ============================
// Headers
// ============================
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type, X-API-Key');

// ============================
// Helper: Response
// ============================
function response($success, $message, $data = null, $code = 200) {
    http_response_code($code);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data'    => $data,
        'time'    => date('Y-m-d H:i:s')
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

// ============================
// Helper: Status Label
// ============================
function statusLabel($status) {
    $labels = [
        0 => 'ซ่อน',
        1 => 'เผยแพร่',
        2 => 'ดราฟ'
    ];
    return isset($labels[$status]) ? $labels[$status] : 'ไม่ทราบ';
}

// ============================
// Auth: ตรวจสอบ API Key
// ============================
$api_key = '';

if (isset($_SERVER['HTTP_X_API_KEY'])) {
    $api_key = $_SERVER['HTTP_X_API_KEY'];
} elseif (isset($_POST['api_key'])) {
    $api_key = $_POST['api_key'];
} else {
    $body = json_decode(file_get_contents('php://input'), true);
    $api_key = isset($body['api_key']) ? $body['api_key'] : '';
}

if ($api_key !== API_SECRET_KEY) {
    response(false, 'Unauthorized: Invalid API Key', null, 401);
}

// ============================
// รับข้อมูลจาก n8n
// ============================
$body = json_decode(file_get_contents('php://input'), true);

function getParam($key, $default = '') {
    global $body;
    if (isset($body[$key])) return $body[$key];
    if (isset($_POST[$key])) return $_POST[$key];
    return $default;
}

// ============================
// Route
// ============================
$action = isset($_GET['action']) ? $_GET['action'] : getParam('action', 'create');

// ----------------------------
// CREATE
// ----------------------------
if ($action === 'create') {

    $title    = trim(getParam('title'));
    $content  = trim(getParam('content'));
    $category = trim(getParam('category', 'ทั่วไป'));
    $author   = trim(getParam('author', 'Auto'));
    $img              = trim(getParam('img', ''));
    $status           = (int) getParam('status', 2); // default = ดราฟ
    $meta_title       = trim(getParam('meta_title', ''));
    $meta_description = trim(getParam('meta_description', ''));

    // Validate
    if (empty($title))   response(false, 'กรุณาระบุ title', null, 400);
    if (empty($content)) response(false, 'กรุณาระบุ content', null, 400);

    // Validate status (0=ซ่อน, 1=เผยแพร่, 2=ดราฟ)
    if (!in_array($status, [0, 1, 2])) {
        response(false, 'status ต้องเป็น 0 (ซ่อน), 1 (เผยแพร่) หรือ 2 (ดราฟ)', null, 400);
    }

    // Auto slug
    $slug_raw = getParam('slug', $title);
    $slug = preg_replace('/\s+/', '-', strtolower($slug_raw));
    $slug = preg_replace('/[^\w\-]+/', '', $slug);
    $slug = preg_replace('/\-\-+/', '-', $slug);
    $slug = trim($slug, '-');

    // ถ้า slug ซ้ำเพิ่ม timestamp
    $check_slug = $connect->query("SELECT id FROM pp_article WHERE slug = '" . $connect->real_escape_string($slug) . "' LIMIT 1");
    if ($check_slug && $check_slug->num_rows > 0) {
        $slug = $slug . '-' . time();
    }

    // Escape
    $title    = $connect->real_escape_string($title);
    $content  = $connect->real_escape_string($content);
    $category = $connect->real_escape_string($category);
    $author   = $connect->real_escape_string($author);
    $img      = $connect->real_escape_string($img);
    $slug     = $connect->real_escape_string($slug);

    $sql = "INSERT INTO pp_article (title, slug, content, img, category, author, status, meta_title, meta_description, created_at)
            VALUES ('$title', '$slug', '$content', '$img', '$category', '$author', $status, '$meta_title', '$meta_description', NOW())";

    if ($connect->query($sql)) {
        $new_id = $connect->insert_id;
        response(true, 'สร้างบทความสำเร็จ', [
            'id'               => $new_id,
            'title'            => $title,
            'slug'             => $slug,
            'category'         => $category,
            'author'           => $author,
            'status'           => $status,
            'status_label'     => statusLabel($status),
            'meta_title'       => $meta_title,
            'meta_description' => $meta_description,
            'url'              => '/article/' . $slug
        ]);
    } else {
        response(false, 'เกิดข้อผิดพลาด: ' . $connect->error, null, 500);
    }

// ----------------------------
// PUBLISH (ดราฟ → เผยแพร่)
// ----------------------------
} elseif ($action === 'publish') {

    $pub_id = (int) getParam('id', 0);
    if ($pub_id <= 0) response(false, 'กรุณาระบุ id', null, 400);

    $connect->query("UPDATE pp_article SET status = 1 WHERE id = $pub_id");
    response(true, 'เผยแพร่บทความ id=' . $pub_id . ' สำเร็จ', [
        'id'           => $pub_id,
        'status'       => 1,
        'status_label' => 'เผยแพร่'
    ]);

// ----------------------------
// UPDATE STATUS
// ----------------------------
} elseif ($action === 'update_status') {

    $upd_id = (int) getParam('id', 0);
    $new_status = (int) getParam('status', 2);

    if ($upd_id <= 0) response(false, 'กรุณาระบุ id', null, 400);
    if (!in_array($new_status, [0, 1, 2])) {
        response(false, 'status ต้องเป็น 0 (ซ่อน), 1 (เผยแพร่) หรือ 2 (ดราฟ)', null, 400);
    }

    $connect->query("UPDATE pp_article SET status = $new_status WHERE id = $upd_id");
    response(true, 'อัปเดต status สำเร็จ', [
        'id'           => $upd_id,
        'status'       => $new_status,
        'status_label' => statusLabel($new_status)
    ]);

// ----------------------------
// LIST
// ----------------------------
} elseif ($action === 'list') {

    $limit      = (int) getParam('limit', 10);
    $offset     = (int) getParam('offset', 0);
    $filter     = getParam('status', 'all'); // all | 0 | 1 | 2

    $where = '';
    if ($filter !== 'all' && in_array((int)$filter, [0, 1, 2])) {
        $where = "WHERE status = " . (int)$filter;
    }

    $result = $connect->query("SELECT id, title, slug, category, author, status, views, created_at 
                               FROM pp_article $where ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
    $articles = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

    // เพิ่ม status_label ทุกแถว
    foreach ($articles as &$art) {
        $art['status_label'] = statusLabel((int)$art['status']);
    }

    $total = $connect->query("SELECT COUNT(*) as c FROM pp_article $where")->fetch_assoc()['c'];

    response(true, 'OK', [
        'total'    => (int)$total,
        'limit'    => $limit,
        'offset'   => $offset,
        'articles' => $articles
    ]);

// ----------------------------
// DELETE
// ----------------------------
} elseif ($action === 'delete') {

    $del_id = (int) getParam('id', 0);
    if ($del_id <= 0) response(false, 'กรุณาระบุ id', null, 400);
    $connect->query("DELETE FROM pp_article WHERE id = $del_id");
    response(true, 'ลบบทความ id=' . $del_id . ' สำเร็จ');

} else {
    response(false, 'action ไม่ถูกต้อง ใช้ได้: create | publish | update_status | list | delete', null, 400);
}
?>