<?php 
session_start();
//koneksi ke database
include 'koneksi.php';


if (!isset($_SESSION['bidang']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login1.php'; </script>";
    header ('location:login1.php');
    exit();
}

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;


$id_bidang = $_SESSION['bidang']['id_bidang'];
$ambil = mysqli_query($koneksi,"SELECT*FROM t_permintaan WHERE id_bidang = '$id_bidang'");
$totalpermin  = mysqli_num_rows($ambil);//jumlah data
$status ="Selesai";
$ambil2 = mysqli_query($koneksi,"SELECT*FROM t_permintaan WHERE id_bidang = '$id_bidang' && status = '$status'");
$permin  = mysqli_num_rows($ambil2);//jumlah data

$ambil3 = mysqli_query($koneksi,"SELECT*FROM t_permintaan WHERE id_bidang = '$id_bidang' ORDER BY id_permintaan DESC LIMIT $start, $perpage");

 ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets2/css/bootstrap.min.css">
   
    <link rel="stylesheet" type="text/css" href="assets/fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="users3.css">
     <link rel="stylesheet" type="text/css" href="assets/Hover-master/css/hover.css">
  
    <title>Home</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<header>


 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container">
      <a class="navbar-brand" href="index1.php"><img src="atk_admin/img1/logo_kab_serang.png" width="35" height="35" class="d-inline-block align-top" alt="" loading="lazy"> <b>SIMPATIK</b> </a>

       <div class="collapse navbar-collapse" id="navbarNav">

          <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION["bidang"])): ?>
            <?php $id_bidang = $_SESSION["bidang"]['id_bidang']; ?>
            <?php $ambil = $koneksi->query("SELECT * FROM t_bidang WHERE id_bidang='$id_bidang' "); ?>
            <?php $pecah = $ambil->fetch_assoc(); ?>
             <li class="nav-item active">
              <a class="nav-link" href="#"><i class="fas fa-users mr-2"></i> <?php echo $pecah['nama_bidang'] ?></a>
            </li>
           
            <?php endif ?>  
          </ul>

       </div>
      
      
        <div class="icon ml-4">
          <h5>
            <!-- <i class="fas fa-envelope mr-3" data-toggle="tooltip" title="Pesan Masuk"></i>
            <i class="fas fa-bell mr-3" data-toggle="tooltip" title="Notifikasi"></i> -->
            <a href="logout1.php"><i onclick = "return confirm('apakah anda yakin ingin logout?');" class="fas fa-sign-out-alt mr-3 mt-2" data-toggle="tooltip" title="Logout"></i></a>
            
          </h5>
        </div>
      </div>
</nav>
<div class="navy">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <div class="container">
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item mr-3">
          <a class="nav-link" href="index1.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="permintaan.php"><i class="fas fa-exchange-alt"></i> Permintaan</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="riwayat_permintaan.php" tabindex="-1" aria-disabled="true"><i class="fas fa-history"></i> Riwayat</a>
        </li>
      </ul>
    </div>
    </div>
    </nav>
    </div>

</header>


  <div class="container">
    <div class="row">
      <div class="col-sm-6 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body hvr-icon-back hvr-glow">
            <h4 class="card-title">Jumlah Permintaan</h4>
            <div class="card-body-icon">
              <i class="fas fa-exchange-alt mr-2 hvr-icon"></i>
            </div>
            <div class="display-4"><?php echo $totalpermin; ?></div>
            <a href="riwayat_permintaan.php"><p class="card-text" style="color: black;">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p></a>
          </div>
        </div>
      </div>
       <div class="col-sm-6 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body hvr-icon-back hvr-glow">
            <h4 class="card-title">Permintaan terpenuhi</h4>
            <div class="card-body-icon">
              <i class="fas fa-clipboard-list mr-2 hvr-icon"></i>
            </div>
            <div class="display-4"><?php echo $permin; ?></div>
            <a href="riwayat_permintaan.php"><p class="card-text" style="color: black;">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p></a>
          </div>
        </div>
      </div>

</div>







   <!--  -->
 
 <div class="row">
      <div class="col-sm-12 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body hvr-glow">
            <h4 class="card-title mb-4">Permintaan Terbaru</h4>
            <!-- <p class="card-text">Total Permintaan</p> -->
            <table class="table">
      <thead>
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Divisi</th>
          <th>Detail</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php $nomor = 1; ?>
       <?php  while($perm = $ambil3->fetch_assoc()){?>
        <?php 
        $tanggal  = $perm["tanggal_permintaan"];
        $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
        $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        $hari = date('l, j F Y', strtotime($tanggal));
        $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
        
        $id = $perm["id_bidang"];  
        $set = $koneksi->query("SELECT*FROM t_bidang WHERE id_bidang = '$id'");
        $row = $set->fetch_assoc();
        $nama_bidang=$row["nama_bidang"]
        ?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $day; ?></td>
          <td><?php echo  $nama_bidang; ?></td>
          <td>
           <a class="ml-5" href="detailpermintaan2.php?id=<?php echo $perm["id_permintaan"];?>"><i class="fas fa-search" data-toggle="tooltip" title="detail permintaan"></i></a>
          </td>
         <?php $status = $perm['status'] ?>
          <?php if($status == "Disetujui"): ?>
            <?php  if(isset($_SESSION['admin'])):?>
            <td><a href="#" class="badge badge-warning">Dalam Proses</a></td>
            <?php else: ?>
            <td><a href="#" class="badge badge-success"><?php echo $perm['status']; ?></a></td>
          <?php endif ?>
            <?php elseif ($status =="Selesai"):?>
              <td><a href="#" class="badge badge-light"><?php echo $perm['status']; ?></a></td>
            <?php else: ?>
              <td><a href="#" class="badge badge-danger"><?php echo $perm['status']; ?></a></td>
            <?php endif; ?>
        </tr>
        <?php $nomor ++; ?>
      <?php }; ?>

      </tbody>
    </table>
 
  </div>
          </div>
        </div>
      </div>
  </div>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
   <script type="text/javascript" src="admin.js"></script>
      <script type="text/javascript" src="assets2/js/jquery-3.5.1.slim.min.js"></script>
   <script type="text/javascript" src="assets2/js/popper.min.js"></script>
   <script type="text/javascript" src="assets2/js/bootstrap.min.js"></script>

<script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>


  </body>
</html>