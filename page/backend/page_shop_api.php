<?php
    // ตั้งค่าเริ่มต้น กันตัวแปรยังไม่ถูกเซ็ต
    $api_money = "0.00";

    // ดึงรายการสินค้า (ทั้งจาก API และของเรา)
    $result = $connect->query("SELECT * FROM pp_shop_stock_api;");
    $shopapis = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

    // เรียกยอดเงินคงเหลือจาก Byshop
    $url = 'https://byshop.me/api/money';
    $headers = array(
        // 'User-Agent: HMPRSLIPAPI',
    );
    $data = array('keyapi' => $web_rows['web_keyapi']);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($response !== false && !$err) {
        $data = json_decode($response, true);
        if (isset($data['status']) && $data['status'] === "success") {
            $api_money = $data['money'];
        }
    }
?>

<!-- ซ้าย: คอลัมน์เนื้อหา (วางภายใน .row ของ page_home.php) -->
<div class="col-md-9 col-sm-12" data-aos="fade-up">
    <div class="card card-hover shadow-lg px-4 py-3" style="background-color: #e6eeff;">
        <h5 class="card-title"><i class='bx bx-cog'></i> จัดการสินค้าจาก API Byshop.me</h5>
        <hr>

        <div class="text-end">
            <button class="btn btn-light">
                ยอดเงิน API คงเหลือ <b class="text-primary">฿<?= htmlspecialchars($api_money) ?></b> บาท
            </button>
            <button type="button" class="btn btn-info mb-1" onclick="update_sop_api(0)">
                <i class="fa-solid fa-arrows-rotate"></i> อัพเดทสินค้า
            </button>
            <button type="button" class="btn btn-info mb-1" onclick="update_sop_api(1)">
                <i class="fa-solid fa-arrows-rotate"></i> อัพเดทบางส่วน
            </button>

            <!-- ปุ่มเพิ่มสินค้า (ของเรา) -->
            <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="fa-solid fa-plus"></i> เพิ่มสินค้า (ของเรา)
            </button>
        </div>

        <div class="table-responsive mt-3">
            <div style="overflow-x:auto;">
                <table id="tbl_shopapi" cellspacing="1" class="table table-striped table-bordered display text-dark">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fa-solid fa-computer"></i> สินค้า</th>
                            <th><i class="fa-solid fa-credit-card"></i> ราคาเรา</th>
                            <th><i class="fa-solid fa-credit-card"></i> ราคา api</th>
                            <th><i class="fa-solid fa-font-awesome"></i> สต็อก</th>
                            <th><i class="fa-solid fa-font-awesome"></i> สถานะ</th>
                            <th><i class="fa-solid fa-clock"></i> ข้อมูล</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($shopapis as $shopapi): ?>
                            <tr>
                                <!-- ถ้าเป็นสินค้าของเรา product_id มักเป็น 0 ให้ fallback เป็น id -->
                                <td><?= $shopapi['product_id'] ?: $shopapi['id']; ?></td>
                                <td><?= htmlspecialchars($shopapi['name']); ?></td>
                                <td><?= number_format((float)$shopapi['price_web'], 2); ?></td>
                                <td><?= number_format((float)$shopapi['price'], 2); ?></td>
                                <td><?= (int)$shopapi['stock']; ?></td>

                                <?php if ((int)$shopapi['stock'] <= 0): ?>
                                    <td>
                                        <span class="badge bg-danger">
                                            <i class="fa-solid fa-xmark"></i> <?= htmlspecialchars($shopapi['status']); ?>
                                        </span>
                                    </td>
                                <?php else: ?>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fa-solid fa-check"></i> <?= htmlspecialchars($shopapi['status']); ?>
                                        </span>
                                    </td>
                                <?php endif; ?>

                                <td>
                                    <button type="button" class="btn btn-sm btn-warning mb-1"
                                            data-bs-toggle="modal" data-bs-target="#editShopModal<?= (int)$shopapi['id']; ?>">
                                        <i class="fa-regular fa-pen-to-square"></i> แก้ไข
                                    </button>

                                    <?php if ((int)$shopapi['showitem'] == 0): ?>
                                        <button type="button" class="btn btn-sm btn-danger mb-1"
                                                onclick="showshop(<?= (int)$shopapi['id']; ?>)">
                                            <i class="fa-solid fa-eye-slash"></i> ปิด
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-success mb-1"
                                                onclick="showshop(<?= (int)$shopapi['id']; ?>)">
                                            <i class="fa-solid fa-eye"></i> เปิด
                                        </button>
                                    <?php endif; ?>

                                    <!-- ปุ่มลบ (ลบได้ถ้าเป็นสินค้าของเรา product_id=0) -->
                                    <button type="button" class="btn btn-sm btn-outline-danger mb-1"
                                            onclick="delete_shop(<?= (int)$shopapi['id']; ?>)">
                                        <i class="fa-solid fa-trash-can"></i> ลบ
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- /card -->
</div> <!-- /col-md-9 -->

<?php foreach($shopapis as $shopapi): ?>
<!-- Modal แก้ไขสินค้าเดิม (อยู่นอกกริดเพื่อไม่ให้เลย์เอาต์เพี้ยน) -->
<div class="modal fade" id="editShopModal<?= (int)$shopapi['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    <i class="fa-regular fa-circle-question"></i> ข้อมูล <?= htmlspecialchars($shopapi['name']); ?>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="form-group text-center">
                    <img src="<?= htmlspecialchars($shopapi['img']); ?>" alt="shop" width="10%">
                </div>

                <div class="form-group">
                    <label class="col-form-label"><i class="fa-regular fa-image"></i> Url รูปสินค้า</label>
                    <input type="text" class="form-control" id="img<?= (int)$shopapi['id']; ?>" value="<?= htmlspecialchars($shopapi['img']); ?>">
                </div>

                <div class="form-group">
                    <label class="col-form-label"><i class="fa-solid fa-tag"></i> ซื้อสินค้า</label>
                    <input type="text" class="form-control" id="name<?= (int)$shopapi['id']; ?>" value="<?= htmlspecialchars($shopapi['name']); ?>">
                </div>

                <div class="form-group row">
                    <div class="form-group col-md-4">
                        <label class="col-form-label"><i class="fa-solid fa-coins"></i> ราคาเรา</label>
                        <input type="text" class="form-control" id="mypoint<?= (int)$shopapi['id']; ?>" value="<?= htmlspecialchars($shopapi['price_web']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label"><i class="fa-solid fa-coins"></i> ราคา api</label>
                        <input type="text" class="form-control" disabled value="<?= htmlspecialchars($shopapi['price']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="col-form-label"><i class="fa-solid fa-box-open"></i> สต็อก</label>
                        <input type="text" class="form-control" disabled value="<?= (int)$shopapi['stock']; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-form-label"><i class="fa-solid fa-chevron-right"></i> ข้อมูลสินค้าแสดงหน้าเว็บ</label>
                    <textarea id="info<?= (int)$shopapi['id']; ?>" class="summernote" name="info" rows="5"><?= htmlspecialchars($shopapi['info']); ?></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="edit_shop_api(<?= (int)$shopapi['id']; ?>)">
                    <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                </button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fa-solid fa-circle-xmark"></i> ปิดหน้าต่างนี้
                </button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>

<!-- Modal: เพิ่มสินค้า (ของเรา) -->
<div class="modal fade" id="createProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="createProductForm" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fa-solid fa-box"></i> เพิ่มสินค้า (ของเรา)</h5>
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
            <label class="form-label"><i class="fa-solid fa-coins"></i> ราคา API (ถ้าไม่มีใส่เท่าราคาเรา)</label>
            <input name="price_api" type="number" step="0.01" min="0" class="form-control">
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
            <label class="form-label"><i class="fa-solid fa-info-circle"></i> ข้อมูล/รายละเอียดสินค้า</label>
            <textarea name="info" rows="4" class="form-control"></textarea>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> บันทึกสินค้า
        </button>
      </div>
    </form>
  </div>
</div>

<script>
// ส่งฟอร์มเพิ่มสินค้า (ของเรา)
document.getElementById('createProductForm')?.addEventListener('submit', async (e) => {
  e.preventDefault();
  const fd = new FormData(e.target);
  fd.append('action', 'create_shop_manual');

  try {
    const res  = await fetch('/system/master.php', { method:'POST', body: fd, credentials:'same-origin' });
    const type = (res.headers.get('content-type') || '').includes('application/json');
    const data = type ? await res.json() : { ok:false, message:'Invalid response' };

    if (data.ok) {
      // ปิด modal และรีโหลด
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

// ลบสินค้า (อนุญาตลบเฉพาะสินค้าที่เป็นของเราเอง product_id=0 ในฝั่ง server)
async function delete_shop(id){
  if (!confirm('ยืนยันลบรายการนี้?')) return;
  const fd = new FormData();
  fd.append('action', 'delete_shop');
  fd.append('id', id);

  try {
    const res  = await fetch('/system/master.php', { method:'POST', body: fd, credentials:'same-origin' });
    const type = (res.headers.get('content-type') || '').includes('application/json');
    const data = type ? await res.json() : { ok:false, message:'Invalid response' };

    if (data.ok) {
      location.reload();
    } else {
      alert(data.message || 'ลบไม่สำเร็จ');
    }
  } catch (err) {
    console.error(err);
    alert('ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้');
  }
}

// ===== AUTO REFRESH SYSTEM =====
let autoRefreshInterval = null;
let refreshCountdown = null;
let isAutoRefreshEnabled = JSON.parse(localStorage.getItem('autoRefreshEnabled') || 'false');
let refreshIntervalMinutes = parseInt(localStorage.getItem('refreshIntervalMinutes') || '5');
let countdownSeconds = 0;

// สร้าง UI สำหรับ Auto Refresh
function createAutoRefreshUI() {
    const refreshContainer = document.createElement('div');
    refreshContainer.id = 'autoRefreshContainer';
    refreshContainer.className = 'auto-refresh-container';
    refreshContainer.innerHTML = `
        <div class="card mb-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="card-body">
                <h6 class="card-title mb-3">
                    <i class="fas fa-sync-alt"></i> ระบบอัปเดทอัตโนมัติ
                </h6>
                
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="autoRefreshToggle" ${isAutoRefreshEnabled ? 'checked' : ''}>
                            <label class="form-check-label" for="autoRefreshToggle">
                                เปิดใช้งาน
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <label for="refreshInterval" class="form-label mb-1">ช่วงเวลา (นาที)</label>
                        <select class="form-select form-select-sm" id="refreshInterval">
                            <option value="1" ${refreshIntervalMinutes === 1 ? 'selected' : ''}>1 นาที</option>
                            <option value="2" ${refreshIntervalMinutes === 2 ? 'selected' : ''}>2 นาที</option>
                            <option value="5" ${refreshIntervalMinutes === 5 ? 'selected' : ''}>5 นาที</option>
                            <option value="10" ${refreshIntervalMinutes === 10 ? 'selected' : ''}>10 นาที</option>
                            <option value="15" ${refreshIntervalMinutes === 15 ? 'selected' : ''}>15 นาที</option>
                            <option value="30" ${refreshIntervalMinutes === 30 ? 'selected' : ''}>30 นาที</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <div id="refreshStatus" class="refresh-status">
                            <i class="fas fa-clock"></i> 
                            <span id="statusText">ปิดใช้งาน</span>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <button id="manualRefreshBtn" class="btn btn-light btn-sm w-100" onclick="manualRefresh()">
                            <i class="fas fa-sync"></i> รีเฟรช
                        </button>
                    </div>
                </div>
                
                <div class="progress mt-3" style="height: 6px; display: none;" id="refreshProgress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" 
                         style="width: 0%; background: linear-gradient(90deg, #28a745, #20c997);" 
                         id="progressBar"></div>
                </div>
            </div>
        </div>
    `;

    // แทรกก่อน card หลัก
    const mainCard = document.querySelector('.card.card-hover');
    mainCard.parentNode.insertBefore(refreshContainer, mainCard);

    // เพิ่ม CSS
    const style = document.createElement('style');
    style.textContent = `
        .auto-refresh-container {
            animation: fadeInUp 0.5s ease-out;
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .refresh-status {
            background: rgba(255,255,255,0.2);
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            min-width: 140px;
            text-align: center;
        }
        
        .refresh-status.active {
            background: rgba(40, 167, 69, 0.8);
            animation: pulse 2s infinite;
        }
        
        .refresh-status.refreshing {
            background: rgba(255, 193, 7, 0.8);
            animation: spin 1s linear infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        #manualRefreshBtn:hover {
            background-color: #f8f9fa;
            transform: scale(1.05);
            transition: all 0.2s ease;
        }
    `;
    document.head.appendChild(style);
}

// อัปเดทสถานะ UI
function updateRefreshStatus(text, className = '') {
    const statusElement = document.getElementById('statusText');
    const statusContainer = document.getElementById('refreshStatus');
    
    if (statusElement) statusElement.textContent = text;
    if (statusContainer) {
        statusContainer.className = `refresh-status ${className}`;
    }
}

// เริ่ม auto refresh
function startAutoRefresh() {
    if (autoRefreshInterval) clearInterval(autoRefreshInterval);
    if (refreshCountdown) clearInterval(refreshCountdown);
    
    const intervalMs = refreshIntervalMinutes * 60 * 1000;
    countdownSeconds = refreshIntervalMinutes * 60;
    
    // เริ่ม countdown
    startCountdown();
    
    // ตั้งเวลา auto refresh
    autoRefreshInterval = setInterval(() => {
        performAutoRefresh();
    }, intervalMs);
    
    updateRefreshStatus(`อัปเดทอัตโนมัติทุก ${refreshIntervalMinutes} นาที`, 'active');
}

// หยุด auto refresh
function stopAutoRefresh() {
    if (autoRefreshInterval) clearInterval(autoRefreshInterval);
    if (refreshCountdown) clearInterval(refreshCountdown);
    
    autoRefreshInterval = null;
    refreshCountdown = null;
    
    updateRefreshStatus('ปิดใช้งาน', '');
    hideProgress();
}

// เริ่ม countdown
function startCountdown() {
    countdownSeconds = refreshIntervalMinutes * 60;
    
    refreshCountdown = setInterval(() => {
        countdownSeconds--;
        
        if (countdownSeconds <= 0) {
            countdownSeconds = refreshIntervalMinutes * 60;
        }
        
        const minutes = Math.floor(countdownSeconds / 60);
        const seconds = countdownSeconds % 60;
        const timeStr = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        updateRefreshStatus(`อัปเดทใน ${timeStr}`, 'active');
        updateProgress();
        
    }, 1000);
}

// อัปเดท progress bar
function updateProgress() {
    const totalSeconds = refreshIntervalMinutes * 60;
    const elapsed = totalSeconds - countdownSeconds;
    const percentage = (elapsed / totalSeconds) * 100;
    
    const progressBar = document.getElementById('progressBar');
    const progressContainer = document.getElementById('refreshProgress');
    
    if (progressBar && progressContainer) {
        progressContainer.style.display = 'block';
        progressBar.style.width = percentage + '%';
    }
}

// ซ่อน progress bar
function hideProgress() {
    const progressContainer = document.getElementById('refreshProgress');
    if (progressContainer) {
        progressContainer.style.display = 'none';
    }
}

// ทำการ refresh อัตโนมัติ
async function performAutoRefresh() {
    updateRefreshStatus('กำลังอัปเดท...', 'refreshing');
    
    try {
        // เรียก update function (แบบอัปเดทบางส่วน เพื่อไม่ให้หนักเกินไป)
        await update_sop_api(1);
        
        // แสดง notification
        showRefreshNotification('อัปเดทสินค้าสำเร็จ!', 'success');
        
        // รีสตาร์ท countdown
        startCountdown();
        
    } catch (error) {
        console.error('Auto refresh error:', error);
        showRefreshNotification('อัปเดทสินค้าไม่สำเร็จ', 'error');
        updateRefreshStatus(`อัปเดทอัตโนมัติทุก ${refreshIntervalMinutes} นาที`, 'active');
    }
}

// แสดง notification
function showRefreshNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // ลบ notification หลัง 3 วินาที
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// รีเฟรชแมนนวล
async function manualRefresh() {
    const btn = document.getElementById('manualRefreshBtn');
    const originalText = btn.innerHTML;
    
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> กำลังอัปเดท...';
    btn.disabled = true;
    
    try {
        await update_sop_api(1);
        showRefreshNotification('อัปเดทสินค้าแมนนวลสำเร็จ!', 'success');
    } catch (error) {
        showRefreshNotification('อัปเดทสินค้าไม่สำเร็จ', 'error');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // สร้าง UI
    createAutoRefreshUI();
    
    // Toggle auto refresh
    document.getElementById('autoRefreshToggle')?.addEventListener('change', function(e) {
        isAutoRefreshEnabled = e.target.checked;
        localStorage.setItem('autoRefreshEnabled', JSON.stringify(isAutoRefreshEnabled));
        
        if (isAutoRefreshEnabled) {
            startAutoRefresh();
        } else {
            stopAutoRefresh();
        }
    });
    
    // เปลี่ยนช่วงเวลา
    document.getElementById('refreshInterval')?.addEventListener('change', function(e) {
        refreshIntervalMinutes = parseInt(e.target.value);
        localStorage.setItem('refreshIntervalMinutes', refreshIntervalMinutes.toString());
        
        if (isAutoRefreshEnabled) {
            stopAutoRefresh();
            startAutoRefresh();
        }
    });
    
    // เริ่มระบบถ้าเปิดใช้งานอยู่
    if (isAutoRefreshEnabled) {
        startAutoRefresh();
    }
});

// หยุดระบบเมื่อออกจากหน้า
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});

// ===== END AUTO REFRESH SYSTEM =====
</script>
