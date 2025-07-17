<!DOCTYPE html>
<html lang="en">

<?php
require_once("header.php");
?>
<?php 
if(isset($_POST["register"])){
  saveRegister($_POST["user_number"],$_POST["firstname"],$_POST["lastname"],$_POST["telephone"],$_POST["email"],$_POST["program"],$_POST["username"],$_POST["password"]);
}
?>
<body class="" style="margin-top: -25px;">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 " href="pages/dashboard.html">
              ระบบจัดการยืม-คืนวัสดุ
            </a>
            <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon mt-2">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </span>
            </button>
            
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome </h3>
                  <p class="mb-0">Enter your username and password to sign in</p>
                </div>
                <div class="card-body">
                  <form role="form" action="" method="post">
                    <label>Username</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="username" placeholder="ชื่อผู้ใช้งาน" required>
                    </div>
                    <label>Password</label>
                    <div class="mb-3">
                      <input type="password" class="form-control" name="password" placeholder="รหัสผ่าน" required>
                    </div>
                    <label>รหัสนักศึกษา/รหัสอาจารย์</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="user_number" placeholder="รหัสนักศึกษา/รหัสอาจารย์" required>
                    </div>
                    <label>ชื่อ</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="firstname" placeholder="ชื่อ" required>
                    </div>
                    <label>นามสกุล</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="lastname" placeholder="นามสกุล" required>
                    </div>
                    <label>โทรศัพท์</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="telephone" placeholder="โทรศัพท์" required>
                    </div>
                    <label>อีเมล</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="email" placeholder="อีเมล" required>
                    </div>
                    <label>สังกัด</label>
                    <div class="mb-3">
                      <input type="text" class="form-control" name="program" placeholder="สังกัด" required>
                    </div>
                    <div class="text-center">
                      <input type="submit" name="register" value="ลงทะเบียน" class="btn bg-gradient-info w-100 mt-4 mb-0">
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        
      </div>
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> ระบบจัดการยืม-คืนวัสดุ
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
</body>

</html>