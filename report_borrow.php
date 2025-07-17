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
<body class="g-sidenav-show  bg-gray-100">
  <?php
  require_once("side_bar.php");
  ?>
  <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
    <?php
    require_once("nav.php");
    ?>
    <div class="container-fluid py-4">


      <form name="prduct_detail_form" action="pdf_borrow.php" method="post" enctype="multipart/form-data" target="_blank">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">รายงานการยืม-คืน</h4>
              </div>

              <div class="card-body">
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">จากวันที่</label>
                      <input type="text" class="form-control" name="start_date" id="borrow_start" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ถึงวันที่</label>
                      <input type="text" class="form-control" name="end_date" id="borrow_end" required>
                    </div>
                  </div>
                </div>
                

                <div align="center">
                  <input type="submit" name="submit" class="btn btn-success btn-round" value="แสดงรายงาน">
                  <input type="button" name="button" class="btn btn-danger btn-round" onClick="javascript:history.go(-1)" value="ย้อนกลับ">

                </div>
                <div class="clearfix"></div>

              </div>
            </div>
          </div>
          
        </div>
      </form>

      <script>

        $('#borrow_start').datetimepicker({
          lang:'th',
          timepicker:false,
          format:'d/m/Y'
        });
        $('#borrow_end').datetimepicker({
          lang:'th',
          timepicker:false,
          format:'d/m/Y'
        });

      </script>

      <?php
      require_once("footer.php");
      ?>

    </div>
  </main>
  
</body>

</html>