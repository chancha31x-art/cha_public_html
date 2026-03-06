<?php
// ==================== สินค้าแบบแมนนวล (ใช้สำหรับบริการเติมเกม ฯลฯ) ====================

// ดึงเฉพาะ “สินค้าที่เป็นของเราเอง” (product_id = 0 หรือ NULL)
$sql = "SELECT * 
        FROM pp_shop_stock_api 
        WHERE COALESCE(product_id,0) = 0
        ORDER BY id DESC";
$result   = $connect->query($sql);
$products = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>

<!-- คอลัมน์ซ้าย: เนื้อหา -->
<div class="col-md-9 col-sm-12" data-aos="fade-up">
  <div class="card card-hover shadow-lg px-4 py-3" style="background-color:#e6eeff;">
    <h5 class="card-title"><i class="fa-solid fa-gamepad"></i> สินค้าแบบแมนนวล (บริการเติมเกม/บริการต่าง ๆ)</h5>
    <hr>

    <div class="text-end">
      <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#createProductModal">
        <i class="fa-solid fa-plus"></i> เพิ่มสินค้า (แมนนวล)
      </button>
    </div>

    <div class="table-responsive mt-3">
      <div style="overflow-x:auto;">
        <table id="tbl_manual" class="table table-striped table-bordered display text-dark" cellspacing="1">
          <thead>
            <tr>
              <th>#</th>
              <th><i class="fa-solid fa-tag"></i> สินค้า</th>
              <th><i class="fa-solid fa-credit-card"></i> ราคาเรา</th>
              <th><i class="fa-solid fa-boxes-stacked"></i> สต็อก</th>
              <th><i class="fa-solid fa-eye"></i> สถานะ</th>
              <th><i class="fa-solid fa-clock"></i> จัดการ</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td><?= (int)$p['id']; ?></td>
              <td><?= htmlspecialchars($p['name']); ?></td>
              <td><?= number_format((float)$p['price_web'], 2); ?></td>
              <td><?= (int)$p['stock']; ?></td>

              <?php if ((int)$p['showitem'] === 1): ?>
                <td><span class="badge bg-success"><i class="fa-solid fa-check"></i> เปิด</span></td>
              <?php else: ?>
                <td><span class="badge bg-danger"><i class="fa-solid fa-xmark"></i> ปิด</span></td>
              <?php endif; ?>

              <td>
                <button type="button" class="btn btn-sm btn-warning mb-1"
                        data-bs-toggle="modal" data-bs-target="#editModal<?= (int)$p['id']; ?>">
                  <i class="fa-regular fa-pen-to-square"></i> แก้ไข
                </button>

                <?php if ((int)$p['showitem'] === 1): ?>
                  <button type="button" class="btn btn-sm btn-success mb-1" onclick="showshop(<?= (int)$p['id']; ?>)">
                    <i class="fa-solid fa-eye"></i> เปิด
                  </button>
                <?php else: ?>
                  <button type="button" class="btn btn-sm btn-danger mb-1" onclick="showshop(<?= (int)$p['id']; ?>)">
                    <i class="fa-solid fa-eye-slash"></i> ปิด
                  </button>
                <?php endif; ?>

                <button type="button" class="btn btn-sm btn-outline-danger mb-1"
                        onclick="delete_shop(<?= (int)$p['id']; ?>)">
                  <i class="fa-solid fa-trash-can"></i> ลบ
                </button>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /คอลัมน์ซ้าย -->

<?php foreach ($products as $p): ?>
<!-- Modal: แก้ไขสินค้า -->
<div class="modal fade" id="editModal<?= (int)$p['id']; ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-regular fa-pen-to-square"></i>
          แก้ไข: <?= htmlspecialchars($p['name']); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label"><i class="fa-solid fa-tag"></i> ชื่อสินค้า</label>
            <input id="name<?= (int)$p['id']; ?>" class="form-control" value="<?= htmlspecialchars($p['name']); ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-toggle-on"></i> แสดงหน้าเว็บ</label>
            <select id="showitem<?= (int)$p['id']; ?>" class="form-select">
              <option value="1" <?= (int)$p['showitem']===1?'selected':''; ?>>เปิด</option>
              <option value="0" <?= (int)$p['showitem']===0?'selected':''; ?>>ปิด</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-coins"></i> ราคาเรา (บาท)</label>
            <input id="price_web<?= (int)$p['id']; ?>" type="number" step="0.01" min="0" class="form-control"
                   value="<?= htmlspecialchars($p['price_web']); ?>">
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-boxes-stacked"></i> สต็อก</label>
            <input id="stock<?= (int)$p['id']; ?>" type="number" min="0" class="form-control"
                   value="<?= (int)$p['stock']; ?>">
          </div>
          <div class="col-12">
            <label class="form-label"><i class="fa-regular fa-image"></i> URL รูปสินค้า</label>
            <input id="img<?= (int)$p['id']; ?>" class="form-control" value="<?= htmlspecialchars($p['img']); ?>">
          </div>
          <div class="col-12">
            <label class="form-label"><i class="fa-solid fa-info-circle"></i> รายละเอียด</label>
            <textarea id="info<?= (int)$p['id']; ?>" rows="4" class="form-control"><?= htmlspecialchars($p['info']); ?></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-success"
                onclick="edit_shop_api(<?= (int)$p['id']; ?>)">
          <i class="fa-solid fa-floppy-disk"></i> บันทึก
        </button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- Modal: เพิ่มสินค้า (แมนนวล) -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="createProductForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-box"></i> เพิ่มสินค้า (แมนนวล)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label"><i class="fa-solid fa-tag"></i> ชื่อสินค้า</label>
            <input name="name" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-toggle-on"></i> แสดงหน้าเว็บ</label>
            <select name="showitem" class="form-select">
              <option value="1" selected>เปิด</option>
              <option value="0">ปิด</option>
            </select>
          </div>

          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-coins"></i> ราคาเรา (บาท)</label>
            <input name="price_web" type="number" step="0.01" min="0" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label class="form-label"><i class="fa-solid fa-boxes-stacked"></i> สต็อก</label>
            <input name="stock" type="number" min="0" class="form-control" value="0" required>
          </div>
          <div class="col-12">
            <label class="form-label"><i class="fa-regular fa-image"></i> URL รูปสินค้า</label>
            <input name="img" class="form-control" placeholder="https://...">
          </div>
          <div class="col-12">
            <label class="form-label"><i class="fa-solid fa-info-circle"></i> รายละเอียด</label>
            <textarea name="info" rows="4" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> บันทึกสินค้า</button>
      </div>
    </form>
  </div>
</div>

<script>
// เพิ่มสินค้าแบบแมนนวล
document.getElementById('createProductForm')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append('action', 'create_shop_manual'); // ใช้แอคชันเดิมที่คุณมีอยู่

  try {
    const res  = await fetch('/system/master.php', { method:'POST', body: fd, credentials:'same-origin' });
    const type = (res.headers.get('content-type') || '').includes('application/json');
    const data = type ? await res.json() : { ok:false, message:'Invalid response' };

    if (data.ok) {
      const modalEl = document.getElementById('createProductModal');
      if (window.bootstrap && bootstrap.Modal.getInstance(modalEl)) {
        bootstrap.Modal.getInstance(modalEl).hide();
      }
      location.reload();
    } else {
      alert(data.message || 'บันทึกไม่สำเร็จ');
    }
  } catch (err) {
    console.error(err);
    alert('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้');
  }
});

// ลบสินค้าแบบแมนนวล (ใช้เอ็นด์พอยน์ต์เดิม)
async function delete_shop(id){
  if (!confirm('ยืนยันลบรายการนี้?')) return;
  const fd = new FormData();
  fd.append('action', 'delete_shop');
  fd.append('id', id);

  try {
    const res  = await fetch('/system/master.php', { method:'POST', body: fd, credentials:'same-origin' });
    const type = (res.headers.get('content-type') || '').includes('application/json');
    const data = type ? await res.json() : { ok:false, message:'Invalid response' };

    if (data.ok) location.reload();
    else alert(data.message || 'ลบไม่สำเร็จ');
  } catch (err) {
    console.error(err);
    alert('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้');
  }
}
</script>
