<?php
/**
 * Dynamic Sitemap Generator
 * วางที่ root: public_html/sitemap.php
 * แล้วแก้ .htaccess ให้ sitemap.xml → sitemap.php
 */
require('system/master.php');

// Cache 24 ชั่วโมง
$cache_file = sys_get_temp_dir() . '/sitemap_cache_' . md5($_SERVER['HTTP_HOST']) . '.xml';
$cache_time = 86400; // 24hr

// ลบ cache ได้ด้วย ?clear=1 (admin only)
if (isset($_GET['clear']) && $_GET['clear'] == '1') {
    if (file_exists($cache_file)) unlink($cache_file);
}

if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_time) {
    header('Content-Type: application/xml; charset=utf-8');
    header('X-Sitemap-Cache: HIT');
    readfile($cache_file);
    exit;
}

// ============================
// CONFIG
// ============================
$base_url = 'https://th-shops.com';
$today    = date('Y-m-d');

// ============================
// Static Pages
// ============================
$static_pages = [
    ['loc' => '/',              'priority' => '1.00', 'changefreq' => 'daily'],
    ['loc' => '/article',       'priority' => '0.90', 'changefreq' => 'daily'],
    ['loc' => '/page/shop',     'priority' => '0.85', 'changefreq' => 'weekly'],
    ['loc' => '/contact',       'priority' => '0.75', 'changefreq' => 'monthly'],
    ['loc' => '/page/login',    'priority' => '0.50', 'changefreq' => 'monthly'],
    ['loc' => '/page/register', 'priority' => '0.50', 'changefreq' => 'monthly'],
];

// ============================
// Dynamic: ดึงบทความทั้งหมด
// ============================
$articles = [];
$result = $connect->query("SELECT slug, updated_at, created_at FROM pp_article WHERE status = 1 ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $lastmod = !empty($row['updated_at']) && $row['updated_at'] != '0000-00-00 00:00:00'
            ? date('Y-m-d', strtotime($row['updated_at']))
            : date('Y-m-d', strtotime($row['created_at']));
        $articles[] = [
            'loc'        => '/article/' . $row['slug'],
            'lastmod'    => $lastmod,
            'priority'   => '0.80',
            'changefreq' => 'weekly',
        ];
    }
}

// ============================
// Build XML
// ============================
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<?xml-stylesheet type="text/xsl" href="/sitemap.xsl"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

<?php foreach ($static_pages as $page): ?>
    <url>
        <loc><?= $base_url . $page['loc'] ?></loc>
        <lastmod><?= $today ?></lastmod>
        <changefreq><?= $page['changefreq'] ?></changefreq>
        <priority><?= $page['priority'] ?></priority>
    </url>
<?php endforeach; ?>

<?php foreach ($articles as $art): ?>
    <url>
        <loc><?= $base_url . htmlspecialchars($art['loc']) ?></loc>
        <lastmod><?= $art['lastmod'] ?></lastmod>
        <changefreq><?= $art['changefreq'] ?></changefreq>
        <priority><?= $art['priority'] ?></priority>
    </url>
<?php endforeach; ?>

</urlset>
<?php
$xml = ob_get_clean();

// บันทึก cache
file_put_contents($cache_file, $xml);

header('Content-Type: application/xml; charset=utf-8');
header('X-Sitemap-Cache: MISS');
header('X-Sitemap-Articles: ' . count($articles));
echo $xml;
?>