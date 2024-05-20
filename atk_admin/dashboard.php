<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$ambil = mysqli_query($koneksi,"SELECT*FROM t_barang_atk");
$totalatk  = mysqli_num_rows($ambil);//jumlah data

$take =  mysqli_query($koneksi,"SELECT*FROM t_permintaan");
$totalpermin = mysqli_num_rows($take);

$taken =  mysqli_query($koneksi,"SELECT*FROM t_bidang");
$totaldiv = mysqli_num_rows($taken);

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

$permint = array();
$reach = $koneksi->query("SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang ORDER BY t_permintaan.id_permintaan DESC LIMIT $start, $perpage");
while ($tookit = $reach->fetch_assoc()) {
  $permint[] = $tookit;
}

  
 ?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/style.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/Hover-master/css/hover.css">
    <link rel="stylesheet" type="text/css" href="fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="admin2.css">
    <title>Home</title>
  </head>
  
  <body>
  
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>
   


<section class="konten">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 mt-2">
        <div class="alert alert-success" role="alert">
          <?php  $namaAdmin = $_SESSION["admin"]["nama_admin"]; ?>
          <i class="fa fa-user" style="font-size: 13px"></i> &nbsp;&nbsp;Selamat datang <b><?php echo $namaAdmin; ?></b> di Sistem Informasi Manajemen Pengelolaan Alat Tulis Kantor.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
        </div>
      </div>
      <div class="col-sm-4 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body hvr-icon-float">
            <h4 class="card-title">Total ATK</h4>
            <div class="card-body-icon">
              <i class="fas fa-briefcase mr-2 hvr-icon"></i>
            </div>
            <div class="display-4"><?php echo $totalatk; ?></div>
            <a href="list.php"><p class="card-text" style="color: black;">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p></a>
          </div>
        </div>
      </div>

       <div class="col-sm-4 mb-3 mt-2">
        <div class="card" style="border : 0"> 
          <div class="card-body hvr-icon-float">
            <h4 class="card-title">Total Permintaan</h4>  
            <div class="card-body-icon">   
              <i class="fas fa-clipboard-list mr-2 hvr-icon"></i>
            </div>
            <div class="display-4"><?php echo $totalpermin; ?></div>
            <a href="permintaan.php"><p class="card-text" style="color: black;">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p></a>
          </div>
        </div>
      </div>

       <div class="col-sm-4 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body hvr-icon-float">
            <h4 class="card-title">Total Bidang</h4>
            <div class="card-body-icon">
              <i class="fas fa-users mr-2 hvr-icon"></i>
            </div>
            <div class="display-4"><?php echo $totaldiv; ?></div>
            <a href="datadivisi.php"><p class="card-text" style="color: black;">Lihat Detail <i class="fas fa-angle-double-right ml-2"></i></p></a>
          </div>
        </div>
      </div>


   <!--    <div class="col-sm-4 mb-3 mt-2 ">
        <div class="card" style="border : 0">
          <div class="card-body">
            <i class="fa-2x fas fa-clipboard-list ml-4 kartu2"></i>
            <h4 class="card-title"></h4>
            <p class="card-text">Total Permintaan</p>
          </div>
        </div>
      </div>
      <div class="col-sm-4 mb-3 mt-2 ">
        <div class="card" style="border : 0">
          <div class="card-body">
            <i class="fa-2x fas fa-users ml-4 kartu3"></i>
            <h4 class="card-title"></h4>
            <p class="card-text">Total Divisi</p>
          </div>
        </div>
      </div> -->
  </div>
 <div class="row">
      <div class="col-sm-4 col-md-push-8 mb-3 mt-2">
       <!--  <div class="card" style="border : 0">
          <div class="card-body">
            <i class="fa-2x fas fa-briefcase ml-4"></i>
            <h5 class="card-title">70</h5>
            <p class="card-text">Total ATK Terdaftar</p>
          </div>
        </div> -->
      </div>
      <div class="col-sm-8 col-md-push-4 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title">Permintaan Terbaru</h4>
            <!-- <p class="card-text">Total Permintaan</p> -->
            <table class="table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Bidang</th>
          <th>Detail</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php  foreach($permint as $row):?>
         <?php 
          $tanggal  = $row["tanggal_permintaan"];
          $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
          $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
          $hari = date('l, j F Y', strtotime($tanggal));
          $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
        ?>
        <tr>
          <td><?php echo $day; ?></td>
          <td><?php echo $row["nama_bidang"] ?></td>
          <td><a href="detail.php?id=<?php echo $row["id_permintaan"]; ?>"><i class="fas fa-search"></i></a></td>
          <td>
             <?php $status = $row['status'] ?>
            <?php if($status == "Disetujui"): ?>
              <td><a href="#" class="badge badge-success"><?php echo $row['status'];?></a></td>
            <?php elseif ($status =="diproses"):?>
              <td><a href="#" class="badge badge-warning"><?php echo $row['status'];?></a></td>
            <?php elseif ($status =="Selesai"):?>
              <td><a href="#" class="badge badge-light"><?php echo $row['status'];?></a></td>
            <?php else: ?>
              <td><a href="#" class="badge badge-danger"><?php echo $row['status'];?></a></td>
            <?php endif ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
 
  </div>
          </div>
        </div>
      </div>
  </div>
</section>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
   <script type="text/javascript" src="admin.js"></script>
      <script type="text/javascript" src="bootstrap/js/jquery.js"></script>
   <script type="text/javascript" src="bootstrap/js/popper.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>