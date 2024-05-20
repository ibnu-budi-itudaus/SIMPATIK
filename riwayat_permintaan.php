<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

$articles = "SELECT*FROM t_permintaan LIMIT $start, $perpage";

$id_bidang = $_SESSION['bidang']['id_bidang'];
$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan WHERE id_bidang = '$id_bidang'");
$total  = mysqli_num_rows($result);//jumlah data

$pages  = ceil($total / $perpage);//jumlah halaman

$jumlahlink = 3;
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

if (!isset($_SESSION['bidang']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login1.php'; </script>";
    header ('location:login1.php');
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
    <link rel="stylesheet" type="text/css" href="users3.css">
    <title>Riwayat Permintaan</title>
  </head>
  
  <body>

   


    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->


<?php include 'menu1.php'; ?>


<section class="konten">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card" style="border: 0;">
          <div class="card-body">
            <h5 class="card-title mb-4">Riwayat Permintaan</h5>
            <div class="row">
              <!-- <div class="col-md-4 col-md-push-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div> -->
                <div class="col-md-7 col-md-pull-2">
                 
                </div>
              </div>
               <table class="table table-bordered table-striped table-hover">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>Tanggal</th>
                              <th>Detail</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor = 1; ?>
                            <?php $id_bidang = $_SESSION["bidang"]["id_bidang"]; ?>
                            <?php $ambil = $koneksi->query("SELECT * FROM t_permintaan WHERE id_bidang = '$id_bidang' ORDER BY id_permintaan DESC LIMIT $start, $perpage"); ?>
                            <?php while($pecah = $ambil->fetch_assoc()){ ?>
                              <?php 

                                  $tanggal  = $pecah["tanggal_permintaan"];
                                  $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                                  $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                  $hari = date('l, j F Y', strtotime($tanggal));
                                  $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
                                  
                                  // date_default_timezone_set('Asia/Jakarta');
                                  // $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                                  // $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                  // $today = date('l, F, j, Y');
                                  // $sekarang = $namaHari[date('N')] . ", " . date('j') . " " . $namaBulan[(date('n')-1)] . " " . date('Y');
                              ?>
                            <tr>
                              <td style="width: 10px;"><?php echo $nomor.'. ';?></td>
                              <td><?php echo $day;?></td>
                              <td><a class="ml-5" href="detailpermintaan1.php?id=<?php echo $pecah["id_permintaan"];?>"><i class="fas fa-search" data-toggle="tooltip" title="detail permintaan"></i></a></td>
                              <?php $status = $pecah['status'] ?>
                                  <?php if($status == "Disetujui"): ?>
                                    <?php  if(isset($_SESSION['admin'])):?>
                                    <td><a href="#" class="badge badge-warning">Dalam Proses</a></td>
                                    <?php else: ?>
                                    <td><a href="#" class="badge badge-success"><?php echo $pecah['status']; ?></a></td>
                                  <?php endif ?>
                              <?php elseif ($status =="Selesai"):?>
                                <td><a href="#" class="badge badge-light"><?php echo $pecah['status']; ?></a></td>
                                 <?php elseif ($status ==""):?>
                                <td><a href="#" class="badge badge-danger">Belum Ditindak</a></td>
                              <?php else: ?>
                                <td><a href="#" class="badge badge-danger"><?php echo $pecah['status']; ?></a></td>
                            </tr>
                          <?php endif ?>
                            <?php $nomor++; ?>
                            <?php } ?>
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
                            <?php for($i= $start_number; $i<= $end_number; $i++) {?>
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
     <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
  </body>
</html>