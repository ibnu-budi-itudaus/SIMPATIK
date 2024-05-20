<?php 
session_start();
//koneksi ke database
error_reporting(0);

// $_SESSION['list']="list";


include 'koneksi.php';


if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

$perpage9 = 5;//perhalaman

$pageaktif9  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start9 = ($pageaktif9 > 1) ? ($perpage9 * $pageaktif9) - $perpage9 : 0;
$setbar=[];





$select =  mysqli_query($koneksi,"SELECT * FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start9, $perpage9");                           

                            if(isset($_POST["cari9"])){
                            $phrase = $_POST['phrase'];
                            $_SESSION["phrase"] = $phrase;
                             

                                $select =  mysqli_query($koneksi,"SELECT * FROM t_barang_keluar WHERE 
                                  id_barang_keluar LIKE '%$phrase%' OR 
                                    tanggal_keluar LIKE '%$phrase%' OR
                                    id_atk LIKE '%$phrase%' OR
                                    nama_atk LIKE '%$phrase%' OR
                                    jumlah_keluar LIKE '%$phrase%'
                             ORDER BY id_barang_keluar DESC LIMIT $start9, $perpage9");
                                echo "<script>location='?halaman=1'; </script>";

                              }else{
                                  $phrase = $_SESSION['phrase'];
                                   $select =  mysqli_query($koneksi,"SELECT * FROM t_barang_keluar WHERE 
                                  id_barang_keluar LIKE '%$phrase%' OR 
                                    tanggal_keluar LIKE '%$phrase%' OR
                                    id_atk LIKE '%$phrase%' OR
                                    nama_atk LIKE '%$phrase%' OR
                                    jumlah_keluar LIKE '%$phrase%'
                             ORDER BY id_barang_keluar DESC LIMIT $start9, $perpage9");
                              
                                
                              }




if(isset($_SESSION["phrase"])){

  $results = mysqli_query($koneksi,"SELECT * FROM t_barang_keluar WHERE
      id_barang_keluar LIKE '%$phrase%' OR 
      tanggal_keluar LIKE '%$phrase%' OR
      id_atk LIKE '%$phrase%' OR
      nama_atk LIKE '%$phrase%' OR
      jumlah_keluar LIKE '%$phrase%'");
  $tot  = mysqli_num_rows($results);//jumlah data
  $pages9  = ceil($tot / $perpage9);//jumlah halaman
 
}else{

 $results = mysqli_query($koneksi,"SELECT * FROM t_barang_keluar");
  $tot  = mysqli_num_rows($results);//jumlah data
  $pages9  = ceil($tot / $perpage9);//jumlah halaman

}


$jumlahlingy = 2;
if($pageaktif9 > $jumlahlingy) {
  $start_numb = $pageaktif9 - $jumlahlingy;
}else{
  $start_numb = 1;
}

if($pageaktif9 < ($pages9 - $jumlahlingy)){
  $end_numb = $pageaktif9 + $jumlahlingy;
}else{
  $end_numb = $pages9;
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
    <title>data barang keluar</title>
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
                    <h4 class="card-title"><i class="fas fa-sign-out-alt mr-2"></i>Data Barang Keluar</h4>
                    <!-- fitur pencarian -->
                      <div class="row">
                      <!-- <div class="col-auto mr-auto">
                        <a href="inputbarangmasuk.php" class="btn btn-md btn-primary"><i class="fas fa-plus"></i>  Tambah Data</a>
                      </div> -->
                      <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="POST">
                          <input type="hidden" name="phrase" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari9" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                     
                     <div class="col-7 col-md-4">
                        <form action="" method="POST">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="phrase" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari9" id="button-addon2"><i class="fas fa-search"></i></button>
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
                              <th>Jumlah Keluar</th>
                              <!-- <th>Aksi</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor=1; ?>
                          

                             <?php if(mysqli_num_rows($select)){ ?>
                             <?php while( $set = mysqli_fetch_assoc($select)){?>

                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $set['id_barang_keluar']; ?></td>
                              <td><?php echo $set['tanggal_keluar']; ?></td>
                              <td><?php echo $set['id_atk']; ?></td>
                              <td><?php echo $set['nama_atk']; ?></td>
                              <td><?php echo $set['jumlah_keluar']; ?></td>
                              <!--  <td><a class="btn btn-sm btn-info" href="inputbarangkeluar.php?id=<?php ?>&val=1"> <i class="fas fa-plus" data-toggle="tooltip" title="tambah"></i></a> </td> -->
                             
                            </tr>
                             <?php $nomor++; ?>
                            <?php };?>
                          </tbody>
                     
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
                            <?php for($i=$start_numb; $i<= $end_numb; $i++) {?>
                            <?php  if($i == $pageaktif9): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif9 == $pages9) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif9 + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif9 + 1; ?>" aria-label="Next">
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


<script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>



  </body>
</html>