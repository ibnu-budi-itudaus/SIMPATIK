<?php 
session_start();
//koneksi ke database
error_reporting(0); 

include 'koneksi.php';
require 'functions.php';

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$pengadaan = queryy2("SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang WHERE t_permintaan.status IN ('Disetujui','Selesai') ORDER BY id_permintaan DESC LIMIT $start, $perpage ");


if(isset($_POST['carilah'])){
  $keyworld = $_POST['keyworld'];
  $_SESSION['keyworld'] =  $keyworld;
 $pengadaan = carilah($keyworld);
 echo "<script>location='?halaman=1'; </script>";
}else{
  $keyworld = $_SESSION['keyworld'];
  $pengadaan = carilah($keyworld);
}



$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;


if(isset($_SESSION['keyworld'])){
$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang WHERE 
    nama_bidang LIKE '%$keyworld%' OR 
    tanggal_permintaan LIKE '%$keyworld%' OR
    status LIKE '%$keyworld%'");
$total  = mysqli_num_rows($result);//jumlah data
$pages  = ceil($total / $perpage);//jumlah halaman
}else{
  $result = mysqli_query($koneksi,"SELECT*FROM t_permintaan");
$total  = mysqli_num_rows($result);//jumlah data
$pages  = ceil($total / $perpage);//jumlah halaman
}


// $ambil= $koneksi->query("SELECT*FROM t_permintaan");
// $take= $ambil->fetch_assoc();


$jumlahlink = 2;
if($pageaktif > $jumlahlink) {
  $start_number = $pageaktif - $jumlahlink;
}else{
  $start_number = 1;
}

if($pageaktif < ($pages - $jumlahlink)){
  $end_number = $pageaktif + $jumlahlink;
}else{
  $end_number = $pages;
}

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
    <link rel="stylesheet" type="text/css" href="admin.css">
    <link rel="stylesheet" type="text/css" href="inputdata.css">
    <title>data_atk</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>

<!-- <div class="container">
	 <nav aria-label="breadcrumb" id="bread1">
	  <ol class="breadcrumb" style="background-color: white">
	  	<li class="breadcrumb-item"><a href="kategori.php">Kategori</a></li>
	  	<li class="breadcrumb-item"><a href="satuan.php">Satuan</a></li>
        <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item active" aria-current="page">List</li>
	    
	  </ol>
	</nav>
</div> -->
<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h4 class="card-title mb-4"><i class="fas fa-tasks mr-2"></i>Pengadaan Divisi</h4>
                   <!--  <p class="card-text">Total ATK Terdaftar</p> -->
                   <div class="row">
                    <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="post">
                            <input type="hidden" name="keyworld" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="carilah" type="button" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                       
                       
                      <div class="col-7 col-md-4">
                        <form action="" method="post">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keyworld" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="carilah" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                            </div>
                          </div>
                        </form>

                      </div>
                       <!--  <div class="col-md-7 col-md-pull-2">
                         
                        </div> -->
                      </div>

                        <table class="table table-bordered table-striped table-hover">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Tanggal</th>
                              <th>Nama Bidang</th>
                              <th>Detail</th>
                              <th>Status</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                           
                            <?php $nomor=1; ?>
                            <?php foreach ( $pengadaan as $permint) :?>
                            <?php 
                              $tanggal  = $permint["tanggal_permintaan"];
                              $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                              $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                              $hari = date('l, j F Y', strtotime($tanggal));
                              $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
                             ?>
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $day;?></td>
                              <td><?php echo $permint["nama_bidang"];?></td>
                              <td><a href="detailpengadaan.php?id=<?php echo $permint["id_permintaan"];?>"><i class="fas fa-search" data-toggle="tooltip" title="click! detail permintaan"></i></a></td>
                              <?php $status = $permint['status'] ?>
                              <?php if($status == "Disetujui"): ?>
                                <td><a href="#" class="badge badge-warning text-white">Dalam Proses</a></td>
                              <?php elseif ($status =="Selesai"):?>
                                <td><a href="#" class="badge badge-light"><?php echo $permint['status']; ?></a></td>
                               <?php elseif ($status ==""):?>
                                <td><a href="#" class="badge badge-danger">Belum Ditindak</a></td>
                              <?php else: ?>
                                <td><a href="#" class="badge badge-danger"><?php echo $permint['status']; ?></a></td>
                              <?php endif ?>
                              <?php if($status == "Selesai"): ?>
                              <td>
                                 <a class="btn btn-sm btn-info" href="print.php?id=<?php echo $permint["id_permintaan"];?>&val=3" target="_blank"> <i class="fas fa-print" data-toggle="tooltip" title="print"></i></a> 
                              </td>
                              <?php elseif ($status == "Disetujui"): ?>
                              <td>
                                <a class="btn btn-sm btn-primary" href="aksiadmin.php?id=<?php echo $permint["id_permintaan"];?>&val=3"> <i class="fas fa-check" data-toggle="tooltip" title="selesai"></i></a> 
                              </td>
                               <?php else : ?>
                              <td>
                                <a class="btn btn-sm btn-danger" href=""> <i class="fas fa-stop" data-toggle="tooltip" title="Belum ditindak"></i></a> 
                              </td>
                            <?php endif ?>
                            </tr>
                             <?php $nomor++; ?>
                             <?php endforeach; ?>
                          </tbody>
                        </table>

                        <!-- awal pagination -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php if($pageaktif > 1) :?>
                             <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php else: ?>
                              <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php for($i=$start_number; $i<= $end_number; $i++) {?>
                            <?php  if($i == $pageaktif): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif == $pages) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                          <?php endif; ?>
                          </ul>
                        </nav>
                      <!-- akhir pagination -->
                  </div>
        </div>
            </div>      
        </div>
    </div>     
</section>

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
   <script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
  </body>
</html>