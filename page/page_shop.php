<style>
    .top-right {
        position: absolute;
        top: 2px;
        left: 10px;
    }
    .top-right1 {
        position: absolute;
        bottom: 10px;
        right: 10px;
    }

    .shop-card {
        border: none !important;
        border-radius: 20px !important;
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.12) !important;
    }

    .shop-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(102, 126, 234, 0.25) !important;
    }

    .shop-card .card-img-wrap img {
        transition: transform 0.3s ease;
    }

    .shop-card:hover .card-img-wrap img {
        transform: scale(1.05);
    }

    .shop-card .card-img-wrap {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    .shop-card .card-img-wrap img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .shop-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        font-size: 0.78rem;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    }

    .shop-card .card-body {
        padding: 16px 18px 8px 18px;
    }

    .shop-card .card-footer-area {
        padding: 10px 18px 16px 18px;
        border-top: 1px solid rgba(226, 232, 240, 0.6);
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .shop-card h5 {
        font-weight: 700;
        color: #1a202c;
        font-size: 1rem;
        margin-bottom: 8px;
    }

    .shop-card .info-row {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.82rem;
        color: #64748b;
        margin-bottom: 4px;
    }

    .shop-card .price-tag {
        font-size: 1.1rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .shop-card .btn-buy {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .shop-card .btn-buy:hover {
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.45);
        color: white;
    }

    .shop-card .btn-info-outline {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .shop-card .btn-info-outline:hover {
        background: #667eea;
        color: white;
    }

    .shop-section-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
    }

    .shop-section-header::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
    }

    @media (max-width: 576px) {
        .shop-card .card-img-wrap img {
            width: 80px;
            height: 80px;
        }
    }
</style>

<?php include('page/page_mee.php'); ?>

<?php
$result_load_packz = $connect->query("SELECT * FROM pp_shop_stock_api WHERE showitem = 1");
if ($result_load_packz->num_rows == 0) : ?>
    <div class="col-md-12 col-sm-12 mt-2" data-aos="zoom-in-down">
        <div class="alert alert-dismissible alert-danger">
            <strong>เชื่อมต่อเซิฟเวอร์ไม่สำเร็จ!</strong> <a href="page/pshop" class="alert-link">ลองอีกครั้ง</a>.
        </div>
    </div>
<?php else: ?>

<div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
    <div class="card shadow-lg" style="background: rgba(255,255,255,0.97); border: none; border-radius: 20px; overflow: hidden;">

        <!-- Header -->
        <div class="shop-section-header">
            <h5 class="mb-0" style="font-weight: 700; position: relative; z-index: 2; display: flex; align-items: center; gap: 10px;">
                <i class='bx bx-store'></i> รายการสินค้า
                <span style="font-size: 14px; opacity: 0.8; font-weight: 400;">( ร้านค้า )</span>
            </h5>
        </div>

        <div class="card-body p-3">
            <div class="row g-3">
            <?php
            $load_packz = $result_load_packz->fetch_all(MYSQLI_ASSOC);
            foreach ($load_packz as $shop_fetch) : ?>

                <div class="col-md-31 col-sm-6 col-6">
                    <div class="card shop-card h-100" data-aos="fade-up">

                        <!-- Product Image Area -->
                        <div class="card-img-wrap" style="position: relative;">
                            <img src="<?=$shop_fetch['img']?>" alt="<?=$shop_fetch['name']?>">

                            <!-- Status Badge -->
                            <?php if ($shop_fetch['stock'] == 0): ?>
                                <span class="shop-badge badge bg-danger">
                                    <i class="fas fa-times-circle"></i> สินค้าหมด
                                </span>
                            <?php else: ?>
                                <span class="shop-badge badge bg-success">
                                    <i class="fas fa-check-circle"></i> พร้อมจำหน่าย
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <h5><?=$shop_fetch['name']?></h5>

                            <div class="info-row">
                                <i class="fa-regular fa-circle-user" style="color: #667eea;"></i>
                                คงเหลือ <strong><?=$shop_fetch['stock']?></strong> ชิ้น
                            </div>
                            <div class="info-row">
                                <i class="fa-regular fa-clock" style="color: #f093fb;"></i>
                                สถานะ: 
                                <span style="color: <?=$shop_fetch['status'] == 1 ? '#10b981' : '#ef4444'?>; font-weight: 600;">
                                    <?=$shop_fetch['status'] == 1 ? 'เปิดขาย' : 'ปิดขาย'?>
                                </span>
                            </div>

                            <?php if ($shop_fetch['stock'] == 0): ?>
                                <div class="info-row mt-1">
                                    <i class="fa-solid fa-circle-notch fa-spin text-danger"></i>
                                    <small style="color: #ef4444;">รออัพเดตสินค้า 23.59 น.</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Footer Area -->
                        <div class="card-footer-area">
                            <div class="price-tag mb-2">
                                💰 <?=number_format($shop_fetch['price_web'], 2)?> เครดิต
                            </div>

                            <button class="btn btn-info-outline w-100 mb-2" data-bs-toggle="modal" data-bs-target="#ShopModal<?=$shop_fetch['id']?>">
                                <i class="fas fa-info-circle"></i> ข้อมูลเพิ่มเติม
                            </button>

                            <?php if (isset($_SESSION['username'])): ?>
                                <button class="btn btn-buy w-100" onclick="buypremium(<?=$shop_fetch['id']?>)">
                                    <i class="fas fa-shopping-cart"></i> สั่งซื้อ (<?=number_format($shop_fetch['price_web'], 2)?> เครดิต)
                                </button>
                            <?php else: ?>
                                <button class="btn btn-buy w-100" onclick="CradURL('./page/login')">
                                    <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบเพื่อสั่งซื้อ
                                </button>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>

<!-- Modals -->
<?php foreach ($load_packz as $shop_fetch) : ?>
<div class="modal fade" id="ShopModal<?=$shop_fetch['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                <h5 class="modal-title" style="font-weight: 700;"><?=$shop_fetch['name']?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img src="<?=$shop_fetch['img']?>" class="p-2" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid #667eea; box-shadow: 0 4px 15px rgba(102,126,234,0.3);">
                    <h5 class="mt-3 mb-1" style="font-weight: 700;"><?=$shop_fetch['name']?></h5>
                    <div style="display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; margin-top: 8px;">
                        <span class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 6px 12px; border-radius: 12px;">
                            <i class="fa-regular fa-circle-user"></i> คงเหลือ <?=$shop_fetch['stock']?> ชิ้น
                        </span>
                        <span class="badge <?=$shop_fetch['stock'] == 0 ? 'bg-danger' : 'bg-success'?>" style="padding: 6px 12px; border-radius: 12px;">
                            <?=$shop_fetch['stock'] == 0 ? '❌ สินค้าหมด' : '✅ พร้อมจำหน่าย'?>
                        </span>
                    </div>
                </div>
                <div style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 12px; padding: 15px; margin-bottom: 10px;">
                    <p style="margin: 0; color: #374151; font-size: 0.95rem; line-height: 1.6;"><?=$shop_fetch['info']?></p>
                </div>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(226,232,240,0.6); background: #f8fafc;">
                <?php if (isset($_SESSION['username'])): ?>
                    <button class="btn btn-buy mb-0" onclick="buypremium(<?=$shop_fetch['id']?>)">
                        <i class="fas fa-shopping-cart"></i> สั่งซื้อ (<?=number_format($shop_fetch['price_web'], 2)?> เครดิต)
                    </button>
                <?php else: ?>
                    <button class="btn btn-buy mb-0" onclick="CradURL('./page/login')">
                        <i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบเพื่อสั่งซื้อ
                    </button>
                <?php endif; ?>
                <button type="button" class="btn btn-danger mb-0" data-bs-dismiss="modal" style="border-radius: 12px;">ปิด</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<?php endif; ?>