<!DOCTYPE html>
<html lang="en">
<?php
require_once("header.php");
?>
<?php
if($_SESSION["id"] == "" && empty($_SESSION["id"])){
  echo ("<script language='JavaScript'>
      window.location.href='index.php';
      </script>");
}else{
  if($_SESSION["role"] != 1 ){
    echo '<script>window.history.go(-1)</script>';  
  }
}
?>
<?php
$allUsersByStatus = getAllUsersByStatus($_GET["role"]);
if (isset($_GET['delete'])) {
  blockUsers($_GET['delete'],$_GET['role']);
}
if (isset($_GET['unblock'])) {
  unBlockUsers($_GET['unblock'],$_GET['role']);
}


if($_GET["role"] == 1){
  $txtHead = "จัดการข้อมูลผู้ดูแลระบบ";
}else{
  $txtHead = "จัดการข้อมูลนักศึกษา";
}
?>
<body class="g-sidenav-show  bg-gray-100">
  <?php
  require_once("side_bar.php");
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <?php
    require_once("nav.php");
    ?>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6><?php echo $txtHead;?></h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <a href="edit_user.php" class="btn btn-outline-success" style="float: right;">เพิ่มผู้ใช้งาน</a>
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">รหัส</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ชื่อผู้ใช้งาน</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ชื่อ-นามสกุล</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">โทรศัพท์</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">อีเมล</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">สังกัด</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">การใช้งาน</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($allUsersByStatus)){ ?>
                    <?php }else{?>
                      <?php foreach($allUsersByStatus as $data){ ?>
                        <tr>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["user_number"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["username"];?></span>
                          </td>
                          <td>
                            <div class="d-flex px-2">
                              <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?php echo $data["firstname"];?> <?php echo $data["lastname"];?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["telephone"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["email"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["program"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $actives_map[$data["actives"]];?></span>
                          </td>
                          <td style="text-align: right;">
                            <a href="edit_user.php?users_id=<?php echo $data["users_id"];?>" class="btn btn-outline-info">แก้ไข</a>
                            <?php if($data["actives"] == 0){ ?>
                              <a href="?delete=<?php echo $data['users_id'];?>&role=<?php echo $_GET['role'];?>" class="btn btn-outline-danger" onClick="javascript: return confirm('ยืนยันการระงับ');">ระงับ</a>
                            <?php }else{ ?>
                              <a href="?unblock=<?php echo $data['users_id'];?>&role=<?php echo $_GET['role'];?>" class="btn btn-outline-success" onClick="javascript: return confirm('ยืนยันการอนุญาตให้ใช้งาน');">ปกติ</a>
                            <?php } ?>
                            
                          </td>
                        </tr>
                      <?php } ?>
                    <?php } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      require_once("footer.php");
      ?>
    </div>
  </main>


</body>

</html>