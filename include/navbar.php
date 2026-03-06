<nav class="navbar navbar-expand-lg navbar-dark shadow-lg sticky-top py-3" 
     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%); border-bottom: 3px solid rgba(255,255,255,0.2);">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#" style="font-size: 1.5rem; color: white; text-shadow: 0 2px 4px rgba(0,0,0,0.2);"><i class="fas fa-crown me-2" style="color: #ffd700;"></i><?=$web_rows['web_name'] ?></a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02"
            aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" style="border-color: rgba(255,255,255,0.3);">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto text-center">
        <li class="nav-item">
          <a class="hvr-icon-up nav-link hvr-underline-from-center text-black <?php if(@$_GET['page']=='home'){echo'active';}?>" href="page/home">
            <small style="font-size:16px;"><i class='bx bx-home-alt hvr-icon'></i> หน้าแรก</small>
          </a>
        </li>

        <li class="nav-item">
          <a class="hvr-icon-up nav-link hvr-underline-from-center text-black <?php if(@$_GET['page']=='shop'){echo'active';}?>" href="page/shop">
            <small style="font-size:16px;"><i class='bx bx-cart hvr-icon'></i> ร้านค้า</small>
          </a>  
        </li>

        <li class="nav-item">
          <a class="hvr-icon-up nav-link hvr-underline-from-center text-black <?php if(@$_GET['page']=='article'){echo'active';}?>" href="/article">
            <small style="font-size:16px;"><i class='bx bx-news hvr-icon'></i> บทความ</small>
          </a>
        </li>

        <?php if(isset($_SESSION['username'])): ?>
        <li class="nav-item">
          <a class="hvr-icon-up nav-link hvr-underline-from-center text-black <?php if(@$_GET['page']=='topup'){echo'active';}?>" href="page/topup">
            <small style="font-size:16px;"><i class='bx bx-wallet-alt hvr-icon'></i> เติมเงิน</small>
          </a>
        </li>
        <li class="nav-item">
          <a class="hvr-icon-up nav-link hvr-underline-from-center text-black <?php if(@$_GET['page']=='history'){echo'active';}?>" href="page/history">
            <small style="font-size:16px;"><i class='bx bx-history hvr-icon'></i> ประวัติการสั่งซื้อ</small>
          </a>
        </li>
        <?php endif; ?>
      </ul>

      <?php if(isset($_SESSION['username'])): ?>
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item me-2">
          <button class="btn btn-light">
            ยอดเงินคงเหลือ <b class="text-primary">฿<?=number_format($users_point,2)?></b> บาท
          </button>
        </li>

        <li class="nav-item dropdown">
          <button class="btn btn-info hvr-icon-up dropdown-toggle"
                  id="userMenu"
                  data-bs-toggle="dropdown"
                  data-bs-boundary="viewport"
                  data-bs-display="static"
                  data-bs-offset="0,8"
                  aria-expanded="false">
            <i class="fa-solid fa-user hvr-icon"></i> <?=$users_username?>
          </button>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-right shadow" aria-labelledby="userMenu">
            <?php if($users_status == $admin_status): ?>
              <li><a class="dropdown-item" href="manage/main"><i class="fa-solid fa-code me-2"></i> จัดการหลังบ้าน</a></li>
              <li><a class="dropdown-item" href="/?page=manage_article"><i class="fa-solid fa-newspaper me-2"></i> จัดการบทความ</a></li>
            <?php endif; ?>
            <li><a class="dropdown-item" href="page/profile"><i class="fa-solid fa-user me-2"></i> ข้อมูลส่วนตัว</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><button class="dropdown-item text-danger" onclick="logout()"><i class="fa-solid fa-right-from-bracket me-2"></i> ออกจากระบบ</button></li>
          </ul>
        </li>
      </ul>

      <?php else: ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="btn btn-login hvr-icon-up" href="page/login"><i class="fa-solid fa-user-lock hvr-icon"></i> เข้าสู่ระบบ</a>
          <a class="btn btn-login hvr-icon-up" href="page/register"><i class="fa-solid fa-address-book hvr-icon"></i> สมัครสมาชิก</a>
        </li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>

<style>
  .navbar .dropdown-menu {
    right: 0;
    left: auto;
    transform-origin: top right;
    max-width: calc(100vw - 1rem);
    word-wrap: break-word;
  }
  @media (max-width: 576px){
    .navbar .dropdown-menu{ right:.5rem; }
  }
</style>