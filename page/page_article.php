<style>
    .article-card {
        border: none !important;
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.12) !important;
        cursor: pointer;
    }
    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(102, 126, 234, 0.25) !important;
    }
    .article-img-wrap {
        width: 100%;
        aspect-ratio: 1920 / 450;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .article-img-wrap {
        width: 100%;
        aspect-ratio: 1920 / 450;
        overflow: hidden;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .article-card .article-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        display: block;
        transition: transform 0.3s ease;
    }
    .article-card:hover .article-img {
        transform: scale(1.03);
    }
    .article-img-placeholder {
        width: 100%;
        aspect-ratio: 1920 / 450;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
    }
    .article-category-badge {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
    }
    .article-title {
        font-weight: 700;
        color: #1a202c;
        font-size: 1rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .article-excerpt {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .article-meta {
        font-size: 0.78rem;
        color: #94a3b8;
    }
    .search-box {
        border-radius: 50px !important;
        border: 2px solid #667eea !important;
        padding: 10px 20px !important;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }
    .search-box:focus {
        box-shadow: 0 0 0 4px rgba(102,126,234,0.15) !important;
        outline: none;
    }
    .search-btn {
        border-radius: 50px !important;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .search-btn:hover {
        box-shadow: 0 6px 15px rgba(102,126,234,0.4);
        color: white;
    }
    .article-section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
    }
    .article-section-header::after {
        content: '';
        position: absolute;
        top: -50%; right: -50%;
        width: 200%; height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    }
    .btn-read-more {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        transition: all 0.2s ease;
    }
    .btn-read-more:hover {
        box-shadow: 0 6px 15px rgba(102,126,234,0.4);
        color: white;
    }
    .no-article {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    .no-article i {
        font-size: 3.5rem;
        margin-bottom: 15px;
        opacity: 0.5;
    }
</style>

<?php
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $where = "WHERE status = 1";
    if ($search) {
        $search_safe = $connect->real_escape_string($search);
        $where .= " AND (title LIKE '%$search_safe%' OR content LIKE '%$search_safe%' OR category LIKE '%$search_safe%')";
    }
    $result_articles = $connect->query("SELECT * FROM pp_article $where ORDER BY created_at DESC");
    $articles = $result_articles ? $result_articles->fetch_all(MYSQLI_ASSOC) : [];
?>

<div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
    <div class="card shadow-lg" style="background: rgba(255,255,255,0.97); border: none; border-radius: 20px; overflow: hidden;">

        <!-- Header -->
        <div class="article-section-header">
            <h5 class="mb-0" style="font-weight: 700; position: relative; z-index: 2; display: flex; align-items: center; gap: 10px;">
                <i class='bx bx-news'></i> บทความ
                <span style="font-size: 14px; opacity: 0.8; font-weight: 400;">( <?=count($articles)?> บทความ )</span>
            </h5>
        </div>

        <div class="card-body p-3">

            <!-- Search Bar -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-7 col-sm-12">
                    <form method="GET" action="">
                        <input type="hidden" name="page" value="article">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-box" 
                                   placeholder="🔍 ค้นหาบทความ..." 
                                   value="<?=htmlspecialchars($search)?>">
                            <button type="submit" class="btn search-btn ms-2">
                                <i class="fas fa-search"></i> ค้นหา
                            </button>
                            <?php if ($search): ?>
                                <a href="?page=article" class="btn btn-outline-secondary ms-2" style="border-radius: 50px;">
                                    <i class="fas fa-times"></i> ล้าง
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($search): ?>
                <div class="mb-3 px-1" style="color: #667eea; font-weight: 600;">
                    <i class="fas fa-search"></i> ผลการค้นหา "<strong><?=htmlspecialchars($search)?></strong>" — พบ <?=count($articles)?> บทความ
                </div>
            <?php endif; ?>

            <!-- Article Grid -->
            <?php if (count($articles) > 0): ?>
                <div class="row g-3">
                    <?php foreach ($articles as $article): 
                        // ตัดเนื้อหา HTML ออกเพื่อทำ excerpt
                        $excerpt = strip_tags($article['content']);
                        $excerpt = mb_substr($excerpt, 0, 120, 'UTF-8') . '...';
                    ?>
                        <div class="col-md-4 col-sm-6 col-12" data-aos="fade-up">
                            <div class="card article-card h-100" onclick="window.location.href='/article/<?=$article['slug']?>'">

                                <!-- รูปภาพ -->
                                <?php if (!empty($article['img'])): ?>
                                    <div class="article-img-wrap">
                                        <img src="<?=htmlspecialchars($article['img'])?>" class="article-img" alt="<?=htmlspecialchars($article['title'])?>">
                                    </div>
                                <?php else: ?>
                                    <div class="article-img-placeholder">
                                        <i class='bx bx-news'></i>
                                    </div>
                                <?php endif; ?>

                                <div class="card-body d-flex flex-column">
                                    <!-- Category -->
                                    <div class="mb-2">
                                        <span class="article-category-badge"><?=htmlspecialchars($article['category'])?></span>
                                    </div>

                                    <!-- Title -->
                                    <h6 class="article-title mb-2"><?=htmlspecialchars($article['title'])?></h6>

                                    <!-- Excerpt -->
                                    <p class="article-excerpt mb-3"><?=$excerpt?></p>

                                    <!-- Meta -->
                                    <div class="article-meta mb-3 mt-auto">
                                        <i class="fas fa-user-circle"></i> <?=htmlspecialchars($article['author'])?>
                                        &nbsp;|&nbsp;
                                        <i class="fas fa-calendar-alt"></i> <?=date('d/m/Y', strtotime($article['created_at']))?>
                                        &nbsp;|&nbsp;
                                        <i class="fas fa-eye"></i> <?=number_format($article['views'])?>
                                    </div>

                                    <button class="btn btn-read-more w-100">
                                        <i class="fas fa-book-open"></i> อ่านต่อ
                                    </button>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            <?php else: ?>
                <div class="no-article">
                    <i class='bx bx-news d-block'></i>
                    <h5 style="color: #94a3b8;">
                        <?=$search ? 'ไม่พบบทความที่ค้นหา' : 'ยังไม่มีบทความ'?>
                    </h5>
                    <?php if ($search): ?>
                        <a href="?page=article" class="btn btn-read-more mt-2">ดูบทความทั้งหมด</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>