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
	    <li class="breadcrumb-item active" aria-current="page">Input Data</li>
	    <li class="breadcrumb-item"><a href="list.php">Daftar ATK</a></li>
	  </ol>
	</nav>
</div>
<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h4 class="card-title mb-4">Input Data ATK</h4>
                   <!--  <p class="card-text">Total ATK Terdaftar</p> -->

                        <form role="form" method="post">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama ATK</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="nama" class="form-control" id="nama" >
                                    </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2" style="margin-left: 7%">
                                <label for="nama">Kategori</label>
                                    </div>
                                  
                                    <div class="col-sm-8" style="margin-left: 8%">
                                          <?php $no=1; ?>
                                        <?php $ambil = $koneksi->query("SELECT*FROM t_kategori"); ?>
                                        <?php  while($kat = $ambil->fetch_assoc()){?>
                                    <div class="form-check form-check-inline mr-5 col-sm-3">
                                        
                                      <input class="form-check-input" type="radio" name="kate" value="<?php echo $kat["nama_kategori"]; ?>">
                                      <label class="form-check-label">
                                        <?php echo $kat["nama_kategori"]; ?>
                                      </label>
                                        
                                    </div>
                                    <?php $no++; ?>
                                        <?php } ?>
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-2" style="margin-left: 7%">
                                <label for="nama">Satuan</label>
                                    </div>
                                  
                                    <div class="col-sm-8" style="margin-left: 8%">
                                          <?php $no=1; ?>
                                        <?php $ambil = $koneksi->query("SELECT*FROM t_satuan"); ?>
                                        <?php  while($sat = $ambil->fetch_assoc()){?>
                                    <div class="form-check form-check-inline mr-5 col-sm-3">
                                        
                                      <input class="form-check-input" type="radio" name="satu" id="inlineRadio.<?php echo $no; ?>" value=" <?php echo $sat["nama_satuan"]; ?>">
                                      <label class="form-check-label" for="inlineRadio.<?php echo $no; ?>">
                                        <?php echo $sat["nama_satuan"]; ?>
                                      </label>
                                        
                                    </div>
                                    <?php $no++; ?>
                                        <?php } ?>
                                </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Harga</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="harga" class="form-control" id="harga" >
                                    </div>
                            </div>
                            
                            
                             <div class="form-group">
                                <label for="nama" class="col-sm-2 col-form-label"></label>
                              <input type="submit" name="input" value="input" id="input" class="btn btn-primary">
                            </div>

                            <?php 
                                if (isset($_POST["input"]))
              {
                //mengambil isi form daftar
                $nama = $_POST["nama"];
                $kate = $_POST["kate"];
                $satu = $_POST["satu"];
                $harga = $_POST["harga"];
               

                //cek apakah email sudah digunakan
                $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE nama_atk ='$nama'");
                $yangcocok = $ambil->num_rows;
                if ($yangcocok==1)
                {
                  echo "<script>alert('Input data gagal!, nama ATK telah digunakan ');</script>";
                  echo "<script>location='inputdata.php';</script>";
                }
                else
                {
                  //query insert ke tabel pelanggan
                  $koneksi->query("INSERT INTO t_barang_atk (nama_atk,kategori_atk,satuan,harga) 
                    VALUES ('$nama','$kate','$satu','$harga')");
                  echo "<script>alert('input data sukses!');</script>";
                  echo "<script>location='list.php';</script>";
                }

              }
                             
                             ?>
                          
                        </form>
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