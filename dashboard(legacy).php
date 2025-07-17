<!DOCTYPE html>
<html lang="en">

<?php
require_once("header.php");

?>
<?php 
$monthNow = date("m");
$numMonth = (int)$monthNow;

$dataPoints = getAllDashboardChart($numMonth);
$allDataDashboardChart = getAllDataDashboardChart($numMonth);
?>
<script>
window.onload = function () {

var chart2 = new CanvasJS.Chart("chartContainer2", {
  animationEnabled: true,
  title: {
    text: ""
  },
  data: [{
    type: "pie",
    startAngle: 240,
    yValueFormatString: "##0\"\"",
    indexLabel: "{label} {y}",
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
              <h6>ข้อมูลการยืมคืน เดือน <?php echo $month_map[$numMonth];?></h6>
            </div>
            <div class="card-body p-3">
              <table class="table " id="dataTable">
                <thead>
                  <th style="text-align:left;"><label>วัสดุ</label></th>
                  <th style="text-align:center;"><label>จำนวน</label></th>
                </thead>
                <tbody>
                  <?php if(empty($allDataDashboardChart)){ ?>
                  <?php }else{?>
                    <?php foreach($allDataDashboardChart as $data){ ?>
                      <tr>
                        <td style="text-align:left;">
                          <label class="bmd-label-floating"><?php echo $data["equ_name"];?></label>
                        </td>
                        <td style="text-align:center;">
                          <label class="bmd-label-floating"><?php echo $data["sumAmount"];?> <?php echo $data["meas_name"];?></label>
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
              <h6>สถิติการยืมคืน เดือน <?php echo $month_map[$numMonth];?></h6>
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
    </div>
  </main>


</body>

</html>