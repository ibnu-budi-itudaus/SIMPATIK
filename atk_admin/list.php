<?php 
session_start();
//koneksi ke database
error_reporting(0);

// $_SESSION['list']="list";


include 'koneksi.php';
require 'functions.php';

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}
// if (isset($_SESSION['satuan']) && isset($_SESSION['list']))
// {
//    unset($_SESSION['key']);
//    unset($_SESSION['satuan']);
// }


$tools =  queryy("SELECT * FROM t_barang_atk LIMIT $start2, $perpage2");

if(isset($_POST['carik'])){
  
  $keyy = $_POST['keyy'];
  $_SESSION['keyy'] =  $keyy;
 $tools = carik($keyy);
  echo "<script>location='?halaman=1'; </script>";
  
}else{
  
  $keyy = $_SESSION['keyy'];
  $tools = carik($keyy);
}


$perpage2 = 5;//perhalaman

$pageaktif2  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start2 = ($pageaktif2 > 1) ? ($perpage2 * $pageaktif2) - $perpage2 : 0;


if(!isset($_SESSION['keyy'])){
  $result = mysqli_query($koneksi,"SELECT*FROM t_barang_atk");
  $totale  = mysqli_num_rows($result);//jumlah data
  $pages2  = ceil($totale / $perpage2);//jumlah halaman
}else{
  $result = mysqli_query($koneksi,"SELECT*FROM t_barang_atk WHERE
      nama_atk LIKE '%$keyy%' OR 
      kategori_atk LIKE '%$keyy%' OR
      satuan LIKE '%$keyy%' OR
      harga LIKE '%$keyy%' OR
      stok LIKE '%$keyy%'");
  $totale  = mysqli_num_rows($result);//jumlah data
  $pages2  = ceil($totale / $perpage2);//jumlah halaman
}


$jumlahling = 2;
if($pageaktif2 > $jumlahling) {
  $start_numbers = $pageaktif2 - $jumlahling;
}else{
  $start_numbers = 1;
}

if($pageaktif2 < ($pages2 - $jumlahling)){
  $end_numbers = $pageaktif2 + $jumlahling;
}else{
  $end_numbers = $pages2;
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

<div class="container">
	 <nav aria-label="breadcrumb" id="bread1">
	  <ol class="breadcrumb" style="background-color: white">
	  	<li class="breadcrumb-item"><a href="kategori.php">Kategori</a></li>
	  	<li class="breadcrumb-item"><a href="satuan.php">Satuan</a></li>
      <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Daftar ATK</li>
	    
	  </ol>
	</nav>
</div>
<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h4 class="card-title  mb-4"><i class="fas fa-briefcase mr-2"></i>Daftar ATK</h4>
                    <!-- fitur pencarian -->
                      <div class="row">
                      <div class="col-auto ml-auto" style="padding-right: 0px;">
                        <form action="" method="post">
                          <input type="hidden" name="keyy" class="form-control" value="">
                           <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" title="Refresh tabel" name="carik" type="button" id="button-addon2"><i class="fas fa-sync-alt"></i></button> 
                        </form>
                      </div>
                     
                     <div class="col-7 col-md-4">
                        <form action="" method="post">
                          <div class="form-group">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="keyy" size="60" placeholder="Masukkan kata kunci.." aria-label="Recipient's username" autofocus autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                              <button type="submit" class="btn btn-outline-secondary" name="carik" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
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
                              <th>Nama ATK</th>
                              <th>Kategori</th>
                              <th>Satuan</th>
                              <th>Harga</th>
                              <th>Stock</th>
                              <th>Aksi</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor=1; ?>
                            <?php if($tools ==!null){ ?>
                             <?php foreach ( $tools as $pecah ): ?>
                            
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $pecah['nama_atk']; ?></td>
                              <td><?php echo $pecah['kategori_atk']; ?></td>
                              <td><?php echo $pecah['satuan']; ?></td>
                              <td><?php echo $pecah['harga']; ?></td>
                               <td><?php echo $pecah['stok']; ?></td>
                              <td><a class="btn btn-sm btn-warning" id="tombolUbah" data-toggle="modal" data-target="#ubahModal" data-id="<?php echo $pecah['id_atk']; ?>" data-nama="<?php echo $pecah['nama_atk']; ?>" data-kat="<?php echo $pecah['kategori_atk']; ?>" data-sat="<?php echo $pecah['satuan']; ?>" data-harga="<?php echo $pecah['harga']; ?>" data-stok="<?php echo $pecah['stok']; ?>" > <i class="fas fa-edit" data-toggle="tooltip" title="Ubah data"></i></a>
                                  <a onclick = "return confirm('apakah anda yakin ingin menghapus data');"class="btn btn-sm btn-danger" href="hapusdataatk.php?id=<?php echo $pecah['id_atk']; ?>"> <i class="fas fa-trash-alt" data-toggle="tooltip" title="Hapus data"></i></a></td>
                            </tr>
                             <?php $nomor++; ?>
                            <?php endforeach;?>
                          </tbody>
                        </table>


                        <!-- awal pagination -->
                        <nav aria-label="Page navigation example">
                          <ul class="pagination justify-content-center">
                            <?php if($pageaktif2 > 1) :?>
                             <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif2 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php else: ?>
                              <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif2 - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php for($i=$start_numbers; $i<= $end_numbers; $i++) {?>
                            <?php  if($i == $pageaktif2): ?>
                            <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>" style="font-weight: bold; color: blue;"><?php echo $i; ?></a></li>
                            <?php else: ?>
                                <li class="page-item mt-3"><a class="page-link" href="?halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endif ?>
                            <?php } ?>
                            <?php if($pageaktif2 == $pages2) :?>
                            <li class="page-item disabled mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif2 + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php  else: ?>
                              <li class="page-item mt-3">
                                <a class="page-link" href="?halaman=<?= $pageaktif2 + 1; ?>" aria-label="Next">
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
                                Pencarian dengan kata kunci <b><?php echo $keyy; ?></b> tidak ditemukan!. Harap mengulangi lagi pencarian dengan kata kunci yang relevan. Untuk mengembalikan tabel daftar barang pakai habis (ATK) silahkan klik tombol refresh tabel disamping kiri kolom pencarian.<button type="button" class="close" data-dismiss="alert" aria-label="Close">
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

<?php   

$datakategori=array();
$ambil = $koneksi->query("SELECT*FROM t_kategori");
while($tiap = $ambil->fetch_assoc())
{
    $datakategori[]=$tiap;
}

$datasatuan=array();
$pilih = $koneksi->query("SELECT*FROM t_satuan");
while($satuann = $pilih->fetch_assoc())
{
    $datasatuan[]=$satuann;
}
?>

<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="ubahModalLabel">Ubah Data ATK</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="close">
                   <span aria-hidden="true" style="font-size: 18px">&times;</span></button>
                 </div>
                 <div class="modal-body">
                   <form role="form" method="post">

                    <input type="hidden" name="id_atk" id="id_atk" class="form-control">

                     <div class="form-group">
                       <label for="nama_atk">Nama ATK</label>
                       <input type="text" class="form-control" name="nama_atk" id="nama_atk">
                      </div>
                      <!-- <div class="form-group">
                       <label for="kategori">Kategori</label>
                       <input type="text" class="form-control" name="kategori" id="kategori">
                      </div> -->
                      <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                          <option>-- Pilih Kategori --</option>
                          <?php   foreach ($datakategori as $key => $value) :?>
                          
                          <option value="<?php echo $value["nama_kategori"]; ?>" <?php if('#kategori'==$value["nama_kategori"]){echo "selected";} ?>>
                            <?php   echo $value["nama_kategori"]; ?></option>
                          <?php   endforeach ?>
                        </select>
                      </div>
                     
                      <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <select class="form-control" name="satuan" id="satuan">
                          <option>-- Pilih Satuan --</option>
                          <?php   foreach ($datasatuan as $key => $val) :?>
                          
                          <option value="<?php echo $val["nama_satuan"]; ?>" <?php if('#satuan'==$val["nama_satuan"]){echo "selected";} ?>>
                            <?php   echo $val["nama_satuan"]; ?></option>
                          <?php   endforeach ?>
                        </select>
                      </div>
                      <div class="form-group">
                       <label for="harga">Harga</label>
                       <input type="text" class="form-control" name="harga" id="harga">
                      </div>
                       <div class="form-group">
                       <label for="stock">Stock</label>
                       <input type="number" class="form-control" name="stock" id="stock" readonly>
                      </div>
                   </div>  
                
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                   <button type="submit" name="ganti" class="btn btn-primary">Ubah</button>

                 </div>
                 </form>

                <?php 


               if (isset($_POST["ganti"]))

                    {
                        $koneksi->query("UPDATE t_barang_atk SET 
                          nama_atk='$_POST[nama_atk]',
                          kategori_atk='$_POST[kategori]',
                          satuan ='$_POST[satuan]',
                          harga ='$_POST[harga]',
                          stok = '$_POST[stock]'
                          WHERE id_atk='$_POST[id_atk]'");
                      echo "<script>alert('Data ATK telah diubah'); </script>";
                      echo "<script>location='list.php'; </script>";
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
      let kat = $(this).data('kat');
      let sat = $(this).data('sat');
      let harga = $(this).data('harga');
      let stock = $(this).data('stok');




      $("#id_atk").val(id);
      $("#nama_atk").val(nama);
      $("#kategori").val(kat);
      $("#satuan").val(sat);
      $("#harga").val(harga);
      $("#stock").val(stock);
  });


</script>

  </body>
</html>