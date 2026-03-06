
    <div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
        <div class="card shadow-lg" style="background: rgba(255, 255, 255, 0.95); border: none; overflow: hidden;">
            <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%); animation: shimmer 3s infinite;"></div>
                <div class="d-flex justify-content-between align-items-center" style="position: relative; z-index: 2;">
                    <h5 class="mb-0" style="font-weight: 700; display: flex; align-items: center; gap: 10px;">
                        <i class='bx bxs-shopping-bag'></i> ประวัติการขายล่าสุด
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light btn-sm" onclick="refreshSalesHistory()" id="refreshBtn" style="transition: all 0.3s ease;">
                            <i class="fas fa-sync-alt"></i> รีเฟรช
                        </button>
                        <button class="btn btn-light btn-sm" onclick="toggleView()" id="toggleViewBtn" style="transition: all 0.3s ease;">
                            <i class="fas fa-list"></i> มุมมองตาราง
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-0">
                <?php
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://byshop.me/api/history',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 1,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('keyapi' => $web_rows['web_keyapi']),  
                CURLOPT_HTTPHEADER => array(
                    'Cookie: PHPSESSID=u8df3d96ij8re36ld76cl64t3p'
                ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $listbuy = json_decode($response);
                
                // คำนวณสถิติ
                $totalSales = $listbuy ? count($listbuy) : 0;
                $todayCount = 0;
                if ($listbuy && is_array($listbuy)) {
                    foreach ($listbuy as $item) {
                        if (isset($item->time) && date('Y-m-d', strtotime($item->time)) == date('Y-m-d')) {
                            $todayCount++;
                        }
                    }
                }
                ?>
                
                <!-- Stats Cards -->
                <div class="row p-3" id="statsSection" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #e2e8f0;">
                    <style>
                        .sales-stat-card {
                            text-align: center;
                            padding: 20px;
                            background: white;
                            border-radius: 12px;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                            transition: all 0.3s ease;
                            animation: slideUpFade 0.8s ease-out both;
                        }
                        
                        .sales-stat-card:nth-child(1) { animation-delay: 0s; }
                        .sales-stat-card:nth-child(2) { animation-delay: 0.15s; }
                        .sales-stat-card:nth-child(3) { animation-delay: 0.3s; }
                        
                        @keyframes slideUpFade {
                            from {
                                opacity: 0;
                                transform: translateY(20px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                        
                        .sales-stat-card:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
                        }
                        
                        .sales-stat-number {
                            font-size: 2rem;
                            font-weight: 800;
                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                            -webkit-background-clip: text;
                            -webkit-text-fill-color: transparent;
                            background-clip: text;
                        }
                        
                        .sales-stat-label {
                            color: #666;
                            font-size: 0.9rem;
                            margin-top: 5px;
                        }
                    </style>
                    
                    <div class="col-md-4 mb-2">
                        <div class="sales-stat-card">
                            <div class="sales-stat-number"><?=number_format($totalSales)?></div>
                            <div class="sales-stat-label">📊 รายการขายทั้งหมด</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="sales-stat-card">
                            <div class="sales-stat-number" style="color: #10b981;"><?=number_format($todayCount)?></div>
                            <div class="sales-stat-label">🎯 ขายวันนี้</div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <div class="sales-stat-card">
                            <div class="sales-stat-number" style="color: #06b6d4;"><?=date('H:i')?></div>
                            <div class="sales-stat-label">⏰ อัปเดทล่าสุด</div>
                        </div>
                    </div>
                </div>

                <!-- Marquee View -->
                <div id="marqueeView" class="p-3">
                    <div class="marquee-container" style="overflow: hidden; white-space: nowrap;">
                        <div class="marquee-content" style="display: inline-block; animation: scroll 20s linear infinite;">
                            <div id="salesMarquee" class="d-flex align-items-center">
                                <?php if ($listbuy && is_array($listbuy) && count($listbuy) > 0): ?>
                                    <?php foreach ($listbuy as $item): ?>
                                        <?php if (isset($item->name) && isset($item->time)): ?>
                                            <div class="sale-item">
                                                <img src="https://byshop.me/buy/img/img_app/<?=htmlspecialchars(substr($item->name, 0, 2))?>.png" 
                                                    alt="<?=htmlspecialchars($item->name)?>"
                                                    style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(102,126,234,0.3);"
                                                    onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDUiIGhlaWdodD0iNDUiIHZpZXdCb3g9IjAgMCA0NSA0NSIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQ1IiBoZWlnaHQ9IjQ1IiByeD0iMjIuNSIgZmlsbD0iIzY2N0VFQSIvPgo8cGF0aCBkPSJNMTUgMjJIMzBNMjIuNSAxNVYzMCIgc3Ryb2tlPSJ3aGl0ZSIgc3Ryb2tlLXdpZHRoPSIyIiBzdHJva2UtbGluZWNhcD0icm91bmQiLz4KPHN2Zz4K'">
                                                <div class="sale-info" style="margin-left: 12px;">
                                                    <div class="sale-name" style="font-weight: 600; color: #333; font-size: 0.95rem;"><?=htmlspecialchars($item->name)?></div>
                                                    <div class="sale-time" style="font-size: 0.8rem; color: #999; margin: 2px 0;"><?=date('d/m/Y H:i', strtotime($item->time))?></div>
                                                    <span class="sale-status" style="display: inline-block; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">
                                                        <i class="fas fa-check-circle"></i> ขายแล้ว
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center p-5 w-100" style="color: #999;">
                                        <i class="fas fa-shopping-cart" style="font-size: 2.5rem; opacity: 0.5; margin-bottom: 10px;"></i>
                                        <p style="margin: 0;">ยังไม่มีประวัติการขาย</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table View -->
                <div id="tableView" class="p-3" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-hover" id="salesTable" style="margin: 0;">
                            <thead style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-bottom: 2px solid #667eea;">
                                <tr>
                                    <th width="60">รูป</th>
                                    <th>ชื่อสินค้า</th>
                                    <th>เวลาขาย</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            <tbody id="salesTableBody">
                                <?php if ($listbuy && is_array($listbuy) && count($listbuy) > 0): ?>
                                    <?php foreach ($listbuy as $item): ?>
                                        <?php if (isset($item->name) && isset($item->time)): ?>
                                            <tr style="transition: all 0.2s ease;" onmouseover="this.style.background='rgba(102,126,234,0.05)'" onmouseout="this.style.background='transparent'">
                                                <td>
                                                    <img src="https://byshop.me/buy/img/img_app/<?=htmlspecialchars(substr($item->name, 0, 2))?>.png" 
                                                        class="rounded-circle" 
                                                        width="40" height="40"
                                                        alt="<?=htmlspecialchars($item->name)?>"
                                                        style="object-fit: cover; border: 2px solid #667eea; box-shadow: 0 2px 6px rgba(102,126,234,0.2);"
                                                        onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiByeD0iMjAiIGZpbGw9IiM2NjdFRUEiLz4KPHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMTMuMDkgOC4yNkwyMCA5TDEzLjA5IDE1Ljc0TDEyIDIyTDEwLjkxIDE1Ljc0TDQgOUwxMC45MSA4LjI2TDEyIDJaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K'">
                                                </td>
                                                <td><strong style="color: #333;"><?=htmlspecialchars($item->name)?></strong></td>
                                                <td>
                                                    <small class="text-muted"><?=date('d/m/Y H:i', strtotime($item->time))?></small>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3);">
                                                        <i class="fas fa-check-circle"></i> ขายแล้ว
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center p-5" style="color: #999;">
                                            <i class="fas fa-shopping-cart" style="font-size: 2.5rem; opacity: 0.5; margin-bottom: 10px;"></i>
                                            <p style="margin: 0;">ยังไม่มีประวัติการขาย</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    @keyframes scroll {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    @keyframes shimmer {
        0% { transform: translate(-100%, -100%) rotate(0deg); }
        100% { transform: translate(100%, 100%) rotate(360deg); }
    }

    .marquee-container {
        overflow: hidden;
        margin: 0 15px;
        padding: 15px 0;
        border-radius: 15px;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }

    .marquee-container:hover .marquee-content {
        animation-play-state: paused;
    }

    .marquee-content {
        animation-timing-function: linear !important;
        will-change: transform;
    }

    .sale-item {
        display: inline-flex;
        align-items: center;
        margin-right: 2.5rem;
        padding: 12px 18px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        min-width: 280px;
        max-width: 340px;
        border: 1px solid rgba(203, 213, 225, 0.6);
        transition: all 0.3s ease;
    }
    
    .sale-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.25);
        border-color: rgba(102, 126, 234, 0.8);
    }

    .sale-item img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #667eea;
        box-shadow: 0 2px 4px rgba(102, 126, 234, 0.2);
        flex-shrink: 0;
    }

    .sale-info {
        margin-left: 12px;
        flex: 1;
        min-width: 0;
    }

    .sale-name {
        font-weight: 600;
        color: #1a202c;
        font-size: 14px;
        margin-bottom: 3px;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .sale-time {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 5px;
        font-weight: 500;
        white-space: nowrap;
    }

    .sale-status {
        display: inline-block;
        padding: 3px 8px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(16, 185, 129, 0.3);
        white-space: nowrap;
    }

    .card {
        border-radius: 20px !important;
        overflow: hidden;
        box-shadow: 
            0 10px 15px -3px rgba(0, 0, 0, 0.1),
            0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }

    .card-header {
        border-radius: 20px 20px 0 0 !important;
        border: none !important;
        padding: 20px !important;
    }

    .table-responsive {
        margin: 0 15px 15px 15px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin-bottom: 0 !important;
    }

    .table th {
        border-top: none;
        font-weight: 700;
        font-size: 14px;
        color: #1e293b;
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        padding: 15px 20px;
    }

    .table td {
        padding: 15px 20px;
        vertical-align: middle;
        border-color: rgba(226, 232, 240, 0.5);
    }

    .btn {
        border-radius: 12px !important;
        font-weight: 600 !important;
        padding: 8px 16px !important;
        transition: all 0.3s ease !important;
        border: none !important;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .btn-light {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%) !important;
        color: #374151 !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
    }

    .btn-light:hover {
        background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%) !important;
        color: #1f2937 !important;
    }


    #refreshBtn.loading {
        pointer-events: none;
        opacity: 0.7;
    }

    #refreshBtn.loading i {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .table-hover tbody tr:hover {
        background: linear-gradient(145deg, rgba(102, 126, 234, 0.02) 0%, rgba(102, 126, 234, 0.05) 100%);
        transition: all 0.2s ease;
    }

    .badge {
        font-weight: 600;
        padding: 6px 12px !important;
        border-radius: 10px !important;
    }

    .bg-light {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
        border-bottom: 1px solid rgba(226, 232, 240, 0.3) !important;
    }

    /* แก้ปัญหา overflow */
    #marqueeView, #tableView {
        overflow-x: hidden;
    }

    .d-flex.gap-2 {
        gap: 8px !important;
    }

    /* เพิ่มเอฟเฟกต์สำหรับ responsive */
    @media (max-width: 768px) {
        .sale-item {
            min-width: 220px;
            max-width: 280px;
            padding: 8px 12px;
            margin-right: 1.5rem;
        }
        
        .sale-item img {
            width: 40px;
            height: 40px;
        }
        
        .sale-name {
            font-size: 13px;
        }
        
        .sale-time {
            font-size: 11px;
        }
        
        .stat-card {
            padding: 15px 10px;
            margin: 3px;
        }
        
        .btn {
            padding: 6px 12px !important;
            font-size: 13px !important;
        }
    }

    @media (max-width: 480px) {
        .card-header .d-flex {
            flex-direction: column;
            gap: 10px;
        }
        
        .card-header h5 {
            margin-bottom: 0 !important;
            font-size: 16px;
        }
    }

    /* เอฟเฟกต์ Loading สวยๆ */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    </style>

    <script>
    // ตัวแปรสำหรับเก็บข้อมูล
    let isTableView = false;

    // สลับมุมมอง
    function toggleView() {
        const marqueeView = document.getElementById('marqueeView');
        const tableView = document.getElementById('tableView');
        const toggleBtn = document.getElementById('toggleViewBtn');
        
        isTableView = !isTableView;
        
        if (isTableView) {
            marqueeView.style.display = 'none';
            tableView.style.display = 'block';
            toggleBtn.innerHTML = '<i class="fas fa-scroll"></i> มุมมอง Marquee';
            
            // เพิ่มเอฟเฟกต์ fade in
            tableView.style.opacity = '0';
            setTimeout(() => {
                tableView.style.opacity = '1';
            }, 100);
        } else {
            tableView.style.display = 'none';
            marqueeView.style.display = 'block';
            toggleBtn.innerHTML = '<i class="fas fa-list"></i> มุมมองตาราง';
            
            // เพิ่มเอฟเฟกต์ fade in
            marqueeView.style.opacity = '0';
            setTimeout(() => {
                marqueeView.style.opacity = '1';
            }, 100);
        }
    }

    // รีเฟรชข้อมูล
    function refreshSalesHistory() {
        const refreshBtn = document.getElementById('refreshBtn');
        refreshBtn.classList.add('loading');
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt"></i> กำลังรีเฟรช...';
        
        // รีโหลดหน้าเพื่อดึงข้อมูลใหม่
        setTimeout(() => {
            location.reload();
        }, 1200);
    }

    // เพิ่ม smooth transition สำหรับ element ต่างๆ
    document.addEventListener('DOMContentLoaded', function() {
        const views = document.querySelectorAll('#marqueeView, #tableView');
        views.forEach(view => {
            view.style.transition = 'opacity 0.3s ease';
        });
        
        // Auto refresh ทุก 5 นาที (300000ms)
        setInterval(() => {
            console.log('Auto refreshing sales data...');
            refreshSalesHistory();
        }, 300000);
    });
    </script>
