<div class="col-md-12 col-sm-12 mt-2">
    <div class="alert alert-warning" role="alert">
        <h5><i class='bx bx-error-alt'></i> 🚨 ระบบเติมเงินผ่านทางธนาคารอยู่ในช่วงปรับปรุง งดเติมเงิน หากชำระเงินเข้าสู่ระบบแล้วไม่มีการคืนเงิน <b>ทุกกรณี 🚨</b></h5>
    </div>
</div>
<div class="col-md-4 col-sm-12 mt-2 hvr-shrink" data-bs-toggle="modal" data-bs-target="#truewallet">
    <div class="card text-black mb-3 shadow-lg" data-aos="zoom-in-up">
        <div class="card-body text-center">

            <img src="assets/img/icons/truewallet.png" alt="truewallet" height="120px" class="center-menu mt-3 mb-3">
            <h4 class="text-black">เติมเงินด้วย True Wallet</h4>
            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#truewallet">เติมเงิน</button></td>


        </div>
    </div>
</div>

<div class="col-md-4 col-sm-12 mt-2 hvr-shrink" data-bs-toggle="modal" data-bs-target="#bankContact">
    <div class="card text-black mb-3 shadow-lg" data-aos="zoom-in-up">
        <div class="card-body text-center">

            <img src="assets/img/icons/slipscanpay.png" height="120px" alt="Bank" class="center-menu mt-3 mb-3">
            <h4 class="text-black">เติมเงินผ่านธนาคาร</h4>

            <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal" data-bs-target="#bankContact">ติดต่อ</button></td>
        </div>
    </div>
</div>


<!-- ประวัติการเติมเงิน Manual (แอดมินเติมให้) -->
<div class="col-md-12 col-sm-12 mt-4">
    <div class="card mb-3" style="border: none; border-radius: 12px; overflow: hidden;">
        <div class="card-header" style="background: linear-gradient(135deg, #ffa751 0%, #ffe259 100%); color: white; border: none; padding: 1.25rem;">
            <h5 class="mb-0">
                <i class="fa-solid fa-hand-holding-dollar" style="color: white;"></i> 
                <strong>ประวัติเติมเงินด้วยตนเอง (Manual)</strong>
            </h5>
            <small style="opacity: 0.9;">ประวัติการเติมเงินที่แอดมินเติมให้</small>
        </div>
        <div class="card-body" style="background-color: #fff9f0;">
            <?php
            $result_manual = $connect->query("SELECT * FROM pp_topup WHERE topupby = 'manual' ORDER BY topuptime DESC LIMIT 100;");
            $manual_topups = $result_manual->fetch_all(MYSQLI_ASSOC);
            ?>
            <?php if ($result_manual->num_rows == 0) : ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa-solid fa-info-circle"></i>
                    <strong>ไม่มีประวัติเติมเงิน</strong>
                    <p class="mb-0">ยังไม่มีการเติมเงินด้วยตนเองในระบบ</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table id="tbl_manual_topup" class="table table-hover table-striped text-dark" style="border-radius: 8px;">
                        <thead style="background: linear-gradient(135deg, #ffa751 0%, #ffe259 100%); color: white;">
                            <tr>
                                <th><i class="fa-solid fa-hash"></i> #</th>
                                <th><i class="fa-solid fa-user"></i> ชื่อผู้ใช้</th>
                                <th><i class="fa-solid fa-coins"></i> จำนวนเงิน</th>
                                <th><i class="fa-solid fa-check-circle"></i> สถานะ</th>
                                <th><i class="fa-solid fa-calendar-days"></i> วันที่ - เวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($manual_topups as $idx => $topup) : ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-warning text-dark"><?= ($idx + 1); ?></span>
                                    </td>
                                    <td>
                                        <strong style="color: #ffa751;">
                                            <i class="fa-solid fa-user-circle me-1"></i><?= htmlspecialchars($topup['username']); ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-success" style="font-size: 0.95rem; padding: 0.5rem 0.75rem;">
                                            <i class="fa-solid fa-hand-holding-dollar me-1"></i><?= number_format($topup['point'], 2); ?> บาท
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($topup['status'] == 1): ?>
                                            <span class="badge bg-success">
                                                <i class="fa-solid fa-check-circle me-1"></i>สำเร็จ
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa-solid fa-hourglass-end me-1"></i>รอการอนุมัติ
                                            </span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fa-solid fa-clock me-1"></i><?= th($topup['topuptime']); ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ประวัติการเติมเงิน -->
<div class="col-md-12 col-sm-12 mt-4">
    <div class="card mb-3" style="border: none; border-radius: 12px; overflow: hidden;">
        <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 1.25rem;">
            <h5 class="mb-0">
                <i class="fa-solid fa-wallet"></i> 
                <strong>ประวัติการเติมเงินทั้งหมด</strong>
            </h5>
            <small style="opacity: 0.9;">ประวัติการเติมเงินของคุณ</small>
        </div>
        <div class="card-body" style="background-color: #f8f9ff;">
            <?php
            $result = $connect->query("SELECT * FROM pp_topup WHERE username = '" . $users_username . "' ORDER BY topuptime DESC;");
            $rewardshistorys = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            <?php if ($result->num_rows == 0) : ?>
                <div class="alert alert-info" role="alert">
                    <i class="fa-solid fa-info-circle"></i>
                    <strong>ไม่มีประวัติเติมเงิน</strong>
                    <p class="mb-0">คุณยังไม่มีประวัติการเติมเงิน</p>
                </div>

            <?php else: ?>
                <div class="table-responsive">
                    <table id="tbl_topuphistory" class="table table-hover table-striped text-dark" style="border-radius: 8px;">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th><i class="fa-solid fa-hash"></i> #Order</th>
                                <th><i class="fa-solid fa-computer"></i> วิธีการเติม</th>
                                <th><i class="fa-solid fa-coins"></i> จำนวนเงิน</th>
                                <th><i class="fa-solid fa-check-circle"></i> สถานะ</th>
                                <th><i class="fa-solid fa-calendar-days"></i> วันที่ - เวลา</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($rewardshistorys as $rewardshistory) :  ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary"><?= $rewardshistory['id']; ?></span>
                                    </td>
                                    <td>
                                        <?php 
                                            $topupby = $rewardshistory['topupby'];
                                            $badges = [
                                                'manual' => ['bg-warning text-dark', '🎯 Manual'],
                                                'Slip' => ['bg-info', '📄 Slip'],
                                                'อั่งเป่า' => ['bg-success', '🎁 อังเป่า']
                                            ];
                                            $badge = $badges[$topupby] ?? ['bg-secondary', htmlspecialchars($topupby)];
                                        ?>
                                        <span class="badge <?= $badge[0]; ?>"><?= $badge[1]; ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            <i class="fa-solid fa-hand-holding-dollar me-1"></i><?= number_format($rewardshistory['point'], 2); ?> บาท
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if ($rewardshistory['status'] == 1): ?>
                                            <span class="badge bg-success">
                                                <i class="fa-solid fa-check-circle me-1"></i>สำเร็จ
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa-solid fa-hourglass-end me-1"></i>รอการตรวจสอบ
                                            </span>
                                        <?php endif ?>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fa-solid fa-clock me-1"></i><?= th($rewardshistory['topuptime']); ?>
                                        </small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="howtotopup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">วิธีเติมเงินด้วยอังเป่า</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="assets/img/aungpao_truewallet.png" style="height: 100%;width: 100%; " alt="a" class="card-img-top img-proflie">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info w-100" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="truewallet" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5> Topup - เติมเงิน</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 col-sm-12">
                    <div class="card crad_tung mb-3 text-black">

                        <div class="card-body">

                            <div class="mb-4 text-center">
                                <img src="assets/img/icons/truewallet.png" style="height: 9.9rem;width: 9.9rem; " alt="a" class="card-img-top img-proflie">
                            </div>
                            <div class="form-group mb-3">
                                <label class="col-form-label" for="inputDefault"><i class="fa-solid fa-link"></i> Aungpao - ลิ้งอังเป่า <a href="" data-bs-toggle="modal" data-bs-target="#howtotopup"> วิธีเติมเงินด้วยอังเป่า</a> </label>
                                <input type="text" class="form-control" placeholder="https://gift.truemoney.com/campaign/?v=xxxx" id="link_topup">
                            </div>
                            <div class="form-group mb-3">
                                <div class="g-recaptcha d-flex align-items-center justify-content-center" style="margin-top: 15px;" data-sitekey="<?php echo SITE_KEY; ?>"></div>
                            </div>

                            <div class="form-group mb-3">
                                <button onclick="topups()" class="btn btn-primary w-100"><i class="fa-solid fa-circle-check"></i> ตรวจสอบข้อมูล</button>
                            </div>

                        </div>
                    </div>
                </div>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal สำหรับติดต่อเติมเงินผ่านธนาคาร -->
<div class="modal fade" id="bankContact" tabindex="-1" aria-labelledby="bankContactLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bankContactLabel">เติมเงินผ่านธนาคาร</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <i class="fa-solid fa-bank" style="font-size: 4rem; color: #007bff;"></i>
                </div>
                <h5 class="mb-3">เติมเงินผ่านธนาคาร</h5>
                <p class="mb-4">กรุณาติดต่อเราผ่านเพจ Facebook เพื่อเติมเงินผ่านธนาคาร</p>
                <a href="https://www.facebook.com/xth.shops" target="_blank" class="btn btn-primary btn-lg w-100">
                    <i class="fa-brands fa-facebook"></i> ไปยัง Facebook
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Slip - ซ่อนไว้ -->




<script>
    var loadFile = function(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    };

    function click_image() {
        $('#photo').click();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/jsqr@1.1.0/dist/jsQR.js"></script>
<script>
    function File2Base64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result);
            reader.onerror = (error) => reject(error);
        });
    }
    async function imageDataFromSource(source) {
        const image = Object.assign(new Image(), {
            src: source
        });
        await new Promise((resolve) => image.addEventListener('load', () => resolve()));
        const context = Object.assign(document.createElement('canvas'), {
            width: image.width,
            height: image.height,
        }).getContext('2d');
        context.imageSmoothingEnabled = false;
        context.drawImage(image, 0, 0);
        return context.getImageData(0, 0, image.width, image.height);
    }
    //
</script>
<script>
    function ok_slip() {

        var vidFileLength = $("#photo")[0].files.length;
        var url = $('#photo').val();
        var idxDot = url.lastIndexOf(".") + 1;
        var extFile = url.substr(idxDot, url.length).toLowerCase();
        // console.log(extFile)
        if (vidFileLength === 0) {
            $('#msg').html('<i class="fa-solid fa-triangle-exclamation"></i> กรุณาเลือกรูปภาพสลืป');
            return false;
        }
        var property = document.getElementById('photo').files[0];

        if (extFile == "png" || extFile == "jpeg" || extFile == "jpg") {

            var qrcode;
            const reader = new FileReader();
            reader.onload = async function(e) {
                const URLBase64 = await File2Base64(property);
                const ImageData = await imageDataFromSource(URLBase64);
                const code = jsQR(ImageData.data, ImageData.width, ImageData.height);
                qrcode = code.data;
                console.log(qrcode)
                if (code && code.data) {
                    //--
                    var form_data = new FormData();
                    form_data.append('qrcode', qrcode);
                    console.log(qrcode);
                    $.ajax({
                        url: 'system/master.php?rdcwslipapi=api',
                        // url: 'cmd.php?slipapi=api',
                        method: 'POST',
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $('#msg').html('<i class="fa fa-spinner fa-spin fa-fw"></i> กำลังตรวจสอบข้อมูล..');
                            $(".btn-slip").html('<i class="fa fa-spinner fa-spin fa-fw"></i> กำลังตรวจสอบข้อมูล..');
                            $(".btn-slip").prop("disabled", true);
                        },
                        success: function(data) {
                            $("#return").html(data);
                            // $("#btn").prop("disabled", false); 
                            $(".btn-slip").prop("disabled", false);
                            $(".btn-slip").html('<i class="fa-solid fa-circle-check"></i> ตรวจสอบข้อมูล');
                            // $('#msg').html('<i class="fa-solid fa-triangle-exclamation"></i> เติมเงินไม่สำเร็จ.');
                        }
                    });
                    //--
                }
            }
            reader.readAsDataURL(property);
        } else {
            $('#msg').html('<i class="fa-solid fa-triangle-exclamation"></i> นามสกุลไฟล์ไม่ถูกต้อง');
        }

    }

    document.getElementById("cp_btn").addEventListener("click", copy_backid);

    function copy_backid() {
        var copyText = document.getElementById("backid");
        var textArea = document.createElement("textarea");
        textArea.value = copyText.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");

        Swal.fire(
            'คัดลอก',
            'เลขบัญชี ' + textArea.value + ' แล้ว!!',
            'success'
        )

        textArea.remove();


    }
</script>