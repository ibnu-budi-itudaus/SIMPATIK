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

$perpage3 = 5;//perhalaman

$pageaktif3  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start3 = ($pageaktif3 > 1) ? ($perpage3 * $pageaktif3) - $perpage3 : 0;


$kate = kueri("SELECT * FROM t_kategori LIMIT $start3, $perpage3");

if(isset($_POST['cari3'])){
$keys="";
  $keys = $_POST['keys'];
  $_SESSION['keys'] =  $keys;
 $kate = cari3($keys);
 echo "<script>location='?halaman=1'; </script>";
}else{
 $keys="";
  $keys = $_SESSION['keys'];
  $kate = cari3($keys);
}




if(isset($_SESSION['keys'])){
$result = mysqli_query($koneksi,"SELECT*FROM t_kategori WHERE 
    nama_kategori LIKE '%$keys%'");
$total3  = mysqli_num_rows($result);//jumlah data

$pages3  = ceil($total3 / $perpage3);//jumlah halaman
}else{
  $result = mysqli_query($koneksi,"SELECT*FROM t_kategori");
$total3  = mysqli_num_rows($result);//jumlah data
$pages3  = ceil($total3 / $perpage3);//jumlah halaman
}



$jumlahlinks = 2;
if($pageaktif3 > $jumlahlinks) {
  $start_number3 = $pageaktif3 - $jumlahlinks;
}else{
  $start_number3 = 1;
}

if($pageaktif3 < ($pages3 - $jumlahlinks)){
  $end_number3 = $pageaktif3 + $jumlahlinks;
}else{
  $end_number3 = $pages3;
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
	  	<li class="breadcrumb-item active" aria-current="page">Kategori</li>
	  	<li class="breadcrumb-item"><a href="satuan.php">Satuan</a></li>
	    <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item"><a href="list.php">Daftar ATK</a></li>
	  </ol>
	</nav>
</div>
<section class="konten">
  <div class="container">
    
 <div class="row">
      <div class="col-sm-4 col-md-push-8 mb-3">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title mb-4">Kategori ATK</h4>
           <!--  <p class="card-text">Total ATK Terdaftar</p> -->
          	<form role="form" method="post">
                <div class="form-group">
                	 <input type="text" name="nama" class="form-control" placeholder="Nama Kategori">
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
				$koneksi->query("INSERT INTO t_kategori
				(nama_kategori)
				VALUES ('$_POST[nama]')");

				echo "<script>alert('Data berhasil disimpan !');</script>";
				echo "<script>location='kategori.php';</script>";
			}
		 
		 ?>

      </div>
      <div class="col-sm-8 col-md-push-4"">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title mb-4">Daftar Kategori</h4>
            <!-- fitur pencarian -->
             <div class="row">
                   <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="post">
                            <input type="hidden" name="keys" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="cari3" type="button" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                       
                      <div class="col-8 col-md-5">
                        <form action="" method="post">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keys" size="60" placeholder="Cari kategori.." aria-label="Recipient's username" autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="cari3" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
                            </div>
                            </div>
                          </div>
                        </form>

                      </div>
                    </div>
             <!-- akhir fitur pencarian -->
                     
                     
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
                  <?php if($kate ==!null){?>
                	<?php foreach($kate as $pecah):?>
                  <tr>
                    <td><?php echo $nomor; ?></td>
                    <td><?php echo $pecah['nama_kategori'] ?></td>
                    <td><a class="btn btn-sm btn-warning" id="tombolUbah" data-toggle="modal" data-target="#ubahModal" data-id="<?php echo $pecah['id_kategori']; ?>" data-nama="<?php echo $pecah['nama_kategori']; ?>" > <i class="fas fa-edit" data-toggle="tooltip" title="Ubah data"></i></a>
                      <a onclick = "return confirm('apakah anda yakin ingin menghapus data');"class="btn btn-sm btn-danger" href="hapuskategori.php?id=<?php echo $pecah['id_kategori']; ?>"> <i class="fas fa-trash-alt" data-toggle="tooltip" title="Hapus data"></i></a>
                      </td>
                            </tr>
           		<?php $nomor++; ?>
                  <?php endforeach; ?>
           
                 
                </tbody>
              </table>
    
     <!-- awal pagination -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php if($pageaktif3 > 1) :?>
                             <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif3 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php else: ?>
                              <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif3 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php for($i=$start_number3; $i<= $end_number3; $i++) {?>
                            <?php  if($i == $pageaktif3): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif3 == $pages3) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif3 + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif3 + 1; ?>" aria-label="Next">
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
                                Pencarian dengan kata kunci <b><?php echo $keys; ?></b> tidak ditemukan!. Harap mengulangi lagi pencarian dengan kata kunci yang relevan. Untuk mengembalikan tabel daftar kategori silahkan klik tombol refresh tabel disamping kiri kolom pencarian.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
 <div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="ubahModalLabel">Ubah Kategori</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="close">
                   <span aria-hidden="true" style="font-size: 18px">&times;</span></button>
                 </div>
                 <div class="modal-body">
                   <form role="form" method="post">

                    <input type="hidden" name="id_kategori" id="id_kategori" class="form-control">

                     <div class="form-group">
                       <label for="nama_kategori">Nama Kategori</label>
                       <input type="text" class="form-control" name="nama_kategori" id="nama_kategori">
                      </div>
                      
                       
                      
                
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                   <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>

                 </div>
                 </form>
                <?php 


               if (isset($_POST["ubah"]))

                    {
                        $koneksi->query("UPDATE t_kategori SET nama_kategori='$_POST[nama_kategori]'
                          WHERE id_kategori='$_POST[id_kategori]'");
                      echo "<script>alert('Data kategori telah diubah'); </script>";
                      echo "<script>location='kategori.php'; </script>";
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

<!-- JS untuk ubah data dgn modal -->
<script>
  $(document).on("click","#tombolUbah", function(){
      let id= $(this).data('id');
      let nama = $(this).data('nama');

      $("#id_kategori").val(id);
      $("#nama_kategori").val(nama);
  });

</script>
<script type="text/javascript">


 

</script>


  </body>
</html>
