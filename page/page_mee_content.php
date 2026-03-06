<?php
// This file is intended to be called via AJAX to refresh the latest orders.
// It needs access to $web_rows and $connect.

// Ensure essential variables are set up
require_once __DIR__ . '/../system/setting.php'; // Adjust path as needed

// Fetch web settings if not already available globally
// This is needed for web_keyapi
$web_rows = null;
if ($connect) {
    $web_settings_result = $connect->query('SELECT * FROM `pp_setting` LIMIT 1');
    if ($web_settings_result) {
        $web_rows = $web_settings_result->fetch_assoc();
    }
}

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://byshop.me/api/history',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 1,
  CURLOPT_TIMEOUT => 10, // Added a 10-second timeout
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST', // Should this be GET based on the API docs? Or POST with keyapi? Assuming POST with keyapi based on original code.
  CURLOPT_POSTFIELDS => array('keyapi' => isset($web_rows['web_keyapi']) ? $web_rows['web_keyapi'] : ''), // Use isset for safety
  CURLOPT_HTTPHEADER => array(
    'Cookie: PHPSESSID=u8df3d96ij8re36ld76cl64t3p' // Note: Hardcoded session ID is generally not recommended.
  ),
));

$response = curl_exec($curl);
$curl_error = curl_error($curl);
curl_close($curl);

$product_list_buy = '';

if ($curl_error) {
    $product_list_buy = "<p class='text-center text-danger'>เกิดข้อผิดพลาดในการดึงข้อมูล: " . htmlspecialchars($curl_error) . "</p>";
} else {
    $listbuy = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE || !$listbuy || !is_array($listbuy)) {
        $product_list_buy = '<p class="text-center text-warning">ไม่สามารถประมวลผลข้อมูลรายการสั่งซื้อล่าสุดได้ หรือไม่มีข้อมูล</p>';
    } else {
        $product_list_buy .= '<div style="overflow-x: auto; white-space: nowrap; padding-bottom: 15px;">';
        $product_list_buy .= '<div class="d-flex flex-row">';
        $item_count = 0;
        for ($i = 0; $i < min(count($listbuy), 20); $i++) { // Show up to 20 items
            if (!isset($listbuy[$i]->name) || !isset($listbuy[$i]->time)) continue;
            $image_name_prefix = substr($listbuy[$i]->name, 0, 2);
            $image_name_prefix = preg_replace("/[^a-zA-Z0-9_-]/", "", $image_name_prefix); // Sanitize for URL/filename
            if (empty($image_name_prefix)) $image_name_prefix = "default";

            $product_list_buy .= '
            <div class="d-flex flex-column align-items-center mr-3 ml-3 mt-3 text-black" style="min-width: 150px; text-align: center; border: 1px solid #eee; padding: 10px; border-radius: 8px; margin-right: 10px !important;">
                <img class="img-fluid rounded" style="height: 50px; width: 50px; object-fit: cover; margin-bottom: 5px;" src="https://byshop.me/buy/img/img_app/'. htmlspecialchars($image_name_prefix) .'.png" alt="'.htmlspecialchars($listbuy[$i]->name).'">
                <span style="font-size: 14px; white-space: normal; word-break: break-word; font-weight: bold; margin-bottom: 3px;">'. htmlspecialchars($listbuy[$i]->name) .'</span>
                <span style="font-size: 12px; color: #555; margin-bottom: 5px;">'. htmlspecialchars($listbuy[$i]->time) .'</span>
                <span class="rounded-pill badge bg-success" style="font-size: 11px;"><i class="fa fa-check-circle" aria-hidden="true"></i> ขายแล้ว !!</span>
            </div>';
            $item_count++;
        }
        if ($item_count == 0) {
            $product_list_buy .= '<p class="m-3 text-center">ยังไม่มีรายการสั่งซื้อล่าสุด</p>';
        }
        $product_list_buy .= '</div></div>'; // end d-flex & scrollable div
    }
}
echo $product_list_buy;
?>