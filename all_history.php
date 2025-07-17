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
$allHistoryBorrows = getAllHistoryBorrows();

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
              <h6>ประวัติการยืม-คืนทั้งหมด</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
              <table style="width:100%">
                  <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%;">
                      <select name="search" class="form-control border-input" id="search" onChange="filterSearch();">
                        <option value="">ทั้งหมด</option>
                        <option value="1">รออนุมัติ</option>
                        <option value="2">อนุมัติ</option>
                        <option value="3">ไม่อนุมัติ</option>
                        <option value="4">เรียบร้อย</option>
                      </select>
                    </td>
                  </tr>
                </table>
                <table class="table align-items-center justify-content-center mb-0" id="data_table">
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
                    <?php if(empty($allHistoryBorrows)){ ?>
                    <?php }else{?>
                      <?php foreach($allHistoryBorrows as $data){ ?>
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
                            <span class="text-xs font-weight-bold"><?php echo $borrow_map[$data["status"]];?></span><span class="text-xs font-weight-bold" style="display:none;"><?php echo $data["status"];?></span>
                          </td>
                          <td style="text-align: right;">
                            <a href="history_detail.php?borrows_id=<?php echo $data["borrows_id"];?>" class="btn btn-outline-info">รายละเอียด</a>
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
      <script>
        function filterSearch() {
          var input, filter, table, tr, td, i;
          //input = evt;
          input = document.getElementById("search");
          filter = input.value.toUpperCase();
          table = document.getElementById("data_table");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[4];
            if (td1 ) {
              if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 ) {
                tr[i].style.display = "";
              } else {
                tr[i].style.display = "none";
              }
            }
          }
        }
      </script>
    </div>
  </main>


</body>

</html>