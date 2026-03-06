<style>
:root {
    --grad: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --grad-full: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    --soft: #f8f7ff;
    --card-radius: 22px;
    --accent: #667eea;
    --accent2: #f093fb;
}

/* ===== HERO ===== */
.contact-hero {
    background: var(--grad-full);
    border-radius: var(--card-radius);
    padding: 56px 30px 50px;
    text-align: center;
    position: relative;
    overflow: hidden;
    margin-bottom: 32px;
}
.contact-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 20% 50%, rgba(255,255,255,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 20%, rgba(255,255,255,0.10) 0%, transparent 50%);
}
.contact-hero h1 {
    font-size: 2.2rem; font-weight: 900;
    color: white; position: relative; z-index: 2;
    text-shadow: 0 2px 8px rgba(0,0,0,0.2);
    margin-bottom: 10px;
}
.contact-hero p {
    color: rgba(255,255,255,0.88); font-size: 1.05rem;
    position: relative; z-index: 2;
}
.hero-badge {
    display: inline-block;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    color: white; padding: 6px 18px;
    border-radius: 50px; font-size: 0.82rem; font-weight: 700;
    margin-bottom: 16px; position: relative; z-index: 2;
}
.hero-float {
    position: absolute;
    font-size: 55px; opacity: 0.12;
    animation: hfloat 6s ease-in-out infinite;
}
.hero-float:nth-child(1) { top: 10%; left: 6%; animation-delay: 0s; }
.hero-float:nth-child(2) { top: 55%; right: 8%; animation-delay: 1.5s; }
.hero-float:nth-child(3) { bottom: 15%; left: 25%; animation-delay: 3s; }
@keyframes hfloat {
    0%,100% { transform: translateY(0) rotate(0deg); }
    50%      { transform: translateY(-18px) rotate(8deg); }
}

/* ===== CHANNEL CARDS ===== */
.channel-card {
    background: white;
    border-radius: var(--card-radius);
    padding: 28px 22px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(102,126,234,0.10);
    transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
    cursor: pointer;
    border: 2px solid transparent;
    text-decoration: none !important;
    display: block;
    height: 100%;
}
.channel-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(102,126,234,0.22);
    border-color: var(--accent);
    text-decoration: none;
}
.channel-icon {
    width: 66px; height: 66px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.9rem; margin: 0 auto 14px;
    transition: transform 0.3s ease;
}
.channel-card:hover .channel-icon {
    transform: scale(1.12) rotate(-5deg);
}
.channel-name {
    font-weight: 800; font-size: 1rem; color: #1a202c;
    margin-bottom: 5px;
}
.channel-desc {
    font-size: 0.82rem; color: #64748b; line-height: 1.5;
    margin-bottom: 14px;
}
.channel-link-btn {
    display: inline-block;
    padding: 7px 20px;
    border-radius: 50px; font-size: 0.82rem; font-weight: 700;
    text-decoration: none !important; transition: all 0.2s ease;
    border: 2px solid transparent;
}
.channel-link-btn:hover { opacity: 0.85; transform: scale(1.05); }

/* ===== INFO BOXES ===== */
.info-section {
    background: white;
    border-radius: var(--card-radius);
    padding: 28px 28px;
    box-shadow: 0 4px 20px rgba(102,126,234,0.08);
    height: 100%;
}
.info-section h5 {
    font-weight: 800; font-size: 1.05rem; color: #1a202c;
    margin-bottom: 18px;
    display: flex; align-items: center; gap: 8px;
}
.info-row {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f1f5f9;
}
.info-row:last-child { border-bottom: none; }
.info-icon {
    width: 36px; height: 36px; border-radius: 10px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
.info-label { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }
.info-value { font-size: 0.9rem; color: #374151; font-weight: 600; margin-top: 1px; }

/* ===== FORM ===== */
.contact-form-wrap {
    background: white;
    border-radius: var(--card-radius);
    padding: 32px 28px;
    box-shadow: 0 4px 20px rgba(102,126,234,0.08);
}
.contact-form-wrap h5 {
    font-weight: 800; font-size: 1.1rem; color: #1a202c;
    margin-bottom: 22px;
    display: flex; align-items: center; gap: 8px;
}
.cf-label {
    font-size: 0.82rem; font-weight: 700; color: #374151;
    margin-bottom: 6px; display: block;
}
.cf-input {
    width: 100%; padding: 11px 16px;
    border: 2px solid #e2e8f0; border-radius: 14px;
    font-size: 0.9rem; font-family: 'Kanit', sans-serif;
    transition: all 0.2s ease; outline: none;
    background: #fafafa;
}
.cf-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(102,126,234,0.12);
    background: white;
}
.cf-textarea { min-height: 110px; resize: vertical; }
.btn-send {
    background: var(--grad);
    color: white; border: none;
    border-radius: 14px; font-weight: 700;
    padding: 13px 30px; width: 100%;
    font-size: 0.95rem; font-family: 'Kanit', sans-serif;
    cursor: pointer; transition: all 0.25s ease;
    margin-top: 4px;
}
.btn-send:hover {
    box-shadow: 0 8px 20px rgba(102,126,234,0.4);
    transform: translateY(-2px);
}
.btn-send:active { transform: scale(0.98); }

/* ===== SECTION TITLE ===== */
.sec-title {
    font-size: 1.25rem; font-weight: 800; color: #1a202c;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 10px;
}
.sec-title::after {
    content: '';
    flex: 1; height: 2px;
    background: linear-gradient(90deg, rgba(102,126,234,0.3), transparent);
    border-radius: 2px;
}

/* ===== HOURS BADGE ===== */
.hours-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534; padding: 8px 16px; border-radius: 50px;
    font-size: 0.82rem; font-weight: 700; margin-top: 8px;
}
.hours-dot {
    width: 8px; height: 8px; background: #16a34a;
    border-radius: 50%; animation: blink 1.5s infinite;
}
@keyframes blink {
    0%,100% { opacity: 1; } 50% { opacity: 0.3; }
}

/* ===== SUCCESS TOAST ===== */
.cf-success {
    display: none;
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534; padding: 14px 18px;
    border-radius: 14px; font-weight: 700; font-size: 0.9rem;
    margin-top: 12px; text-align: center;
}
</style>

<div class="col-12 mt-3 mb-5">

    <!-- HERO -->
    <div class="contact-hero" data-aos="fade-up">
        <span class="hero-float">💬</span>
        <span class="hero-float">📱</span>
        <span class="hero-float">⚡</span>
        <div class="hero-badge">📞 ติดต่อเรา</div>
        <h1>พร้อมช่วยเหลือคุณ<br>ตลอด 24 ชั่วโมง</h1>
        <p>มีคำถามหรือปัญหาใด? ทีมงานพร้อมตอบทุกช่องทาง</p>
        <div class="hours-badge" style="margin-top:20px;">
            <span class="hours-dot"></span> Online ตอนนี้ · ตอบภายใน 5 นาที
        </div>
    </div>

    <!-- CHANNEL CARDS -->
    <div class="sec-title" data-aos="fade-up">
        <i class="fas fa-satellite-dish" style="color:var(--accent);"></i> ช่องทางติดต่อ
    </div>
    <div class="row g-3 mb-4">

        <!-- Facebook -->
        <div class="col-md-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="0">
            <a href="https://www.facebook.com/xth.shops" target="_blank" class="channel-card">
                <div class="channel-icon" style="background:linear-gradient(135deg,#1877f2,#0d5fce);">
                    <i class="fab fa-facebook-f" style="color:white;"></i>
                </div>
                <div class="channel-name">Facebook</div>
                <div class="channel-desc">ติดตามข่าวสาร โปรโมชั่น และสอบถามได้</div>
                <span class="channel-link-btn" style="background:linear-gradient(135deg,#1877f2,#0d5fce);color:white;">
                    เยี่ยมชม <i class="fas fa-arrow-right ms-1"></i>
                </span>
            </a>
        </div>

        <!-- Messenger -->
        <div class="col-md-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="80">
            <a href="https://m.me/587191811137461" target="_blank" class="channel-card">
                <div class="channel-icon" style="background:linear-gradient(135deg,#0084ff,#a033ff);">
                    <i class="fab fa-facebook-messenger" style="color:white;"></i>
                </div>
                <div class="channel-name">Messenger</div>
                <div class="channel-desc">แชทสด ตอบเร็ว แก้ปัญหาได้ทันที</div>
                <span class="channel-link-btn" style="background:linear-gradient(135deg,#0084ff,#a033ff);color:white;">
                    แชทเลย <i class="fas fa-arrow-right ms-1"></i>
                </span>
            </a>
        </div>

        <!-- Telegram -->
        <div class="col-md-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="160">
            <a href="https://t.me/chancha31x" target="_blank" class="channel-card">
                <div class="channel-icon" style="background:linear-gradient(135deg,#0088cc,#005577);">
                    <i class="fab fa-telegram-plane" style="color:white;"></i>
                </div>
                <div class="channel-name">Telegram</div>
                <div class="channel-desc">ติดต่อผ่าน Telegram ได้ตลอดเวลา</div>
                <span class="channel-link-btn" style="background:linear-gradient(135deg,#0088cc,#005577);color:white;">
                    ส่งข้อความ <i class="fas fa-arrow-right ms-1"></i>
                </span>
            </a>
        </div>

        <!-- Line -->
        <div class="col-md-3 col-sm-6 col-6" data-aos="fade-up" data-aos-delay="240">
            <a href="<?=$web_rows['web_line']?>" target="_blank" class="channel-card">
                <div class="channel-icon" style="background:linear-gradient(135deg,#06c755,#059948);">
                    <i class="fab fa-line" style="color:white;"></i>
                </div>
                <div class="channel-name">LINE</div>
                <div class="channel-desc">ติดต่อผ่าน LINE สะดวกรวดเร็ว</div>
                <span class="channel-link-btn" style="background:linear-gradient(135deg,#06c755,#059948);color:white;">
                    เพิ่มเพื่อน <i class="fas fa-arrow-right ms-1"></i>
                </span>
            </a>
        </div>

    </div>

    <!-- INFO + FORM -->
    <div class="row g-3">

        <!-- LEFT: Info -->
        <div class="col-md-4 col-12" data-aos="fade-up" data-aos-delay="0">
            <div class="info-section">
                <h5>
                    <span style="width:32px;height:32px;background:linear-gradient(135deg,#667eea,#764ba2);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;">
                        <i class="fas fa-info"></i>
                    </span>
                    ข้อมูลร้านค้า
                </h5>

                <div class="info-row">
                    <div class="info-icon" style="background:#ede9fe;">🏪</div>
                    <div>
                        <div class="info-label">ชื่อร้าน</div>
                        <div class="info-value"><?=$web_rows['web_name']?></div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon" style="background:#dbeafe;">🌐</div>
                    <div>
                        <div class="info-label">เว็บไซต์</div>
                        <div class="info-value">th-shops.com</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon" style="background:#dcfce7;">⏰</div>
                    <div>
                        <div class="info-label">เวลาทำการ</div>
                        <div class="info-value">ทุกวัน 24 ชั่วโมง</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon" style="background:#fef9c3;">⚡</div>
                    <div>
                        <div class="info-label">เวลาตอบกลับ</div>
                        <div class="info-value">ภายใน 5–15 นาที</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-icon" style="background:#fee2e2;">🛡️</div>
                    <div>
                        <div class="info-label">การรับประกัน</div>
                        <div class="info-value">สินค้าแท้ 100%</div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <div class="hours-badge">
                        <span class="hours-dot"></span> พร้อมให้บริการตอนนี้
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Form -->
        <div class="col-md-8 col-12" data-aos="fade-up" data-aos-delay="100">
            <div class="contact-form-wrap">
                <h5>
                    <span style="width:32px;height:32px;background:linear-gradient(135deg,#f093fb,#f5576c);border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-size:0.85rem;">
                        <i class="fas fa-paper-plane"></i>
                    </span>
                    ส่งข้อความถึงเรา
                </h5>

                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label class="cf-label">👤 ชื่อของคุณ</label>
                        <input type="text" class="cf-input" id="cf_name" placeholder="ชื่อ-นามสกุล">
                    </div>
                    <div class="col-md-6 col-12">
                        <label class="cf-label">📧 อีเมล / ไอดีไลน์</label>
                        <input type="text" class="cf-input" id="cf_contact" placeholder="email@example.com หรือ Line ID">
                    </div>
                    <div class="col-12">
                        <label class="cf-label">📋 หัวข้อ</label>
                        <select class="cf-input" id="cf_subject">
                            <option value="">-- เลือกหัวข้อ --</option>
                            <option value="สอบถามสินค้า">🛒 สอบถามสินค้า</option>
                            <option value="ปัญหาการสั่งซื้อ">⚠️ ปัญหาการสั่งซื้อ</option>
                            <option value="การเติมเงิน">💳 การเติมเงิน</option>
                            <option value="บัญชีมีปัญหา">🔐 บัญชีมีปัญหา</option>
                            <option value="แนะนำ/ติชม">💡 แนะนำ / ติชม</option>
                            <option value="อื่นๆ">📌 อื่นๆ</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="cf-label">✍️ รายละเอียด</label>
                        <textarea class="cf-input cf-textarea" id="cf_message" placeholder="อธิบายปัญหาหรือคำถามของคุณ..."></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn-send" onclick="submitContactForm()">
                            <i class="fas fa-paper-plane me-2"></i> ส่งข้อความ
                        </button>
                        <div class="cf-success" id="cf_success">
                            ✅ ส่งข้อความสำเร็จแล้ว! ทีมงานจะติดต่อกลับโดยเร็ว
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
function submitContactForm() {
    var name    = document.getElementById('cf_name').value.trim();
    var contact = document.getElementById('cf_contact').value.trim();
    var subject = document.getElementById('cf_subject').value;
    var message = document.getElementById('cf_message').value.trim();

    if (!name || !contact || !subject || !message) {
        Swal.fire({
            icon: 'warning', title: 'กรุณากรอกข้อมูลให้ครบ',
            text: 'โปรดกรอกทุกช่องก่อนส่งข้อความ',
            confirmButtonColor: '#667eea'
        });
        return;
    }

    // ส่งไป Telegram หรือ Facebook
    var telegramMsg = encodeURIComponent(
        '📩 ข้อความจากเว็บ TH-SHOPs\n' +
        '👤 ชื่อ: ' + name + '\n' +
        '📧 ติดต่อ: ' + contact + '\n' +
        '📋 หัวข้อ: ' + subject + '\n' +
        '✍️ ข้อความ: ' + message
    );

    // แสดง success + redirect Telegram
    document.getElementById('cf_success').style.display = 'block';
    document.getElementById('cf_name').value    = '';
    document.getElementById('cf_contact').value = '';
    document.getElementById('cf_subject').value = '';
    document.getElementById('cf_message').value = '';

    setTimeout(function() {
        window.open('https://t.me/chancha31x?text=' + telegramMsg, '_blank');
    }, 800);
}
</script>