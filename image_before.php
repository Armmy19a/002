<!DOCTYPE html>
<html lang="en">
<?php
require_once("header.php");
?>
<?php
$allImageBorrow = getAllImageBorrow($_GET["borrows_id"]);


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

      <div class="row mt-4">
        <?php if(empty($allImageBorrow)){ ?>
          <label>ไม่พบข้อมูล</label>
        <?php }else{?>
          <?php foreach($allImageBorrow as $data){ ?>
            <div class="col-lg-3 col-sm-6" style="margin-top:10px;">
              <div class="card">
                <img class="img-fluid " src="images/borrow_gallery/<?php echo $data["borrow_images"];?>" />
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
      <?php
      require_once("footer.php");
      ?>
    </div>
  </main>


</body>

</html>