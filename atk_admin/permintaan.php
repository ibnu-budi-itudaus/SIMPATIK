<?php 
session_start();
//koneksi ke database
error_reporting(0); 

include 'koneksi.php';

require 'functions.php'; // require berfungsi untuk menghubung kan file 1 dengan file lainnya, mirip include

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$permintaan = queryy("SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang ORDER BY t_permintaan.id_permintaan DESC LIMIT $start, $perpage");


 if(isset($_POST['cari'])){
  $keyword = $_POST['keyword'];
  $_SESSION['keyword'] =  $keyword;
 $permintaan = cari($keyword);
 // echo "<meta http-equiv='refresh' content='1;url=?halaman=1'>"; (agak lambat /delay dalam merefresh halaman)
 //setelah ditekan tombol cari maka halaman url diberi nilai halaman = 1
 echo "<script>location='?halaman=1'; </script>";//refreshnya lebih cepat dari yg diatas ini
}else{
  $keyword = $_SESSION['keyword'];
  $permintaan = cari($keyword);
}


// if(isset($_POST["cari"])){
//   $cari = $_POST["keyword"];
//   $_SESSION["cari"] = $cari;
// }else{
//   $cari = $_SESSION["cari"];
// }

// $ambil = $koneksi->query("select * FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang  WHERE t_permintaan.id_permintaan LIKE '%$keyword%' OR t_bidang.nama_bidang LIKE '%keyword&' or t_permintaan.tanggal_permintaan LIKE '%keyword&'" );

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

if(isset($_SESSION['keyword'])){
$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang WHERE 
    nama_bidang LIKE '%$keyword%' OR 
    tanggal_permintaan LIKE '%$keyword%' OR
    status LIKE '%$keyword%'");
$total  = mysqli_num_rows($result);//jumlah data
$pages  = ceil($total / $perpage);//jumlah halaman
}else{
  $result = mysqli_query($koneksi,"SELECT*FROM t_permintaan");
$total  = mysqli_num_rows($result);//jumlah data
$pages  = ceil($total / $perpage);//jumlah halaman
}



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

// $ambildata = $koneksi->query("SELECT*FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang ORDER BY t_permintaan.id_permintaan DESC LIMIT $start, $perpage");



//fungsi cari
// if(isset($_POST['cari'])){
//   $keyword = $_POST['keyword'];
//   $_SESSION['keyword'] =  $keyword;

//  $permintaan = cari($keyword);
// }else{
//   $keyword = $_SESSION['keyword'];
//   $permintaan = cari($keyword);
// }

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
    <link rel="stylesheet" type="text/css" href="admin2.css">
    <link rel="stylesheet" type="text/css" href="inputdata.css">
    <title>data_atk</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>

<!-- <div class="container">
  <div class="bread">
	 <nav aria-label="breadcrumb" id="bread1">
	  <ol class="breadcrumb" style="background-color: white">
	  	<li class="breadcrumb-item"><a href="kategori.php">Kategori</a></li>
	  	<li class="breadcrumb-item"><a href="satuan.php">Satuan</a></li>
        <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item active" aria-current="page">List</li>
	    
	  </ol>
	</nav>
 </div>
</div> -->

<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h4 class="card-title mb-4"><i class="fas fa-clipboard-list mr-2"></i>Permintaan Divisi</h4>
                   <!--  <p class="card-text">Total ATK Terdaftar</p> -->
                   <div class="row">
                     <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="post">
                            <input type="hidden" name="keyword" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari" type="button" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>

                      </div>
                       
                     <div class="col-7 col-md-4">
                        <form action="" method="post">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keyword" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
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
                             <?php if($permintaan==!null){ ?>
                            <?php foreach ( $permintaan as $permin ): ?>
                            <?php
                              $tanggal  = $permin["tanggal_permintaan"];
                              $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                              $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                              $hari = date('l, j F Y', strtotime($tanggal));
                              $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
                             ?>
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $day;?></td>
                              <td><?php echo $permin["nama_bidang"];?></td>
                              <td><a href="detailpermintaan.php?id=<?php echo $permin["id_permintaan"];?>"><i class="fas fa-search" data-toggle="tooltip" title="click! detail permintaan"></i></a></td>
                              <?php $status = $permin['status'] ?>
                              <?php if($status == "Disetujui"): ?>
                                <td><a href="#" class="badge badge-success"><?php echo $permin['status']; ?></a></td>
                              <?php elseif ($status =="diproses"):?>
                                <td><a href="#" class="badge badge-warning"><?php echo $permin['status']; ?></a></td>
                              <?php elseif ($status =="Selesai"):?>
                                <td><a href="#" class="badge badge-light"><?php echo $permin['status']; ?></a></td>
                               <?php elseif ($status ==""):?>
                                <td><a href="#" class="badge badge-danger">Belum Ditindak</a></td>
                              <?php else: ?>
                                <td><a href="#" class="badge badge-danger"><?php echo $permin['status']; ?></a></td>
                              <?php endif ?>
                              <?php if($status == "Disetujui" || $status == "Selesai"): ?>
                               <td>
                                <a class="btn btn-sm btn-info" href="cetak.php?id=<?php echo $permin["id_permintaan"];?>&val=1" target="_BLANK"> <i class="fas fa-print" data-toggle="tooltip" title="print"></i></a> 
                               </td>
                               <?php else: ?> 
                              <td>
                                <a class="btn btn-sm btn-primary" href="aksiadmin.php?id=<?php echo $permin["id_permintaan"];?>&val=1"> <i class="fas fa-check" data-toggle="tooltip" title="disetujui"></i></a> 
                                <a onclick = "return confirm('apakah anda yakin ingin menolak ini?');"class="btn btn-sm btn-danger ml-2" href="aksiadmin.php?id=<?php echo $permin["id_permintaan"];?>&val=0"> <i class="fas fa-ban" data-toggle="tooltip" title="ditolak"></i></a>
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
                       <?php }else{?>

                          <div class="col-sm-12 mt-2">
                              <div class="alert alert-danger" role="alert">
                                Pencarian dengan kata kunci <b><?php echo $keyword; ?></b> tidak ditemukan!. Harap mengulangi lagi pencarian dengan kata kunci yang relevan. Untuk mengembalikan tabel permintaan divisi silahkan klik tombol refresh tabel disamping kiri kolom pencarian.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                              </div>
                            </div>
                        <?php };
                        ?>
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