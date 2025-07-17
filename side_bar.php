
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="#" target="_blank">
      <img src="assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold">Menu</span>
    </a>
  </div>
  <hr class="horizontal dark mt-0">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <?php if($_SESSION["id"] != "" && !empty($_SESSION["id"])){ ?>
        <?php if($_SESSION["role"] == 1){ ?>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
              <span class="nav-link-text ms-1">หน้าหลัก</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_user.php' && $_GET['role'] == 1 ? 'active' : ''; ?>" href="manage_user.php?role=1">
              <span class="nav-link-text ms-1">ข้อมูลผู้ดูแลระบบ</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'manage_user.php' && $_GET['role'] == 2 ? 'active' : ''; ?>" href="manage_user.php?role=2">
              <span class="nav-link-text ms-1">ข้อมูลนักศึกษา</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_category.php' ? 'active' : ''; ?>" href="manage_category.php">
              <span class="nav-link-text ms-1">ข้อมูลประเภทวัสดุ</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_equipment.php' ? 'active' : ''; ?>" href="manage_equipment.php">
              <span class="nav-link-text ms-1">ข้อมูลวัสดุ</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'check_borrow.php' ? 'active' : ''; ?>" href="check_borrow.php">
              <span class="nav-link-text ms-1">ตรวจสอบคำขอ</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'all_history.php' ? 'active' : ''; ?>" href="all_history.php">
              <span class="nav-link-text ms-1">ประวัติการยืม-คืนทั้งหมด</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'statistic.php' ? 'active' : ''; ?>" href="statistic.php">
              <span class="nav-link-text ms-1">สถิติการยืมคืน</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'report_borrow.php' ? 'active' : ''; ?>" href="report_borrow.php">
              <span class="nav-link-text ms-1">รายงานการยืมคืน</span>
            </a>
          </li>
        <?php } ?>
        <?php if($_SESSION["role"] == 2){ ?>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
              <span class="nav-link-text ms-1">หน้าหลัก</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'manage_equipment.php' ? 'active' : ''; ?>" href="manage_equipment.php">
              <span class="nav-link-text ms-1">ข้อมูลวัสดุ</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'user_borrow.php' ? 'active' : ''; ?>" href="user_borrow.php">
              <span class="nav-link-text ms-1">ข้อมูลการยืม-คืน</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  <?php echo basename($_SERVER['PHP_SELF']) == 'user_history.php' ? 'active' : ''; ?>" href="user_history.php">
              <span class="nav-link-text ms-1">ประวัติการยืม-คืน</span>
            </a>
          </li>
          
        <?php } ?>
        

        
        

        <!--<li class="nav-item">
          <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>" href="profile.php">
            <span class="nav-link-text ms-1">ข้อมูลส่วนตัว</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link  " href="?logout=true">
            <span class="nav-link-text ms-1">ออกจากระบบ</span>
          </a>
        </li>-->
        
      <?php } ?>

    </ul>
  </div>

</aside>