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
  if($_SESSION["role"] != 2 ){
    echo '<script>window.history.go(-1)</script>';  
  }
}
?>
<?php
$allBorrowsByUserId = getAllBorrowsByUserId($_SESSION["id"]);
if (isset($_GET['delete'])) {
  deleteBorrows($_GET['delete']);
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
              <h6>ข้อมูลการยืม-คืน</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <a href="booking_equipment.php" class="btn btn-outline-success" style="float: right;">จองวัสดุ</a>
                <table class="table align-items-center justify-content-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ชื่อ-นามสกุล</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">วันที่-เวลา ยืม</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">วันที่-เวลา คืน</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">วัตถุประสงค์</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">สถานะ</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($allBorrowsByUserId)){ ?>
                    <?php }else{?>
                      <?php foreach($allBorrowsByUserId as $data){ ?>
                        <tr>
                          <td>
                            <div class="d-flex px-2">
                              <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?php echo $data["firstname"];?> <?php echo $data["lastname"];?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo formatDateFull($data["borrow_date"]);?> - <?php echo substr($data["start_time"],0,5);?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo formatDateFull($data["due_date"]);?> - <?php echo substr($data["end_time"],0,5);?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["details"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $borrow_map[$data["status"]];?></span>
                          </td>
                          <td style="text-align: right;">
                            <?php if($data["status"] == 1){ ?>
                              <a href="booking_equipment.php?borrows_id=<?php echo $data["borrows_id"];?>" class="btn btn-outline-info">แก้ไข</a>
                              <a href="?delete=<?php echo $data['borrows_id'];?>" class="btn btn-outline-danger" onClick="javascript: return confirm('ยืนยันการลบ');">ลบ</a>
                            <?php } ?>
                            
                            <a href="detail_borrow.php?borrows_id=<?php echo $data["borrows_id"];?>" class="btn btn-outline-info">รายละเอียด</a>
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