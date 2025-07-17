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
}
?>
<?php 
$yThai = date("Y")+543;
$dateNow = date("d/m/").$yThai;
$dataPoints = getAllStatisticChart($dateNow,$dateNow);
$allDataStatisticChart = getAllDataStatisticChart($dateNow,$dateNow);

if(isset($_POST["search"])){
  $dataPoints = getAllStatisticChart($_POST["start_date"],$_POST["end_date"]);
  $allDataStatisticChart = getAllDataStatisticChart($_POST["start_date"],$_POST["end_date"]);
}

?>
<script>
  window.onload = function () {

    var chart2 = new CanvasJS.Chart("chartContainer2", {
      animationEnabled: true,
      title: {
        text: ""
      },
      data: [{
        type: "column",
        startAngle: 240,
        yValueFormatString: "##0\"\"",
        indexLabel: "{y}",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart2.render();
  }
</script>
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

      <div class="row mt-4">

        <div class="col-lg-7">
          <div class="card z-index-2">
            <div class="card-header pb-0">
              <h6>สถิติการยืม-คืน</h6>
            </div>
            <div class="card-body p-3">
              <form name="prduct_detail_form" action="" method="post" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่เริ่มต้น</label>
                      <input type="text" class="form-control" name="start_date" id="start_date" >
                    </div>
                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                      <label class="bmd-label-floating">วันที่สิ้นสุด</label>
                      <input type="text" class="form-control" name="end_date" id="end_date" >
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="bmd-label-floating"></label><br/>
                      <input type="submit" name="search" class="btn btn-success btn-round" value="แสดงข้อมูล">
                    </div>
                  </div>
                </div>
              </form>
              <table class="table " id="dataTable">
                <thead>
                  <th style="text-align:left;"><label>วัสดุ</label></th>
                  <th style="text-align:center;"><label>จำนวน</label></th>
                </thead>
                <tbody>
                  <?php if(empty($allDataStatisticChart)){ ?>
                  <?php }else{?>
                    <?php foreach($allDataStatisticChart as $data){ ?>
                      <tr>
                        <td style="text-align:left;">
                          <label class="bmd-label-floating"><?php echo $data["equ_name"];?></label>
                        </td>
                        <td style="text-align:center;">
                          <label class="bmd-label-floating"><?php echo $data["sumAmount"];?> <?php echo $data["units"];?></label>
                        </td>
                      </tr>

                    <?php } ?>
                  <?php } ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card z-index-2">
            <div class="card-header pb-0">
              <h6>สถิติ</h6>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <div id="chartContainer2" style="height: 300px; width: auto;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <?php
      require_once("footer.php");
      ?>

      <script>

        $('#start_date').datetimepicker({
          lang:'th',
          timepicker:false,
          format:'d/m/Y'
        });

        $('#end_date').datetimepicker({
          lang:'th',
          timepicker:false,
          format:'d/m/Y'
        });
        
      </script>
    </div>
  </main>


</body>

</html>