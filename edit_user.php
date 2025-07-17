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
$currentUsers = getCurrentUsers($_GET["users_id"]);
if(isset($_POST["submit"])){
  if($_POST["users_id"] == ""){
    saveUsers($_POST["user_number"],$_POST["firstname"],$_POST["lastname"],$_POST["telephone"],$_POST["email"],$_POST["program"],$_POST["username"],$_POST["password"],$_POST["role"]);
  }else{
    editUsers($_POST["users_id"],$_POST["user_number"],$_POST["firstname"],$_POST["lastname"],$_POST["telephone"],$_POST["email"],$_POST["program"],$_POST["username"],$_POST["password"],$_POST["role"]);
  }
}

if($_GET["users_id"] == ""){
  $txtHead = "เพิ่ม ผู้ใช้งาน";
}else{
  $txtHead = "แก้ไข ผู้ใช้งาน";
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
        <input type="hidden" class="form-control" name="users_id" value="<?php echo $currentUsers["users_id"];?>">
        <div class="row">
          <div class="col-md-8">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"><?php echo $txtHead;?></h4>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">รหัสนักศึกษา/รหัสอาจารย์ <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="user_number" value="<?php echo $currentUsers["user_number"];?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ชื่อ <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="firstname" value="<?php echo $currentUsers["firstname"];?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">นามสกุล <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="lastname" value="<?php echo $currentUsers["lastname"];?>" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">หมายเลขโทรศัพท์ <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="telephone" value="<?php echo $currentUsers["telephone"];?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">อีเมล</label>
                      <input type="text" class="form-control" name="email" value="<?php echo $currentUsers["email"];?>">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="bmd-label-floating">สังกัด <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="program" value="<?php echo $currentUsers["program"];?>" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ชื่อผู้ใช้งาน <span style="color:red">*</span></label>
                      <input type="text" class="form-control" name="username" value="<?php echo $currentUsers["username"];?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">รหัสผ่าน <span style="color:red">*</span></label>
                      <input type="password" class="form-control" name="password" value="<?php echo $currentUsers["password"];?>" required>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="bmd-label-floating">ประเภทผู้ใช้งาน</label>
                      <input type="radio" name="role" id="role" value="1" <?php if($currentUsers["role"]==1 || $currentUsers["role"]==""){ ?>checked<?php } ?>> ผู้ดูแลระบบ &nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="role" id="role" value="2" <?php if($currentUsers["role"]==2 ){ ?>checked<?php } ?>> ผู้ยืม
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
              <img class="img-fluid shadow border-radius-xl" src="images/user_ico.png" />
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