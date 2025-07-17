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

$numberEquipments = runNumberEquipments();
$currentEquipments = getCurrentEquipments($_GET["equipments_id"]);
$allCategory = getAllCategory();
$yThai = date("Y")+543;
$dateSet = $yThai.date("-09-30");
$date_now = $yThai.date("-m-d");
if ($date_now > $dateSet) {
    $yThai = $yThai + 1;
}else{
    $yThai = $yThai;
}
if(isset($_POST["equipments_id"])){
  if($_POST["equipments_id"] == ""){
    saveEquipments($_POST["categories_id"],$_POST["equ_number"],$_POST["equ_name"],$_POST["equ_detail"],$_POST["equ_quantity"],$_POST["units"],$_POST["fisd_years"],$_FILES["equ_img"]["name"],$_POST["equ_status"]);
  }else{
    editEquipments($_POST["equipments_id"],$_POST["categories_id"],$_POST["equ_number"],$_POST["equ_name"],$_POST["equ_detail"],$_POST["equ_quantity"],$_POST["units"],$_POST["fisd_years"],$_FILES["equ_img"]["name"],$_POST["equ_status"]);
  }
}

if($_GET["equipments_id"] == ""){
  $txtHead = "เพิ่ม วัสดุ";
}else{
  $txtHead = "แก้ไข วัสดุ";
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
      <form name="prduct_detail_form" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="equipments_id" value="<?php echo $currentEquipments["equipments_id"];?>">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"><?php echo $txtHead;?></h4>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ประเภท</label>
                      <select name="categories_id" class="form-control border-input" id="categories_id" required>
                        <option value="">-- โปรดเลือกประเภท --</option>
                        <?php foreach($allCategory as $dataCate){ ?>
                          <?php $selected = ""; 
                          if($currentEquipments['categories_id'] == $dataCate['categories_id']){
                            $selected = " selected"; 

                          } 
                          ?> 
                          <option value="<?php echo $dataCate['categories_id']?>" <?php echo $selected;?>><?php echo $dataCate['cate_name']?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">เลขวัสดุ</label>
                      <input type="text" class="form-control" name="equ_number" value="<?php if($_GET['id'] == ""){ echo $numberEquipments;}else{ echo $currentEquipments["equ_number"]; }?>" readonly>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">ชื่อรายการ</label>
                      <input type="text" class="form-control" name="equ_name" value="<?php echo $currentEquipments["equ_name"];?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">รายละเอียด</label>
                      <input type="text" class="form-control" name="equ_detail" value="<?php echo $currentEquipments["equ_detail"];?>" required>
                    </div>
                  </div>
                </div>
                <div class="row" id="ma">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">จำนวน <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="equ_quantity" value="<?php echo $currentEquipments["equ_quantity"];?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">หน่วยนับ</label>
                      <input type="text" class="form-control" name="units" value="<?php echo $currentEquipments["units"];?>" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ปีงบประมาณ </label>
                      <input type="text" class="form-control" name="fisd_years" value="<?php if($_GET['id'] == ""){echo $yThai;}else{ echo $currentEquipments["fisd_years"];}?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">รูปภาพ <span style="color:red">*</span></label>
                      <input type="file" class="form-control" name="equ_img" >
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">สถานะ</label>
                      <input type="radio" name="equ_status" id="equ_status" value="1" <?php if($currentEquipments["equ_status"]==1 || $currentEquipments["equ_status"]==""){ ?>checked<?php } ?>> ปกติ &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="equ_status" id="equ_status" value="2" <?php if($currentEquipments["equ_status"]==2 ){ ?>checked<?php } ?>> ระงับ
                    </div>
                  </div>
                </div>
                <div align="center">
                  <input type="submit" name="submit" class="btn btn-success btn-round" value="บันทึก">
                  <input type="button" name="button" class="btn btn-danger btn-round" onClick="javascript:history.go(-1)" value="ย้อนกลับ">

                </div>
                <div class="clearfix"></div>

              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-profile">
              <?php if($currentEquipments['equ_img'] == ""){ ?>
                <img class="img-fluid shadow border-radius-xl" src="images/equ_ico.png" />
              <?php }else{ ?>
                <img class="img-fluid shadow border-radius-xl" src="images/equipment/<?php echo $currentEquipments['equ_img'];?>" />
              <?php } ?>
            </div>
          </div>
        </div>

      </form>
      <?php
      require_once("footer.php");
      ?>
    </div>
  </main>


</body>

</html>