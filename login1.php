<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

if (isset($_SESSION['bidang'])){
   echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:index1.php');
    exit();
}
if (!isset($_SESSION['right'])){
   echo "<script>alert('anda harus memilih dahulu apakah login sebagai user atau admin!'); </script>";
    echo "<script>location='pre_login.php'; </script>";
    header ('location:pre_login.php');
    exit();
}


 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="atk_admin/login2.css">
    <title>Login-Bidang</title>
  </head>
 <body>
 	<div class="container" >
 		<div class="row text-center ">
            <div class="col-md-12">
                <br />
                <h3 style="color: white; margin-top: 50px;"><img src="atk_admin/img1/logokab.png" width="42" height="50" class="d-inline-block align-top mr-2" style="" alt="" loading="lazy"> SIMPATIK - Sistem Informasi Manajemen Pengelolaan Alat Tulis Kantor</h3>
            </div>
        </div>
 	</div>




<div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header bg-transparent mb-0"><h5 class="text-center"> <span class="font-weight-bold text-primary">LOGIN</span></h5></div>
            <div class="card-body">
              <form role="form" method="post">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                    <input type="text" name="user" class="form-control" placeholder="Masukkan Username bidang">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text"><i class="fas fa-unlock-alt"></i></div>
                    </div>
                    <input type="password" name="pass" class="form-control" placeholder="Masukkan password bidang">
                  </div>
                </div>
                <div class="form-group custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" name="remember" id="customControlAutosizing">
                  <label class="custom-control-label" for="customControlAutosizing">Remember me</label>
                </div>
                <div class="form-group">
                  <input type="submit" name="login" value="login" class="btn btn-primary btn-block">
                </div>
                <!-- <hr> -->
               <!--  <p>lupa password atau username? Silahkan klik <a href="#">disini</a></p> -->
              </form>

               <?php 
                if (isset($_POST['login']))
                {
                  $ambil = $koneksi->query("SELECT * FROM t_bidang WHERE username='$_POST[user]' AND password='$_POST[pass]'");
                  $cari = $ambil->num_rows;
                  if ($cari==1)
                  {
                    $_SESSION['bidang']=$ambil->fetch_assoc();

                    //set cookie
                    
                    echo "<div class='alert alert-info'>Login sukses!</div>";
                    echo "<meta http-equiv='refresh' content='1;url=index1.php'>";
                  }
                  else
                  {
                     echo "<div class='alert alert-danger'>Login gagal!</div>";
                    echo "<meta http-equiv='refresh' content='1;url=login1.php'>";
                  }
                }


              ?>

            </div>
          </div>
        </div>
      </div>
    </div>








<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
  <script type="text/javascript" src="atk_admin/admin.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>



 </body>
 </html>

