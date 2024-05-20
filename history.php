<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

if (!isset($_SESSION['bidang']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

$id_bidang = $_SESSION["bidang"]["id_bidang"]; 
$select = $koneksi->query("SELECT * FROM t_permintaan WHERE id_bidang = '$id_bidang' ORDER BY id_permintaan DESC LIMIT $start, $perpage");

$filter = "tanggal_permintaan LIKE '%$phrase%' OR
        status LIKE '%$phrase%'";
 if(isset($_POST["cari"])){
$phrase = $_POST['phrase'];
$_SESSION["phrase"] = $phrase;
 

    $select =  mysqli_query($koneksi,"SELECT * FROM t_permintaan WHERE 
     id_bidang = '$id_bidang' AND '$filter'
        
 ORDER BY id_permintaan DESC LIMIT $start, $perpage");
    echo "<script>location='?halaman=1'; </script>";

  }else{
      $phrase = $_SESSION['phrase'];
       $select =  mysqli_query($koneksi,"SELECT * FROM t_permintaan WHERE 
     id_bidang = '$id_bidang' AND '$filter'
 ORDER BY id_permintaan DESC LIMIT $start, $perpage");
  
    
  }

if(isset($_SESSION["phrase"])){
$id_bidang = $_SESSION['bidang']['id_bidang'];
  $results = mysqli_query($koneksi,"SELECT * FROM t_permintaan WHERE id_bidang = '$id_bidang' AND  
     
        tanggal_permintaan LIKE '%$phrase%' OR
        status LIKE '%$phrase%'");
  $tot  = mysqli_num_rows($results);//jumlah data
  $pages = ceil($tot / $perpage);//jumlah halaman
 
}else{

$id_bidang = $_SESSION['bidang']['id_bidang'];
$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan WHERE id_bidang = '$id_bidang'");
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
    <link rel="stylesheet" type="text/css" href="users.css">
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
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Riwayat Permintaan</h5>
            <div class="row">
                      <!-- <div class="col-auto mr-auto">
                        <a href="inputbarangmasuk.php" class="btn btn-md btn-primary"><i class="fas fa-plus"></i>  Tambah Data</a>
                      </div> -->
                      <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="POST">
                          <input type="hidden" name="phrase" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                     
                     <div class="col-7 col-md-4">
                        <form action="" method="POST">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phrase" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari" id="button-addon2"><i class="fas fa-search"></i></button>
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
                              <th>Detail</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor=1; ?>
                          

                             <?php if($select == !null){ ?>
                             <?php while( $pecah = mysqli_fetch_assoc($select)){?>
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
                            <?php }; ?>
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
                      <?php }else{?>

                          <div class="col-sm-12 mt-2">
                              <div class="alert alert-danger" role="alert">
                                Pencarian dengan kata kunci <b><?php echo $phrase; ?></b> tidak ditemukan!. Harap mengulangi lagi pencarian dengan kata kunci yang relevan. Untuk mengembalikan tabel barang keluar silahkan klik tombol refresh tabel disamping kiri kolom pencarian.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
     <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
  </body>
</html>