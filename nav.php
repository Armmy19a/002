<?php 
$user = getUser($_SESSION["id"]);
if($user["actives"] == 1){
  logout();
}
if (isset($_GET['logout'])) {
  logout();
}
?>
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
  <div class="container-fluid py-1 px-3">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">ระบบจัดการยืม-คืนวัสดุ</li>
      </ol>
      <h6 class="font-weight-bolder mb-0">Durable System</h6>
    </nav>
    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
      </div>
      <ul class="navbar-nav  justify-content-end">
    <!--<li class="nav-item d-flex align-items-center">
      <a class="btn btn-outline-primary btn-sm mb-0 me-3" target="_blank" href="create_board.php">สร้างกระทู้</a>
    </li>-->
    <li class="nav-item d-flex align-items-center">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="dropdown">

          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
            <?php echo $user["firstname"];?> <?php echo $user["lastname"];?>
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="profile.php">ข้อมูลส่วนตัว</a></li>
            <li><a class="dropdown-item" href="?logout=true">ออกจากระบบ</a></li>
          </ul>
        </div>
      </div>
    </li>

  </ul>

</div>

</div>
</nav>