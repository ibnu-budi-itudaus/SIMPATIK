<?php 
session_start();
//koneksi ke database
error_reporting(0); 
//untuk menyembunyikan kalimat error yg merusak pemandangan
// $_SESSION['satuan']="satuan";

include 'koneksi.php'; 
require 'functions.php';


if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}
// if (isset($_SESSION['list']) && isset($_SESSION['satuan']))
// {
//    unset($_SESSION['keyy']);
//    unset($_SESSION['list']);
// }


$perpage4 = 5;//perhalaman

$pageaktif4  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start4 = ($pageaktif4 > 1) ? ($perpage4 * $pageaktif4) - $perpage4 : 0;


$satu = kueri("SELECT * FROM t_satuan LIMIT $start4, $perpage4");
  $key="";
if(isset($_POST['cari4'])){
  $key = $_POST['key'];
  $_SESSION['key'] =  $key;
 $satu = cari4($key);
 echo "<script>location='?halaman=1'; </script>";
}else{
  $key="";
  $key = $_SESSION['key'];
  $satu = cari4($key);
}



if(isset($_SESSION['key'])){
$result = mysqli_query($koneksi,"SELECT*FROM t_satuan WHERE 
    nama_satuan LIKE '%$key%'");
$total4  = mysqli_num_rows($result);//jumlah data

$pages4  = ceil($total4 / $perpage4);//jumlah halaman
}else{
  $result = mysqli_query($koneksi,"SELECT*FROM t_satuan");
$total4  = mysqli_num_rows($result);//jumlah data
$pages4  = ceil($total4 / $perpage4);//jumlah halaman
}



$jumlahlink = 2;
if($pageaktif4 > $jumlahlink) {
  $start_number2 = $pageaktif4 - $jumlahlink;
}else{
  $start_number2 = 1;
}

if($pageaktif4 < ($pages4 - $jumlahlink)){
  $end_number2 = $pageaktif4 + $jumlahlink;
}else{
  $end_number2 = $pages4;
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
    <title>data_atk</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>

<div class="container">
	 <nav aria-label="breadcrumb" id="bread1">
	  <ol class="breadcrumb" style="background-color: white">
	  	<li class="breadcrumb-item"><a href="kategori.php">Kategori</a></li>
	  	<li class="breadcrumb-item active" aria-current="page">Satuan</li>
	    <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item"><a href="list.php">Daftar ATK</a></li>
	  </ol>
	</nav>
</div>
<section class="konten">
  <div class="container">
    
 <div class="row">
      <div class="col-sm-4 col-md-push-8">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title mb-4">Satuan ATK</h4>
           <!--  <p class="card-text">Total ATK Terdaftar</p> -->
          	<form role="form" method="post">
                <div class="form-group">
                	 <input type="text" name="nama" class="form-control" placeholder="Nama Satuan">
            	</div>
            	 <div class="form-group">
                  <input type="submit" name="input" value="input" class="btn btn-primary btn-block">
                </div>
            </form>
          </div>
        </div>

        <?php 
			if (isset($_POST['input']))
			 {
				$koneksi->query("INSERT INTO t_satuan
				(nama_satuan)
				VALUES ('$_POST[nama]')");

				echo "<script>alert('Data berhasil disimpan !');</script>";
				echo "<script>location='satuan.php';</script>";
			}
		 
		 ?>

      </div>
      <div class="col-sm-8 col-md-push-4"">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title  mb-4">Daftar Satuan</h4>
            <!-- <p class="card-text">Total Permintaan</p> -->
              <div class="row">
                <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="post">
                            <input type="hidden" name="key" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari4" type="button" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                    
                      <div class="col-8 col-md-5">
                        <form action="" method="post">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="key" size="60" placeholder="Cari satuan.." aria-label="Recipient's username" autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari4" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                            </div>
                          </div>
                        </form>

                      </div>
                    </div>
            <table class="table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                	<?php $nomor=1; ?>
                    <?php if($satu ==!null){ ?>
                	<?php foreach($satu as $pecah) :?>
                  <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama_satuan'] ?></td>
                    <td><a class="btn btn-sm btn-warning" id="tombolUbah" data-toggle="modal" data-target="#ubahModal" data-id="<?php echo $pecah['id_satuan']; ?>" data-nama="<?php echo $pecah['nama_satuan']; ?>" > <i class="fas fa-edit" data-toggle="tooltip" title="Ubah data"></i></a>
                      <a onclick = "return confirm('apakah anda yakin ingin menghapus data');"class="btn btn-sm btn-danger" href="hapussatuan.php?id=<?php echo $pecah['id_satuan']; ?>"> <i class="fas fa-trash-alt" data-toggle="tooltip" title="Hapus data"></i></a></td>
                  </tr>
           		<?php $nomor++; ?>
                  <?php endforeach;?>
           
                 
                </tbody>
              </table>
    
     <!-- awal pagination -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php if($pageaktif4 > 1) :?>
                             <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif2 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php else: ?>
                              <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif4 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php for($i=$start_number2; $i<= $end_number2; $i++) {?>
                            <?php  if($i == $pageaktif4): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif4 == $pages4) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif4 + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif4 + 1; ?>" aria-label="Next">
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
                                Pencarian dengan kata kunci <b><?php echo $key; ?></b> tidak ditemukan!. Harap mengulangi lagi pencarian dengan kata kunci yang relevan. Untuk mengembalikan tabel daftar satuan silahkan klik tombol refresh tabel disamping kiri kolom pencarian.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
</section>

<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabell" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="ubahModalLabell">Ubah Satuan</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="close">
                   <span aria-hidden="true" style="font-size: 18px">&times;</span></button>
                 </div>
                 <div class="modal-body">
                   <form role="form" method="post">

                    <input type="hidden" name="id_satuan" id="id_satuan" class="form-control">

                     <div class="form-group">
                       <label for="nama_satuan">Nama Satuan</label>
                       <input type="text" class="form-control" name="nama_satuan" id="nama_satuan">
                      </div>
                      
                       
                      
                
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                   <button type="submit" name="edit" class="btn btn-primary">Ubah</button>

                 </div>
                 </form>
                <?php 


               if (isset($_POST["edit"]))

                    {
                        $koneksi->query("UPDATE t_satuan SET nama_satuan='$_POST[nama_satuan]'
                          WHERE id_satuan='$_POST[id_satuan]'");
                      echo "<script>alert('Data satuan telah diubah'); </script>";
                      echo "<script>location='satuan.php'; </script>";
                    }

                 ?>
                  
                </div>                 
               
                


                </div>
              </div>
            </div>



<script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>


<script>
  $(document).on("click","#tombolUbah", function(){
      let id= $(this).data('id');
      let nama = $(this).data('nama');

      $("#id_satuan").val(id);
      $("#nama_satuan").val(nama);
  });

</script>


  </body>
</html>
