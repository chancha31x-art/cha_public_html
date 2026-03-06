<div class="col-md-12 col-sm-12 mt-4 mb-2" data-aos="fade-up">

    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="assets/img/bar/01.jpg" class="d-block w-100 rounded-3" alt="s1.png">
            </div>
            <div class="carousel-item">
            <img src="assets/img/bar/02.jpg" class="d-block w-100 rounded-3" alt="s2.png">
            </div>
            <div class="carousel-item">
            <img src="assets/img/bar/s1.png" class="d-block w-100 rounded-3" alt="s3.png">
            </div>
            <div class="carousel-item">
            <img src="assets/img/bar/s3.png" class="d-block w-100 rounded-3" alt="s4.png">
            </div>
            <div class="carousel-item">
            <img src="assets/img/bar/s4.png" class="d-block w-100 rounded-3" alt="s5.png">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

</div>

<?php include('page/page_mee.php'); ?>


<div class="col-md-12 col-sm-12 col-12 mt-4 mb-4">
    <div class="crad crd_tung rounded-3" style="background: linear-gradient(135deg, rgb(255, 255, 255) 0%, rgba(255, 255, 255, 0.62) 100%); padding: 30px;">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 28px; font-weight: 800; color: #333;">
                <i class='bx bx-store' style="color: #667eea; margin-right: 10px;"></i> รายการสินค้า
            </h1>
            <span style="color: #000000; font-size: 16px; font-weight: 500;">( ร้านค้า )</span>
        </div>
        <div style="height: 3px; background: linear-gradient(90deg, #667eea, #764ba2, #f093fb); border-radius: 2px; margin-bottom: 25px;"></div>

        <div class="row g-3">
            <?php 
                $result_category = $connect->query("SELECT * FROM pp_category_api WHERE status = '1' ORDER BY id asc;");
                $res_categorys = $result_category->fetch_all(MYSQLI_ASSOC);
                $counter = 0;
                foreach($res_categorys as $res_category) : 
                $counter++;

                $count_pshopall = $connect->query("SELECT SUM(stock) AS sum_stock FROM pp_shop_stock_api WHERE category = '".$res_category['id']."'"); 
                $row_pshopall = mysqli_fetch_assoc($count_pshopall); 
                $rows_pshopall = $row_pshopall['sum_stock'];
                
                $check_available = $connect->query("SELECT COUNT(*) as available_items FROM pp_shop_stock_api WHERE category = '".$res_category['id']."' AND stock > 0");
                $available_result = mysqli_fetch_assoc($check_available);
                $has_stock = $available_result['available_items'] > 0;
                
                $stock_status = $connect->query("SELECT 
                    COUNT(*) as total_items,
                    SUM(CASE WHEN stock > 0 THEN 1 ELSE 0 END) as in_stock,
                    SUM(CASE WHEN stock = 0 THEN 1 ELSE 0 END) as out_of_stock
                    FROM pp_shop_stock_api WHERE category = '".$res_category['id']."'");
                $stock_info = mysqli_fetch_assoc($stock_status);
            ?>

            <div class="col-md-2 col-sm-3 col-6">
                <div class="card h-100" style="cursor: pointer; border: 2px solid #f0f0f0; border-radius: 15px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; transition: box-shadow 0.3s, border-color 0.3s;" 
                     onmouseover="this.style.boxShadow='0 8px 20px rgba(102,126,234,0.2)'; this.style.borderColor='#667eea';"
                     onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.08)'; this.style.borderColor='#f0f0f0';"
                     data-bs-toggle="modal" data-bs-target="#byshop<?=$res_category['id']?>">
                    
                    <div style="background: linear-gradient(135deg, #667eea15 0%, #f093fb15 100%); padding: 15px; text-align: center; position: relative; overflow: hidden;">
                        <img src="<?=$res_category['img']?>" style="height: 90px; width: 90px; border-radius: 12px; object-fit: cover; box-shadow: 0 4px 12px rgba(102,126,234,0.2);" alt="<?=$res_category['name']?>">
                    </div>
                    
                    <div class="card-body p-3" style="background: white;">
                        <h5 style="font-weight: 700; font-size: 15px; color: #333; margin-bottom: 10px; line-height: 1.3;"><?=$res_category['name']?></h5>
                        
                        <div style="margin-bottom: 12px;">
                            <?php if ($has_stock): ?>
                                <span class="badge" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); font-size: 11px; padding: 6px 10px; border-radius: 6px; color: white; font-weight: 600;">✓ พร้อมจำหน่าย</span>
                            <?php else: ?>
                                <span class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); font-size: 11px; padding: 6px 10px; border-radius: 6px; color: white; font-weight: 600;">✕ สินค้าหมด</span>
                            <?php endif; ?>
                        </div>
                        
                        <div style="padding-top: 10px; border-top: 1px solid #f0f0f0;">
                            <small style="color: #667eea; font-weight: 700; display: block; margin-bottom: 4px;">📦 คงเหลือ</small>
                            <small style="color: #333; font-weight: 600; font-size: 14px;"><?=number_format($rows_pshopall)?> ชิ้น</small>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php foreach ($res_categorys as $res_category) : ?>
<!-- Modal -->
<div class="modal fade" id="ShopModal<?=$res_category['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5" id="exampleModalLabel"><?=$res_category['name']?></h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <center><img src="<?=$res_category['img']?>" class="p-4" style="width:11.1rem;"></center>
            <h5><?=$res_category['name']?></h5>
            
        </div>
        <p><?=$res_category['info']?></p>
    
      </div>
      <div class="modal-footer">
       
        <button type="button" class="btn btn-danger w-40" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php  endforeach; ?>

<?php  foreach($res_categorys as $res_category) : ?>
  <!-- Modal -->
<div class="modal fade" id="byshop<?=$res_category['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-category-id="<?=$res_category['id'];?>">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"><?=$res_category['name']?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-4">
                        <img src="<?=$res_category['img']?>" style="border-color: #000;border-style: solid;border-width: 3px;height: 6.9rem;width: 6.9rem;border-radius: 50%;" alt="<?=$res_category['img']?>" class="card-img-top img-proflie">
                    </div>
                </div>
                <div class="col-md-8">
                    <select class="form-select" onchange="get_info(value,<?=$res_category['id']?>)" id="idshop<?=$res_category['id'] ?>" aria-label="Default select example" >
            
                        <option value="" selected>เลือกรายการ</option>
                        <?php 
                            $id_c = $res_category['id'];
                            $result_shop = $connect->query("SELECT * FROM pp_shop_stock_api WHERE category = '".$id_c."' ORDER BY price_web asc;");
                            $res_shop = $result_shop->fetch_all(MYSQLI_ASSOC);
                            $i= 1;
                            foreach($res_shop as $res_shops) : 
                        ?>

                        <option value="<?=$res_shops['id'] ?>"><?=$res_shops['name'] ?> (<?=number_format($res_shops['price_web'], 0)?> บาท)</option>
                        <?php endforeach ?>
                    </select>

                    <div class="form-group mt-2">
                        <h6><span id="price_web<?=$res_category['id'] ?>"></span></h6>
                    </div>
                    <div class="form-group">
                        <h6><span id="stock<?=$res_category['id'] ?>"></span></h6>
                    </div>

                </div>
           </div>
            <!-- <center>
                <img src="<?=$res_category['img']?>" alt="<?=$res_category['img']?>" width="70%" height="200px" class="mb-3">
            </center> -->
          
            <div class="col-12 m-2">
                
                <!-- <div id="price_web<?=$res_category['id'] ?>"></div>
                <center><div id="stock<?=$res_category['id'] ?>"></div></center> -->

                <div id="info<?=$res_category['id'] ?>"></div>
        
           </div>


        </div>
        <div class="modal-footer">
            <?php if(!empty($_SESSION['username'])): ?>
            <button type="button" class="btn btn-buyshop" onclick="byshopa(<?=$res_category['id'] ?>)">ซื้อสินค้า</button>
            <?php else: ?>
            <button type="button" class="btn btn-buyshop" onclick="CradURL('./page/login')">เข้าสู่ระบบเพื่อซื้อสินค้า</button>
            <?php endif ?>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>

<?php endforeach; ?>

<script>

// Reset modal data when opening
document.querySelectorAll('.modal').forEach(modal => {
    modal.addEventListener('show.bs.modal', function(e) {
        const categoryId = this.getAttribute('data-category-id');
        // Reset form elements
        document.getElementById('idshop' + categoryId).selectedIndex = 0;
        document.getElementById('price_web' + categoryId).innerHTML = '';
        document.getElementById('stock' + categoryId).innerHTML = '';
        document.getElementById('info' + categoryId).innerHTML = '';
    });
});

function get_info(id,modal){
// var property = document.getElementById('photo').files[0];
var form_data = new FormData();
form_data.append("id", id);

$.ajax({
    url: 'system/master.php?showinfo',
    method: 'POST',
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    beforeSend: function() {
        $('#msg').html('Loading......');
    },
    success: function(data) {
        console.log(data.info)
        // $( "#info"+modal ).html( data.info );
        if(data.info != null){
            document.getElementById("info"+modal).innerHTML = data.info;
            document.getElementById("price_web"+modal).innerHTML = '<i class="fa-solid fa-sack-dollar text-warning"></i> ราคา: <span class="badge bg-info">'+data.price_web+' บาท</span>';
            // document.getElementById("stock"+modal).innerHTML = "<h4 class='text-center'> สินค้าคงเหลือ"+ data.stock +"ชิ้น </h4>";
            if(data.stock == 0){
                document.getElementById("stock"+modal).innerHTML = '<p class="text-cennter"><i class="fa-solid fa-circle-notch fa-spin text-danger"></i> <span class="badge bg-danger">สินค้าหมด</span></p>';
            }else{
                document.getElementById("stock"+modal).innerHTML = '<p class="text-cennter"><i class="fa-solid fa-box-open text-warning"></i> คงเหลือ : <span class="badge bg-success">'+data.stock+' ชิ้น</span></p>';
            }
        }else{
            document.getElementById("info"+modal).innerHTML ="";
            document.getElementById("price_web"+modal).innerHTML = "";
            document.getElementById("stock"+modal).innerHTML = '';
        }
        // $("#btn").prop("disabled", true);
        // $( "#return" ).html( data );
        // $("#btn").prop("disabled", false); 
    }
});
}

</script>