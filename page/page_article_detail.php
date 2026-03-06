<style>
    .detail-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
    }
    .detail-header::after {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    }
    .article-content-body {
        font-size: 1rem;
        line-height: 1.8;
        color: #374151;
    }

    /* ===== Typography สำหรับ content ที่ยิงเข้ามา ===== */
    .article-content-body h1,
    .article-content-body h2,
    .article-content-body h3,
    .article-content-body h4,
    .article-content-body h5 {
        font-weight: 800;
        color: #1a202c;
        margin-top: 28px;
        margin-bottom: 12px;
        line-height: 1.4;
    }
    .article-content-body h1 { font-size: 1.7rem; }
    .article-content-body h2 {
        font-size: 1.35rem;
        padding-bottom: 8px;
        border-bottom: 2px solid #ede9fe;
    }
    .article-content-body h3 { font-size: 1.1rem; color: #4c1d95; }
    .article-content-body h4 { font-size: 1rem; }

    .article-content-body p {
        margin-bottom: 14px;
        color: #374151;
    }

    .article-content-body ul,
    .article-content-body ol {
        margin: 10px 0 16px 22px;
        padding-left: 10px;
    }
    .article-content-body ul { list-style: disc; }
    .article-content-body ol { list-style: decimal; }
    .article-content-body li {
        margin-bottom: 8px;
        color: #374151;
        line-height: 1.7;
    }
    .article-content-body li::marker {
        color: #667eea;
        font-weight: 700;
    }

    .article-content-body a {
        color: #667eea;
        font-weight: 600;
        text-decoration: underline;
        text-decoration-color: rgba(102,126,234,0.35);
        transition: all 0.2s ease;
    }
    .article-content-body a:hover {
        color: #764ba2;
        text-decoration-color: #764ba2;
    }

    .article-content-body strong,
    .article-content-body b {
        font-weight: 700;
        color: #1a202c;
    }

    .article-content-body em { font-style: italic; color: #64748b; }

    .article-content-body blockquote {
        border-left: 4px solid #667eea;
        background: #f5f3ff;
        padding: 14px 18px;
        border-radius: 0 12px 12px 0;
        margin: 16px 0;
        color: #4c1d95;
        font-style: italic;
    }

    .article-content-body table {
        width: 100%; border-collapse: collapse;
        margin: 16px 0; border-radius: 12px; overflow: hidden;
    }
    .article-content-body table th {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white; padding: 10px 14px; text-align: left;
        font-weight: 700;
    }
    .article-content-body table td {
        padding: 10px 14px; border-bottom: 1px solid #f1f5f9;
        color: #374151;
    }
    .article-content-body table tr:nth-child(even) td { background: #fafafa; }

    .article-content-body .faq { margin-top: 24px; }
    .article-content-body .faq h2 { font-size: 1.25rem; }
    .article-content-body .faq ul { list-style: none; margin-left: 0; padding-left: 0; }
    .article-content-body .faq li {
        background: #f8f7ff;
        border-left: 4px solid #667eea;
        border-radius: 0 12px 12px 0;
        padding: 14px 16px;
        margin-bottom: 12px;
    }
    .article-content-body .faq li strong {
        display: block; margin-bottom: 6px;
        color: #4c1d95; font-size: 0.95rem;
    }
    .article-content-body .faq li p { margin: 0; color: #374151; font-size: 0.9rem; }

    .article-content-body img {
        max-width: 100%;
        border-radius: 12px;
        margin: 10px 0;
    }
    .article-cover-img {
        width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 15px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(102,126,234,0.2);
    }
    .cover-placeholder {
        width: 100%;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        margin-bottom: 20px;
    }
    .article-meta-bar {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 12px 18px;
        margin-bottom: 20px;
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }
    .btn-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        padding: 8px 20px;
        transition: all 0.2s ease;
    }
    .btn-back:hover {
        box-shadow: 0 6px 15px rgba(102,126,234,0.4);
        color: white;
    }
</style>

<?php
    $slug = isset($_GET['slug']) ? $connect->real_escape_string(trim($_GET['slug'])) : '';
    // รองรับทั้ง slug และ id (backward compatible)
    if (!empty($slug)) {
        $result_article = $connect->query("SELECT * FROM pp_article WHERE slug = '$slug' AND status = 1 LIMIT 1");
    } else {
        $article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $result_article = $connect->query("SELECT * FROM pp_article WHERE id = $article_id AND status = 1 LIMIT 1");
    }

    if (!$result_article || $result_article->num_rows == 0):
?>
    <div class="col-md-12 mt-4">
        <div class="alert alert-danger" style="border-radius: 15px;">
            <i class="fas fa-exclamation-circle"></i> ไม่พบบทความที่ต้องการ
            <a href="?page=article" class="alert-link ms-2">กลับไปหน้าบทความ</a>
        </div>
    </div>
<?php else:
    $article = $result_article->fetch_assoc();
    // เพิ่ม views
    $connect->query("UPDATE pp_article SET views = views + 1 WHERE id = " . (int)$article['id']);
?>
<?php if (!empty($article['json_schema'])): ?>
<script type="application/ld+json">
<?=$article['json_schema']?>
</script>
<?php endif; ?>

<div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
    <div class="card shadow-lg" style="background: rgba(255,255,255,0.97); border: none; border-radius: 20px; overflow: hidden;">

        <!-- Header -->
        <div class="detail-header">
            <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 10px;">
                <button class="btn btn-sm btn-light" onclick="window.location.href='?page=article'" style="border-radius: 10px; font-weight: 600;">
                    <i class="fas fa-arrow-left"></i> กลับ
                </button>
                <span style="font-weight: 700; font-size: 1rem;">
                    <i class='bx bx-news'></i> บทความ
                </span>
            </div>
        </div>

        <div class="card-body p-4">

            <!-- รูปภาพหน้าปก -->
            <?php if (!empty($article['img'])): ?>
                <img src="<?=htmlspecialchars($article['img'])?>" class="article-cover-img" alt="<?=htmlspecialchars($article['title'])?>">
            <?php else: ?>
                <div class="cover-placeholder"><i class='bx bx-news'></i></div>
            <?php endif; ?>

            <!-- Category Badge -->
            <div class="mb-2">
                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                    <?=htmlspecialchars($article['category'])?>
                </span>
            </div>

            <!-- Title -->
            <h2 style="font-weight: 800; color: #1a202c; margin: 12px 0;"><?=htmlspecialchars($article['title'])?></h2>

            <!-- Meta Bar -->
            <div class="article-meta-bar">
                <span><i class="fas fa-user-circle" style="color: #667eea;"></i> <?=htmlspecialchars($article['author'])?></span>
                <span><i class="fas fa-calendar-alt" style="color: #f093fb;"></i> <?=date('d/m/Y H:i', strtotime($article['created_at']))?></span>
                <span><i class="fas fa-eye" style="color: #10b981;"></i> <?=number_format($article['views'])?> ครั้ง</span>
                <?php if ($article['updated_at'] != $article['created_at']): ?>
                    <span><i class="fas fa-edit" style="color: #f59e0b;"></i> แก้ไขล่าสุด <?=date('d/m/Y', strtotime($article['updated_at']))?></span>
                <?php endif; ?>
            </div>

            <!-- เนื้อหา -->
            <div class="article-content-body">
                <?=$article['content']?>
            </div>

            <hr style="border-color: rgba(226,232,240,0.6); margin: 25px 0;">

            <!-- ปุ่มกลับ -->
            <a href="?page=article" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> กลับไปหน้าบทความ
            </a>

        </div>
    </div>
</div>

<?php endif; ?>