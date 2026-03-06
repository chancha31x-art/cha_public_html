<!-- ==========================================
     ส่วนบทความล่าสุด + FAQ สำหรับหน้าแรก
     วางไฟล์นี้ไว้ใน: page/page_home_article_faq.php
     แล้ว include ใน index.php ก่อน footer
     ========================================== -->

<style>
/* ========== LATEST ARTICLES ========== */
.home-articles-section {
    margin: 40px 0 20px 0;
}
.home-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.home-section-title {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1a202c;
    display: flex;
    align-items: center;
    gap: 10px;
}
.home-section-title span.dot {
    width: 10px; height: 10px;
    background: linear-gradient(135deg, #667eea, #f093fb);
    border-radius: 50%;
    display: inline-block;
}
.btn-view-all {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; border: none; border-radius: 50px;
    font-weight: 600; font-size: 0.85rem;
    padding: 8px 20px; transition: all 0.2s ease;
    text-decoration: none;
}
.btn-view-all:hover {
    box-shadow: 0 6px 15px rgba(102,126,234,0.4);
    color: white; transform: translateY(-2px);
}

/* Article Cards */
.home-article-card {
    border: none !important;
    border-radius: 18px !important;
    overflow: hidden;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
    cursor: pointer;
    background: white;
    height: 100%;
}
.home-article-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 20px 40px rgba(102,126,234,0.2) !important;
}
.home-art-img-wrap {
    width: 100%;
    aspect-ratio: 1920 / 450;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
}
.home-art-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: center;
    transition: transform 0.4s ease;
}
.home-article-card:hover .home-art-img-wrap img {
    transform: scale(1.06);
}
.home-art-img-placeholder {
    width: 100%; aspect-ratio: 1920 / 450;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; color: rgba(255,255,255,0.6);
}
.home-art-category {
    position: absolute; top: 12px; left: 12px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white; padding: 4px 12px; border-radius: 20px;
    font-size: 0.72rem; font-weight: 700;
    box-shadow: 0 2px 8px rgba(102,126,234,0.4);
}
.home-art-body { padding: 16px; }
.home-art-title {
    font-weight: 700; color: #1a202c; font-size: 0.95rem;
    line-height: 1.45;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 8px;
}
.home-art-excerpt {
    font-size: 0.82rem; color: #64748b; line-height: 1.55;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    margin-bottom: 12px;
}
.home-art-meta {
    font-size: 0.75rem; color: #94a3b8;
    display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
}
.home-art-meta i { color: #c4b5fd; }

/* ========== FAQ SECTION ========== */
.faq-section {
    margin: 50px 0 30px 0;
}
.faq-section-header {
    text-align: center;
    margin-bottom: 35px;
}
.faq-section-header h2 {
    font-size: 1.8rem; font-weight: 800; color: #1a202c;
    margin-bottom: 8px;
}
.faq-section-header p {
    color: #64748b; font-size: 0.95rem;
}
.faq-section-header .faq-badge {
    display: inline-block;
    background: linear-gradient(135deg, #667eea, #f093fb);
    color: white; padding: 5px 18px; border-radius: 20px;
    font-size: 0.8rem; font-weight: 700; margin-bottom: 12px;
}

.faq-item {
    background: white;
    border-radius: 16px;
    margin-bottom: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    overflow: hidden;
    transition: box-shadow 0.2s ease;
    border: 1.5px solid rgba(226,232,240,0.8);
}
.faq-item:hover {
    box-shadow: 0 6px 20px rgba(102,126,234,0.12);
    border-color: rgba(102,126,234,0.3);
}
.faq-question {
    width: 100%; background: none; border: none;
    padding: 18px 22px; text-align: left;
    display: flex; justify-content: space-between; align-items: center;
    cursor: pointer; gap: 15px;
    font-size: 0.95rem; font-weight: 700; color: #1a202c;
    transition: color 0.2s ease;
}
.faq-question:hover { color: #667eea; }
.faq-question.active { color: #667eea; }
.faq-icon {
    width: 30px; height: 30px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; color: #667eea;
    transition: all 0.3s ease;
}
.faq-question.active .faq-icon {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white; transform: rotate(45deg);
}
.faq-answer {
    display: none;
    padding: 0 22px 18px 22px;
    font-size: 0.88rem; color: #475569; line-height: 1.7;
    border-top: 1px solid rgba(226,232,240,0.5);
    padding-top: 14px;
}
.faq-answer.show { display: block; animation: fadeInDown 0.25s ease; }

@keyframes fadeInDown {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.faq-num {
    display: inline-flex; align-items: center; justify-content: center;
    width: 26px; height: 26px; border-radius: 8px; flex-shrink: 0;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white; font-size: 0.75rem; font-weight: 800;
    margin-right: 4px;
}
</style>

<?php
/* ========== ดึงบทความล่าสุด 3 รายการ ========== */
$result_home_articles = $connect->query("SELECT * FROM pp_article WHERE status = 1 ORDER BY created_at DESC LIMIT 3");
$home_articles = $result_home_articles ? $result_home_articles->fetch_all(MYSQLI_ASSOC) : [];
?>

<?php if (count($home_articles) > 0): ?>
<!-- ===== LATEST ARTICLES ===== -->
<div class="col-md-12 col-sm-12 col-12 home-articles-section" data-aos="fade-up">
    <div class="home-section-header">
        <div class="home-section-title">
            <span class="dot"></span>
            <i class='bx bx-news' style="color:#667eea;"></i> บทความล่าสุด
        </div>
        <a href="/article" class="btn-view-all">
            ดูทั้งหมด <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3">
        <?php foreach ($home_articles as $i => $art):
            $excerpt = mb_substr(strip_tags($art['content']), 0, 100, 'UTF-8') . '...';
        ?>
            <div class="col-md-4 col-sm-6 col-12" data-aos="fade-up" data-aos-delay="<?=($i * 100)?>">
                <div class="home-article-card card" onclick="window.location.href='/article/<?=$art['slug']?>'">
                    <div class="home-art-img-wrap">
                        <?php if (!empty($art['img'])): ?>
                            <img src="<?=htmlspecialchars($art['img'])?>" alt="<?=htmlspecialchars($art['title'])?>">
                        <?php else: ?>
                            <div class="home-art-img-placeholder"><i class='bx bx-news'></i></div>
                        <?php endif; ?>
                        <span class="home-art-category"><?=htmlspecialchars($art['category'])?></span>
                    </div>
                    <div class="home-art-body">
                        <div class="home-art-title"><?=htmlspecialchars($art['title'])?></div>
                        <div class="home-art-excerpt"><?=$excerpt?></div>
                        <div class="home-art-meta">
                            <span><i class="fas fa-user-circle"></i> <?=htmlspecialchars($art['author'])?></span>
                            <span><i class="fas fa-calendar-alt"></i> <?=date('d/m/Y', strtotime($art['created_at']))?></span>
                            <span><i class="fas fa-eye"></i> <?=number_format($art['views'])?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>


<!-- ===== FAQ SECTION ===== -->
<div class="col-md-12 col-sm-12 col-12 faq-section" data-aos="fade-up">
    <div class="faq-section-header">
        <div class="faq-badge">❓ FAQ</div>
        <h2>คำถามที่พบบ่อย</h2>
        <p>รวมคำถามและคำตอบที่ลูกค้าถามบ่อย</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">

            <?php
            $faqs = [
                [
                    'q' => 'สินค้าที่ซื้อได้รับทันทีไหม?',
                    'a' => 'ได้รับทันทีหลังชำระเงินสำเร็จครับ ระบบจะส่งข้อมูลให้อัตโนมัติ ไม่ต้องรอ'
                ],
                [
                    'q' => 'ชำระเงินได้ช่องทางไหนบ้าง?',
                    'a' => 'รองรับการเติมเงินผ่านระบบของเรา สามารถเติมเงินเข้ากระเป๋าแล้วนำไปซื้อสินค้าได้ทันที'
                ],
                [
                    'q' => 'ถ้าสินค้าไม่ทำงานหรือมีปัญหาต้องทำอย่างไร?',
                    'a' => 'ติดต่อทีมงานผ่าน Line หรือ Facebook ของเราได้ตลอด 24 ชั่วโมง ทีมงานพร้อมช่วยเหลือทุกปัญหา'
                ],
                [
                    'q' => 'บัญชีที่ขายเป็นบัญชีแท้หรือไม่?',
                    'a' => 'ทุกสินค้าในร้านเป็นของแท้ 100% รับประกันจากร้านค้า มีระบบตรวจสอบก่อนจำหน่ายทุกครั้ง'
                ],
                [
                    'q' => 'สมัครสมาชิกมีค่าใช้จ่ายไหม?',
                    'a' => 'สมัครสมาชิกฟรี ไม่มีค่าใช้จ่าย สามารถสมัครและเริ่มช้อปปิ้งได้ทันที'
                ],
                [
                    'q' => 'มีโปรโมชั่นหรือส่วนลดไหม?',
                    'a' => 'มีโปรโมชั่นอัปเดตอยู่เสมอ ติดตามได้ที่ Facebook ของเรา หรือดูแบนเนอร์บนเว็บได้เลยครับ'
                ],
            ];
            ?>

            <?php foreach ($faqs as $i => $faq): ?>
                <div class="faq-item" data-aos="fade-up" data-aos-delay="<?=($i * 60)?>">
                    <button class="faq-question" onclick="toggleFaq(this)">
                        <span style="display:flex;align-items:center;gap:10px;">
                            <span class="faq-num"><?=($i+1)?></span>
                            <?=$faq['q']?>
                        </span>
                        <span class="faq-icon"><i class="fas fa-plus"></i></span>
                    </button>
                    <div class="faq-answer">
                        <i class="fas fa-check-circle" style="color:#10b981;margin-right:6px;"></i>
                        <?=$faq['a']?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>

<script>
function toggleFaq(btn) {
    const answer = btn.nextElementSibling;
    const allBtns    = document.querySelectorAll('.faq-question');
    const allAnswers = document.querySelectorAll('.faq-answer');

    // ปิดทุกอันก่อน
    allBtns.forEach(b => b.classList.remove('active'));
    allAnswers.forEach(a => a.classList.remove('show'));

    // เปิดอันที่กด (ถ้ายังไม่เปิด)
    if (!answer.classList.contains('show')) {
        btn.classList.add('active');
        answer.classList.add('show');
    }
}
</script>