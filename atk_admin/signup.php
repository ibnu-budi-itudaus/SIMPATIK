<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="signup.css">
    <title>Signup-Admin</title>
  </head>
 <body>
 	<div class="container" >
 		<div class="row text-center ">
            <div class="col-md-12">
                <br />
                <h2 style="color: white;"><img src="img1/logokab.png" width="38" height="40" class="d-inline-block align-top" alt="" loading="lazy"> SIMPATIK : Sign-Up</h2>
                <h5> Masukkan data diri anda pada form admin sign-up, untuk terdaftar sebagai admin </h5>
            </div>
        </div>
 	</div>

<div class="container">
<div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <div class="card">
            <div class="card-header bg-transparent mb-0"><h5 class="text-center">Admin <span class="font-weight-bold text-primary">SIGN-UP</span></h5></div>
            <div class="card-body">
              <form role="form" method="post">
                 <div class="form-group">
                   <label>Nama</label>
                   <input type="text" class="form-control" name="nama" placeholder="Masukkan nama anda" required>
                 </div>
                 <div class="form-group">
                   <label>Email</label>
                   <input type="email" class="form-control" name="email" placeholder="Masukkan email anda">
                   <p style="font-color : red;">*Jika tidak punya email boleh dikosongkan</p>
                 </div>
                 <div class="form-group">
                   <label>Username</label>
                   <input type="text" class="form-control" name="user" placeholder="Masukkan username anda" required>
                 </div>
                 <div class="form-group">
                   <label>Password</label>
                   <input type="password" class="form-control" name="pass" placeholder="Masukkan password anda" required>
                 </div>
                 <div class="form-group">
                   <label>Telp/no.HP</label>
                  <input type="number" class="form-control" name="telepon" placeholder="Masukkan Telp/no.HP anda" required>
                 </div>
                <div class="form-group">
                  <input type="submit" name="signup" value="Signup" class="btn btn-primary btn-block">
                </div>
              </form>

               <?php 
              //jk ada tombol daftar (lalu diclick)
              if (isset($_POST["signup"]))
              {
                //mengambil isi form daftar
                $nama = $_POST["nama"];
                $email = $_POST["email"];
                $user = $_POST["user"];
                $password = $_POST["pass"];
                $telepon = $_POST["telepon"];

                //cek apakah email sudah digunakan
                $ambil = $koneksi->query("SELECT * FROM t_admin WHERE username ='$user'");
                $yangcocok = $ambil->num_rows;
                if ($yangcocok==1)
                {
                  echo "<script>alert('Pendaftaran gagal, username telah digunakan ');</script>";
                  echo "<script>location='signup.php';</script>";
                }
                else
                {
                  //query insert ke tabel pelanggan
                  $koneksi->query("INSERT INTO t_admin (username,pass,nama_admin,email,telp) 
                    VALUES ('$user','$password','$nama','$email','$telepon')");
                  echo "<script>alert('Pendaftaran sukses! silahkan login ');</script>";
                  echo "<script>location='login.php';</script>";
                }

              }


               ?>


            </div>
          </div>
      </div>

 <div class="col-sm-2"></div>
      </div>
    </div>







<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
  <script type="text/javascript" src="admin.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>



 </body>
 </html>

