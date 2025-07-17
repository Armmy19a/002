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
$allEquipments = getAllEquipments();
if (isset($_GET['canc'])) {
  cancelEquipments($_GET['canc']);
}
if (isset($_GET['norm'])) {
  normalEquipments($_GET['norm']);
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
              <h6>จัดการข้อมูลวัสดุ</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table style="width:100%">
                  <tr>
                    <td style="width: 60%;"></td>
                    <td style="width: 40%;">
                      <input type="text" name="search" id="search" class="form-control border-input" onKeyup="filterSearch();" placeholder="ค้นหา">
                    </td>
                  </tr>
                </table>
                <br/>
                <?php if($_SESSION["id"] == 1){ ?>
                  <a href="edit_equipment.php" class="btn btn-outline-success" style="float: right;">เพิ่มวัสดุ</a>
                <?php } ?>
                <table class="table align-items-center justify-content-center mb-0" id="data_table">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">เลขวัสดุ</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ชื่อรายการ</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ประเภท</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">จำนวน</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ปีงบประมาณ</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">สถานะ</th>
                      <?php if($_SESSION["id"] == 1){ ?>
                        <th></th>
                      <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if(empty($allEquipments)){ ?>
                    <?php }else{?>
                      <?php foreach($allEquipments as $data){ ?>
                        <tr>
                          <td>
                            <?php if($data['equ_img'] == ""){ ?>
                              <img class="img-fluid shadow border-radius-xl" src="images/equ_ico.png" />
                            <?php }else{ ?>
                              <img class="img-fluid shadow border-radius-xl" src="images/equipment/<?php echo $data['equ_img'];?>" style="width:100px;height:100px;"/>
                            <?php } ?>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["equ_number"];?></span>
                          </td>
                          <td>
                            <div class="d-flex px-2">
                              <div class="my-auto">
                                <h6 class="mb-0 text-sm"><?php echo $data["equ_name"];?></h6>
                              </div>
                            </div>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["cate_name"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["equ_quantity"];?> <?php echo $data["units"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $data["fisd_years"];?></span>
                          </td>
                          <td>
                            <span class="text-xs font-weight-bold"><?php echo $equ_status_map[$data["equ_status"]];?></span>
                          </td>
                          <?php if($_SESSION["id"] == 1){ ?>
                            <td style="text-align: right;">
                              <a href="edit_equipment.php?equipments_id=<?php echo $data["equipments_id"];?>" class="btn btn-outline-info">แก้ไข</a>
                              <?php if($data["equ_status"] == 1){ ?>
                                <a href="?canc=<?php echo $data['equipments_id'];?>" class="btn btn-outline-danger" onClick="javascript: return confirm('ยืนยันการปรับสถานะ');">ระงับ</a>
                              <?php }else{ ?>
                                <a href="?norm=<?php echo $data['equipments_id'];?>" class="btn btn-outline-success" onClick="javascript: return confirm('ยืนยันการปรับสถานะ');">ปกติ</a>
                              <?php } ?>
                            </td>
                          <?php } ?>
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
          input = document.getElementById("search");
          filter = input.value.toUpperCase();
          table = document.getElementById("data_table");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
            td1 = tr[i].getElementsByTagName("td")[1];
            td2 = tr[i].getElementsByTagName("td")[2];
            td5 = tr[i].getElementsByTagName("td")[5];
            if (td1 || td2 || td5) {
              if (td1.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1 || td5.innerHTML.toUpperCase().indexOf(filter) > -1) {
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