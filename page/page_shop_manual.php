<?php
// ดึงเฉพาะ “สินค้าแมนนวล” ที่เปิดแสดงหน้าเว็บ
$manuals = [];
$sql = "SELECT id, name, price_web, img, info
        FROM pp_shop_stock_api
        WHERE COALESCE(product_id,0)=0 AND COALESCE(showitem,1)=1
        ORDER BY id DESC";
$res = $connect->query($sql);
$manuals = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
?>

<!-- สไตล์เฉพาะหน้า manual -->
<style>
  .manual-wrap { max-width: 1400px; margin-inline: auto; }
  .manual-title-bar{
    display:flex; align-items:center; gap:.6rem; margin: 0 0 1rem 0;
  }
  .manual-title-bar i{ font-size:1.25rem; }
  .manual-title{ font-weight:700; font-size:clamp(18px,2.2vw,24px); margin:0; }

  .manual-search{
    max-width: 420px;
    margin-left: auto;
    border-radius: 12px;
    padding:.7rem 1rem;
    border: none;
    background: rgba(255,255,255,.35);
    outline: none;
  }

  .manual-card{
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,.08);
    overflow: hidden;
    background: #fff;
    transition: transform .15s ease, box-shadow .15s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
  }
  .manual-card:hover{
    transform: translateY(-2px);
    box-shadow: 0 16px 36px rgba(0,0,0,.12);
  }

  /* รูป 1:1 แน่นอน */
  .manual-card .ratio{ background:#f5f7ff; }
  .manual-card .ratio img{
    width:100%; height:100%; object-fit:cover;
  }

  .manual-body{
    padding: 16px 18px 14px;
    display: flex; flex-direction: column; gap: .5rem;
  }
  .manual-name{
    font-weight:700;
    font-size: clamp(16px, 1.8vw, 18px);
    margin: 0;
  }

  /* คำอธิบาย: แสดงเป็นตัวหนังสือ, เคารพ \n, ไม่ล้นกรอบ */
  .manual-desc{
    white-space: pre-wrap;          /* ให้ \n แสดงเป็นขึ้นบรรทัด */
    overflow-wrap: anywhere;        /* ตัดคำยาว ๆ ได้ */
    word-break: break-word;         /* สำรอง */
    color:#444;
    line-height: 1.55;
    font-size: clamp(13px, 1.6vw, 14px);
    margin: 0;
    min-height: 3.6em;              /* มีพื้นที่หายใจนิดนึง */
  }

  .manual-foot{
    display:flex; align-items:center; justify-content:space-between;
    padding: 0 18px 16px;
    margin-top: auto;               /* ดันให้ราคากับปุ่มไปชิดล่างเสมอ */
  }
  .manual-price{
    font-weight: 800;
    font-size: clamp(16px, 2vw, 18px);
    color:#1f4cff;
    margin:0;
  }
</style>

<div class="manual-wrap">

  <!-- หัวข้อ + ช่องค้นหา -->
  <div class="d-flex align-items-center flex-wrap gap-3 mb-3">
    <div class="manual-title-bar">
      <i class="fa-solid fa-gamepad"></i>
      <h2 class="manual-title">เติมเกมส์ (สินค้าจากร้าน)</h2>
    </div>
    <input id="manualSearch" class="manual-search ms-auto" placeholder="ค้นหาชื่อสินค้า...">
  </div>

  <!-- สินค้า -->
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="manualGrid">
    <?php foreach($manuals as $p): 
      // เตรียมคำอธิบายให้เป็น “ตัวหนังสือ” + เคารพบรรทัดใหม่
      $raw = (string)($p['info'] ?? '');
      $desc = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
      // แปลงแท็กที่ “แบ่งบรรทัด” ให้เป็น \n ก่อนค่อยลอกแท็ก
      $desc = preg_replace('/<(br|BR)\s*\/?>/i', "\n", $desc);
      $desc = preg_replace('/<\/(p|div|li|ul|ol|h[1-6])>/i', "\n", $desc);
      $desc = strip_tags($desc);
      $desc = preg_replace("/\r\n|\r|\n/", "\n", $desc);
      $desc = preg_replace("/\n{3,}/", "\n\n", $desc); // ไม่ให้เว้นยาวเกิน
      $desc = trim($desc);
    ?>
    <div class="col manual-item" data-name="<?= htmlspecialchars(mb_strtolower($p['name']), ENT_QUOTES, 'UTF-8') ?>">
      <div class="card manual-card h-100">
        <!-- รูป 1:1 -->
        <div class="ratio ratio-1x1">
          <img src="<?= htmlspecialchars($p['img'], ENT_QUOTES, 'UTF-8') ?>"
               alt="<?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="manual-body">
          <h5 class="manual-name"><?= htmlspecialchars($p['name'], ENT_QUOTES, 'UTF-8') ?></h5>
          <p class="manual-desc"><?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?></p>
        </div>

        <div class="manual-foot">
          <p class="manual-price">฿<?= number_format((float)$p['price_web'], 2) ?></p>
          <!-- ปรับลิงก์สั่งซื้อให้เข้าหน้า/ฟังก์ชันของคุณเอง -->
          <a href="#"
             class="btn btn-primary btn-sm"
             onclick="buy_manual(<?= (int)$p['id'] ?>); return false;">สั่งซื้อ</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <?php if(empty($manuals)): ?>
      <div class="col">
        <div class="alert alert-light border text-center">
          ยังไม่มีสินค้าแบบแมนนวลที่เปิดขาย
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
  // ค้นหาแบบง่าย ๆ ตามชื่อสินค้า
  (function(){
    const q = document.getElementById('manualSearch');
    const items = [...document.querySelectorAll('#manualGrid .manual-item')];

    q?.addEventListener('input', () => {
      const term = (q.value || '').toLowerCase().trim();
      items.forEach(el => {
        const name = el.dataset.name || '';
        el.style.display = name.includes(term) ? '' : 'none';
      });
    });
  })();

  // TODO: ผูกฟังก์ชันสั่งซื้อจริงของคุณ
  function buy_manual(id){
    // ตัวอย่าง: ไปหน้ารายละเอียด/สั่งซื้อ
    // location.href = 'page/product_manual?id='+id;
    alert('สั่งซื้อสินค้าไอดี #'+id+' (โปรดติดต่อแอดมินhttps://telegram.me/xthshops)');
  }
</script>
