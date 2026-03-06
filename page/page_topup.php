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


<!-- ประวัติการเติมเงิน -->
<div class="col-md-12 col-sm-12 mt-4">
    <!-- crad_tung text-black -->
    <div class="card mb-3">
        <div class="card-header"><i class="fa-solid fa-wallet" style="color:#3D9B00;"></i> Topup History - ประวัติการเติมเงิน</div>
        <div class="card-body">
            <?php
            $result = $connect->query("SELECT * FROM pp_topup WHERE username = '" . $users_username . "'; ");
            $rewardshistorys = $result->fetch_all(MYSQLI_ASSOC);
            ?>
            <?php if ($result->num_rows == 0) : ?>
                <div class="alert alert-dismissible alert-warning">
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert"></button> -->
                    <h4 class="alert-heading">Warning!</h4>
                    <p class="mb-0">ยังไม่มีประวัติการทำรายการ.</p>
                </div>

            <?php else: ?>
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-center mt-2">
                        <div class="table-responsive">
                            <table id="tbl_topuphistory" cellspacing="1" class="table table-striped table-bordered display text-black">
                                <thead>
                                    <tr>
                                        <th>#Order</th>
                                        <th><i class="fa-solid fa-computer"></i> Pay</th>
                                        <th><i class="fa-solid fa-credit-card"></i> Credit</th>
                                        <th><i class="fa-solid fa-font-awesome"></i> Status</th>
                                        <th><i class="fa-solid fa-clock"></i> Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($rewardshistorys as $rewardshistory) :  ?>
                                        <tr>
                                            <td><?= $rewardshistory['id']; ?></td>
                                            <td><?= $rewardshistory['topupby']; ?></td>
                                            <td><?= $rewardshistory['point']; ?></td>
                                            <td>
                                                <?php if ($rewardshistory['status'] == 1): ?>
                                                    <span style="color:#1b4d0a;"><i class="fa-solid fa-check"></i> ผ่าน</span>
                                                <?php else: ?>
                                                    <span style="color:#1b4d0a;"><i class="fa-solid fa-circle-info"></i> รอแอดมินตรวจสอบ</span>
                                                <?php endif ?>
                                            </td>
                                            <td><?= th($rewardshistory['topuptime']); ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
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