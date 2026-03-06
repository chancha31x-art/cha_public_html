<div class="col-md-9 col-sm-12" data-aos="fade-up">
  <div class="card card-hover shadow-lg px-4 py-3" style="background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%); border: none;">
    <h5 class="card-title text-dark"><i class='bx bx-bar-chart-alt-2'></i> <strong>ระบบจัดการหลังบ้าน</strong></h5><hr class="my-3">

    <div class="row g-3">
      <!-- การ์ด 1: สมาชิกทั้งหมด -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">สมาชิกทั้งหมด</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;"><?=number_format($count_users,0)?></h3>
              <small class="opacity-75">คน</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">👥</div>
          </div>
        </div>
      </div>

      <!-- การ์ด 2: สมาชิกใหม่วันนี้ -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">สมาชิกใหม่วันนี้</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;">+<?=number_format($count_users_day,0)?></h3>
              <small class="opacity-75">คน</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">✨</div>
          </div>
        </div>
      </div>

      <!-- การ์ด 3: รายได้ทั้งหมด -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">รายได้ทั้งหมด</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;"><?=number_format($count_point + $manual_topup_all,2)?></h3>
              <small class="opacity-75">บาท</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">💰</div>
          </div>
        </div>
      </div>

      <!-- การ์ด 4: รายได้วันนี้ -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">รายได้ของวันนี้</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;"><?=number_format($count_point_day,2)?></h3>
              <small class="opacity-75">บาท</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">📊</div>
          </div>
        </div>
      </div>

      <!-- การ์ด 5: เติมเงินด้วยตนเองทั้งหมด -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #ffa751 0%, #ffe259 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">Manual เติมทั้งหมด</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;"><?=number_format($manual_topup_all,2)?></h3>
              <small class="opacity-75">บาท</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">🎯</div>
          </div>
        </div>
      </div>

      <!-- การ์ด 6: เติมเงินด้วยตนเองวันนี้ -->
      <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card border-0 shadow-sm h-100 transition-all" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%); border-radius: 12px;">
          <div class="card-body d-flex align-items-center justify-content-between text-white">
            <div>
              <h6 class="text-uppercase mb-2 opacity-75" style="font-size: 0.85rem; font-weight: 600;">Manual เติมวันนี้</h6>
              <h3 class="mb-0" style="font-size: 2rem; font-weight: 700;"><?=number_format($manual_topup_today,2)?></h3>
              <small class="opacity-75">บาท</small>
            </div>
            <div style="font-size: 3rem; opacity: 0.3;">⚡</div>
          </div>
        </div>
      </div>
    </div>


    <!-- แถวกราฟ -->
    <div class="row g-3 mt-2">
      <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
          <div class="card-header bg-gradient text-white d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.25rem;">
            <div>
              <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i><strong>📊 รายได้รวม</strong></h6>
              <small class="opacity-75">รายได้จากการสั่งซื้อ + เติมเงิน</small>
            </div>
          </div>
          <div class="card-body p-3" style="background: linear-gradient(135deg, #f8f9ff 0%, #e8f0ff 100%); min-height: 300px;">
            <canvas id="chartLine" height="280"></canvas>
          </div>
        </div>
      </div>

      <div class="col-lg-6 col-md-12">
        <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
          <div class="card-header bg-gradient text-white d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 1.25rem;">
            <div>
              <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i><strong>💳 ยอดเติมเงิน</strong></h6>
              <small class="opacity-75">แนวโน้มการเติมเงิน (ไม่รวม Manual)</small>
            </div>
          </div>
          <div class="card-body p-3" style="background: linear-gradient(135deg, #f8fff8 0%, #e8ffe8 100%); min-height: 300px;">
            <canvas id="chartPie" height="280"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- โหลด Chart.js (กันโหลดซ้ำ) -->
<script>
(function ensureChartJs(){
  if(!document.querySelector('script[data-chartjs-cdn]')){
    var s=document.createElement('script');
    s.src='https://cdn.jsdelivr.net/npm/chart.js';
    s.setAttribute('data-chartjs-cdn','true');
    document.head.appendChild(s);
  }
})();
</script>

<!-- โหลด Chart.js (กันโหลดซ้ำ) -->
<script>
(function ensureChartJs(){
  if(!document.querySelector('script[data-chartjs-cdn]')){
    const s=document.createElement('script');
    s.src='https://cdn.jsdelivr.net/npm/chart.js';
    s.setAttribute('data-chartjs-cdn','true');
    document.head.appendChild(s);
  }
})();
</script>

<script>
(function () {
  const API_BASE = '/page/backend/api/dashboard_stats.php';

  // ----- เพิ่มตัวเลือกช่วงเวลาแบบสวยงาม -----
  const controls = document.createElement('div');
  controls.className = 'd-flex justify-content-between align-items-center mb-3 p-3 rounded' 
  controls.style.cssText = 'background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(79, 172, 254, 0.1) 100%); border: 1px solid rgba(102, 126, 234, 0.3);';
  controls.innerHTML = `
    <div class="d-flex align-items-center">
      <i class="fas fa-filter text-primary me-2" style="font-size: 1.1rem;"></i>
      <label class="mb-0 text-dark fw-600" style="font-weight: 500;">เลือกช่วงเวลา:</label>
    </div>
    <div class="d-flex gap-2">
      <select id="rangeSelect" class="form-select form-select-sm shadow-sm" style="width:160px; border-color: #667eea; border-width: 2px; border-radius: 8px;">
        <option value="7">📅 7 วันล่าสุด</option>
        <option value="30" selected>📅 30 วันล่าสุด</option>
        <option value="60">📅 60 วันล่าสุด</option>
        <option value="90">📅 90 วันล่าสุด</option>
        <option value="year">📊 รายเดือนทั้งปี</option>
      </select>
      <select id="yearSelect" class="form-select form-select-sm shadow-sm" style="width:90px; display:none; border-color: #4facfe; border-width: 2px; border-radius: 8px;"></select>
    </div>
  `;
  // แทรกไว้ก่อนแถวกราฟ
  const chartRow = document.querySelector('#chartLine')?.closest('.row');
  if (chartRow) chartRow.parentElement.insertBefore(controls, chartRow);

  // เติมรายการปี (ปีปัจจุบันย้อนหลัง 4 ปี)
  const ysel = controls.querySelector('#yearSelect');
  const nowY = new Date().getFullYear();
  for (let y=nowY; y>=nowY-4; y--) {
    const opt = document.createElement('option');
    opt.value = y; opt.textContent = y.toString();
    ysel.appendChild(opt);
  }

  function numberBaht(n){ try { return Number(n).toLocaleString('th-TH',{maximumFractionDigits:2}); } catch(e){ return n; } }
  function whenChartReady(cb){
    if (window.Chart) return cb();
    const iv=setInterval(()=>{ if(window.Chart){ clearInterval(iv); cb(); } },50);
    setTimeout(()=>clearInterval(iv),8000);
  }

  let lineChart = null, pieChart = null;

  function buildUrl() {
    const r = controls.querySelector('#rangeSelect').value;
    if (r === 'year') {
      const y = controls.querySelector('#yearSelect').value || nowY;
      return `${API_BASE}?range=year&year=${encodeURIComponent(y)}`;
    }
    return `${API_BASE}?range=${encodeURIComponent(r)}`;
  }

  function draw({labels, topup, revenue}) {
    const lineEl = document.getElementById('chartLine');
    const pieEl  = document.getElementById('chartPie');

    if (lineChart) lineChart.destroy();
    if (pieChart)  pieChart.destroy();

    // กราฟรายได้ (Bar Chart สีน้ำเงินสด)
    lineChart = new Chart(lineEl, {
      type: 'bar',
      data: { 
        labels, 
        datasets: [{
          label: '💰 รายได้รวม',
          data: revenue,
          backgroundColor: [
            'rgba(102, 126, 234, 0.85)',
            'rgba(118, 75, 162, 0.85)',
            'rgba(240, 147, 251, 0.85)',
          ],
          borderColor: 'rgba(102, 126, 234, 1)',
          borderWidth: 0,
          borderRadius: 8,
          borderSkipped: false,
          barThickness: 'flex',
          maxBarThickness: 60,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
          y: { 
            beginAtZero: true,
            grid: { color: 'rgba(200, 200, 200, 0.15)', drawBorder: false },
            ticks: { 
              callback: function(value) { return numberBaht(value) + ' ฿'; },
              color: '#888',
              font: { size: 12, weight: 500 },
              padding: 8
            }
          },
          x: {
            grid: { display: false, drawBorder: false },
            ticks: { color: '#888', font: { size: 12 } }
          }
        },
        plugins: {
          tooltip: { 
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false,
            callbacks: { 
              title: (ctx) => '📊 ' + ctx[0].label,
              label: (ctx) => `💰 ${numberBaht(ctx.parsed.y)} บาท` 
            }
          },
          legend: { display: false },
          filler: { propagate: true }
        },
        animation: { 
          duration: 800, 
          easing: 'easeOutQuart',
          delay: (ctx) => {
            let delay = 0;
            if (ctx.type === 'data') {
              delay = ctx.dataIndex * 50;
            }
            return delay;
          },
        }
      }
    });

    // กราฟเติมเงิน (Line Chart สีเขียว/Teal)
    pieChart = new Chart(pieEl, {
      type: 'line',
      data: { 
        labels, 
        datasets: [{
          label: '💳 ยอดเติมเงิน',
          data: topup,
          borderColor: 'rgba(79, 172, 254, 1)',
          backgroundColor: 'rgba(79, 172, 254, 0.15)',
          tension: 0.45,
          fill: true,
          pointBackgroundColor: 'rgba(79, 172, 254, 1)',
          pointBorderColor: '#fff',
          pointBorderWidth: 3,
          pointRadius: 6,
          pointHoverRadius: 9,
          pointHoverBackgroundColor: 'rgba(79, 172, 254, 1)',
          pointStyle: 'circle',
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { 
          y: { 
            beginAtZero: true,
            grid: { color: 'rgba(200, 200, 200, 0.15)', drawBorder: false },
            ticks: { 
              callback: function(value) { return numberBaht(value) + ' ฿'; },
              color: '#888',
              font: { size: 12, weight: 500 },
              padding: 8
            }
          },
          x: {
            grid: { display: false, drawBorder: false },
            ticks: { color: '#888', font: { size: 12 } }
          }
        },
        plugins: {
          tooltip: { 
            backgroundColor: 'rgba(0,0,0,0.9)',
            titleColor: '#fff',
            bodyColor: '#fff',
            padding: 12,
            cornerRadius: 8,
            displayColors: false,
            callbacks: { 
              title: (ctx) => '📅 ' + ctx[0].label,
              label: (ctx) => `💳 ${numberBaht(ctx.parsed.y)} บาท` 
            }
          },
          legend: { display: false },
          filler: { propagate: true }
        },
        animation: { 
          duration: 900, 
          easing: 'easeOutQuart',
          delay: (ctx) => {
            let delay = 0;
            if (ctx.type === 'data') {
              delay = ctx.dataIndex * 50 + 100;
            }
            return delay;
          },
        }
      }
    });
  }

  async function reload() {
    const url = buildUrl();
    const res = await fetch(url, {cache:'no-store', credentials:'same-origin'});
    if (!res.ok) throw new Error('HTTP '+res.status);
    const ct = res.headers.get('content-type') || '';
    if (!ct.includes('application/json')) throw new Error('ไม่ใช่ JSON: '+ct);
    const data = await res.json();
    whenChartReady(()=>draw(data));
  }

  controls.querySelector('#rangeSelect').addEventListener('change', (e)=>{
    const isYear = e.target.value === 'year';
    ysel.style.display = isYear ? '' : 'none';
    reload().catch(console.error);
  });
  ysel.addEventListener('change', ()=> reload().catch(console.error));

  // โหลดครั้งแรก
  reload().catch(err=>{
    console.error('Dashboard API error:', err);
    const l = document.getElementById('chartLine')?.parentElement;
    const p = document.getElementById('chartPie')?.parentElement;
    const msg = '<div style="padding:8px;color:#c00;">ไม่สามารถโหลดข้อมูลได้</div>';
    if (l) l.insertAdjacentHTML('beforeend', msg);
    if (p) p.insertAdjacentHTML('beforeend', msg);
  });
})();
</script>
