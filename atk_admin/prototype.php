<?php 
session_start();
//koneksi ke database


// $_SESSION['list']="list";


include 'koneksi.php';


if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$perpage7 = 5;//perhalaman

$pageaktif7  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start7 = ($pageaktif7 > 1) ? ($perpage7 * $pageaktif7) - $perpage7 : 0;
$setbar=[];






if($phrase != ''){

  $results = mysqli_query($koneksi,"SELECT * FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk WHERE
      id_barang_masuk LIKE '%$phrase%' OR 
      tanggal_masuk LIKE '%$phrase%' OR
      id_atk LIKE '%$phrase%' OR
      jumlah_masuk LIKE '%$phrase%'");
  $tot  = mysqli_num_rows($results);//jumlah data
  $pages7  = ceil($tot / $perpage7);//jumlah halaman
 
}else{

 $results = mysqli_query($koneksi,"SELECT * FROM t_barang_masuk");
  $tot  = mysqli_num_rows($results);//jumlah data
  $pages7  = ceil($tot / $perpage7);//jumlah halaman

}


$jumlahlingx = 2;
if($pageaktif7 > $jumlahlingx) {
  $start_num = $pageaktif7 - $jumlahlingx;
}else{
  $start_num = 1;
}

if($pageaktif7 < ($pages7 - $jumlahlingx)){
  $end_num = $pageaktif7 + $jumlahlingx;
}else{
  $end_num = $pages7;
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
    <title>data barang masuk</title>
  </head>
  
  <body>

    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>
<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h5 class="card-title">Data Barang Masuk</h5>
                    <!-- fitur pencarian -->
                      <div class="row">
                      <div class="col-auto mr-auto">
                        <a href="inputbarangmasuk.php" class="btn btn-md btn-primary"><i class="fas fa-plus"></i>  Tambah Data</a>
                      </div>
                      <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="POST">
                          <input type="hidden" name="phrase" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari7" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                     
                     <div class="col-7 col-md-4">
                        <form action="" method="POST">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phrase" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari7" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                            </div>
                          </div>
                        </form>

                      </div>
                       <!--  <div class="col-md-7 col-md-pull-2">
                         
                        </div> -->
                      </div>
                      <!-- akhir pencarian
                    <p class="card-text">Total ATK Terdaftar</p> -->

                        <table class="table table-bordered table-striped table-hover">
                          <thead>
                            <tr>
                               <th>No. </th>
                              <th>ID Transaksi</th>
                              <th>Tanggal</th>
                              <th>ID Barang</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Masuk</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor=1; ?>
                            <?php
                           

                              if (isset($_POST['cari7'])){
                                 $phrase = $_POST['phrase'];
                                $select = mysqli_query($koneksi,"SELECT * FROM t_barang_masuk WHERE 
                                  id_barang_masuk LIKE '%".$phrase."%' OR 
                                    tanggal_masuk LIKE '%".$phrase."%' OR
                                    id_atk LIKE '%".$phrase."%' OR
                                    nama_atk LIKE '%".$phrase."%' OR
                                    jumlah_masuk LIKE '%".$phrase."%'
                              ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start7, $perpage7");
                              
                              }

                                $select =  mysqli_query($koneksi,"SELECT * FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start7, $perpage7");
                                
                              


                             ?>
                             <?php while( $set = mysqli_fetch_assoc($select)){?>

                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $set['id_barang_masuk']; ?></td>
                              <td><?php echo $set['tanggal_masuk']; ?></td>
                              <td><?php echo $set['id_atk']; ?></td>
                              <td><?php echo $set['nama_atk']; ?></td>
                              <td><?php echo $set['jumlah_masuk']; ?></td>
                               <td><a class="btn btn-sm btn-info" href="inputbarangmasuk.php?id=<?php echo $set["id_barang_masuk"];?>&val=1"> <i class="fas fa-plus" data-toggle="tooltip" title="tambah"></i></a> </td>
                             
                            </tr>
                             <?php $nomor++; ?>
                            <?php };?>
                          </tbody>
                          <?php echo $phrase; ?>
                        </table>

                        <!-- awal pagination -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php if($pageaktif7 > 1) :?>
                             <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif7 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php else: ?>
                              <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif7 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php for($i=$start_num; $i<= $end_num; $i++) {?>
                            <?php  if($i == $pageaktif7): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif7 == $pages7) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif7 + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif7 + 1; ?>" aria-label="Next">
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


<script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>



  </body>
</html>