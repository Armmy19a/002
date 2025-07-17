<!DOCTYPE html>
<html lang="en">
<?php
require_once("header.php");
?>
<?php 
$currentBorrows = getCurrentBorrows($_GET["borrows_id"]);
$allBorrowsEquipments = getAllBorrowsEquipments($_GET["borrows_id"]);

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
      <form name="prduct_detail_form" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="borrows_id" value="<?php echo $currentBorrows["borrows_id"];?>">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">ข้อมูลผู้ยืม-คืน</h4>
              </div>

              <div class="card-body">

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">ชื่อ-นามสกุล</label>
                    </div>
                  </div>

                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo $currentBorrows["firstname"];?> <?php echo $currentBorrows["lastname"];?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">สังกัด</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo $currentBorrows["program"];?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่ขอยืม</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo formatDateFull($currentBorrows["borrow_date"]);?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่คืน</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo formatDateFull($currentBorrows["due_date"]);?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">เวลาเริ่มต้น</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo substr($currentBorrows["start_time"], 0,5);?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">เวลาสิ้นสุด</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo substr($currentBorrows["end_time"], 0,5);?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">วัตถุประสงค์</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label class="bmd-label-floating"><?php echo $currentBorrows["details"];?></label>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">รูปวัสดุตอนยืม</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <a href="image_before.php?borrows_id=<?php echo $currentBorrows["borrows_id"];?>" >กดที่นี่เพื่อดูหลักฐาน</a>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label class="bmd-label-floating">รูปวัสดุตอนคืน</label>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <a href="image_after.php?borrows_id=<?php echo $currentBorrows["borrows_id"];?>" >กดที่นี่เพื่อดูหลักฐาน</a>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-profile">
              <img class="img-fluid shadow border-radius-xl" src="images/cus_ico.png" />
            </div>
          </div>
        </div>
        <div class="row" style="margin-top: 25px;">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">รายละเอียดวัสดุ</h4>
              </div>
              <div class="card-body">
                <table class="table " id="dataTable">
                  <thead>
                    <th style="text-align:left;"><label>ชื่อวัสดุ</label></th>
                    <th style="text-align:center;"><label>ประเภท</label></th>
                    <th style="text-align:center;"><label>จำนวน</label></th>
                  </thead>
                  <tbody>
                    <?php if(empty($allBorrowsEquipments)){ ?>
                    <?php }else{?>
                      <?php foreach($allBorrowsEquipments as $data){ ?>

                        <tr>
                          <td style="width:50%;text-align:left;">
                            <label class="bmd-label-floating"><?php echo $data["equ_name"];?></label>
                          </td>
                          <td style="width:30%;text-align:center;">
                            <label class="bmd-label-floating"><?php echo $data["cate_name"];?></label>
                          </td>
                          <td style="width:20%;text-align:center;">
                            <label class="bmd-label-floating"><?php echo $data["amount"];?> <?php echo $data["units"];?></label>
                          </td>

                        </tr>

                      <?php } ?>
                    <?php } ?>

                  </tbody>
                </table>

                <div align="center">
                  
                  <input type="button" name="button" class="btn btn-danger btn-round" onClick="javascript:history.go(-1)" value="ย้อนกลับ">

                </div>
              </div>
            </div>
          </div>

        </div>

      </form>
      <?php
      require_once("footer.php");
      ?>
      <script>
        var today = new Date();

        $('#work_start_date').datetimepicker({
          lang:'th',
          minDate:today,
          timepicker:false,
          format:'d/m/Y'
        });
        $('#work_start_time').datetimepicker({
          lang:'th',
          datepicker:false,
          format:'H:i',
          enabledHours: '10'

        });
      </script>
    </div>
  </main>


</body>

</html>