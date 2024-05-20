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

$dataatk=array();
$ambil = $koneksi->query("SELECT*FROM t_barang_atk");
while($tiap = $ambil->fetch_assoc())
{
    $dataatk[]=$tiap;
}

// mengambil data barang dengan kode paling besar
$query = mysqli_query($koneksi, "SELECT max(id_barang_masuk) as idTerbesar FROM t_barang_masuk");
$data = mysqli_fetch_array($query);
$kodeBarang = $data['idTerbesar'];
 
// mengambil angka dari kode barang terbesar, menggunakan fungsi substr
// dan diubah ke integer dengan (int)
$urutan = (int) substr($kodeBarang, 8, 4);
 
// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
$urutan++;
//Mengambil data tahun sekarang
 date_default_timezone_set('Asia/Jakarta');
    $year = date('Y');
    $today = date("y-m-d");
// membentuk kode barang baru
// perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
// misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
$huruf = "TM-";
$kodbarmas = $huruf . $year ."-" . sprintf("%04s", $urutan);

 


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

<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h5 class="card-title">Input Data ATK Masuk</h5>
                   <!--  <p class="card-text">Total ATK Terdaftar</p> -->

                        <form role="form" method="post">
                            <div class="form-group row mt-5">
                                <label for="id_trans" class="col-sm-2 col-form-label">ID Transaksi</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="id_trans" class="form-control" id="id_trans" value="<?php echo $kodbarmas; ?>" readonly>
                                    </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="tanggal" class="form-control" id="tanggal" value="<?php echo $today;?>" readonly>
                                    </div>
                            </div>
                            <hr>

                            <div class="form-group mt-4">
                                <div class="row">
                                    <div class="col-sm-2" style="margin-left: 7%">
                                        <label for="nama">Barang (ATK)</label>
                                    </div>
                                  
                                    <div class="col-sm-7" style="margin-left: 11px;">
                                       <select class="form-control" name="id_atk" id="id_atk" onchange='changeValue(this.value)'required>
                                          <option selected disabled value="">-- Pilih Barang --</option>
                                          <?php 
                                               $a          = "var stok = new Array();\n;";  
                                               $b          = "var satuan = new Array();\n;";  
                                           ?>
                                          <?php   foreach ($dataatk as $key => $value) :?>
                                          
                                          <option name="barang" value="<?php echo $value['id_atk']; ?>"><?php  echo $value["nama_atk"]; ?></option>
                                          <?php
                                           $a .= "stok['" . $value['id_atk'] . "'] = {stok:'" . addslashes($value['stok'])."'};\n";  
                                           $b .= "satuan['" . $value['id_atk'] . "'] = {satuan:'" . addslashes($value['satuan'])."'};\n"; 
                                            ?>
                                          <?php   endforeach ?>
                                        </select>
                                </div>
                                </div>
                            </div>
                             <div class="form-group mt-4">
                              <div class="row">
                                <label for="stok" class="col-sm-2 col-form-label">Stock</label>
                                    <div class="col-sm-7">
                                         <div class="input-group mb-2 mr-sm-2 ">
                                              <input type="text" class="form-control" name="stok" id="stok" placeholder="" onkeyup="sum();" readonly>
                                               <div class="input-group-prepend">
                                                <input class="input-group-text bg-white" id="satuan" name="satuan" readonly>
                                              </div>
                                         </div>
                                    </div>
                            </div>
                          </div>
                            <div class="form-group row">
                                <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Masuk</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="jumlah" class="form-control" id="jumlah" onkeyup="sum();" required>
                                    </div>
                            </div>
                             <div class="form-group row">
                                <label for="total" class="col-sm-2 col-form-label">Total Stok</label>
                                    <div class="col-sm-7">
                                        <input type="number" name="total" class="form-control" id="total" readonly>
                                    </div>
                            </div>
                            
                             <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label"></label>
                              <input type="submit" name="simpan" value="Simpan" id="simpan" class="btn btn-primary mr-3 tombol" style="width: 100px; margin-left: 15px">
                              <a href="barmas.php" class="btn btn-secondary" style="width: 100px;">Batal</a>
                            </div>

                            <?php 
                                if (isset($_POST["simpan"]))
                                {
                                  //mengambil isi form daftar
                                  $id_trans = $_POST["id_trans"];
                                  $tanggal = $_POST["tanggal"];
                                  $id_atk = $_POST["id_atk"];
                                  $jumlah = $_POST["jumlah"];
                                  $stok = $_POST["stok"];
                                  $total = $_POST["total"];

                                  //cek apakah email sudah digunakan
                                  $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
                                  $setup = $ambil->fetch_assoc();
                                  $nama = $setup["nama_atk"];

                                    //query insert ke tabel barangmasuk
                                    $koneksi->query("INSERT INTO t_barang_masuk (id_barang_masuk,tanggal_masuk,id_atk,nama_atk,jumlah_masuk)
                                      VALUES ('$id_trans','$tanggal','$id_atk','$nama','$jumlah')");

                                    $koneksi->query("UPDATE t_barang_atk SET 
                                            stok ='$total'
                                           WHERE id_atk='$id_atk'");
                                        

                                    echo "<script>alert('input data barang masuk sukses!');</script>";
                                    echo "<script>location='barmas.php';</script>";
                                  }

              
                                 if (isset($_POST["batal"]))
                                {
                                   echo "<script>location='barmas.php';</script>";
                                }

                             ?>
                          
                        </form>
                  </div>
        </div>
            </div>      
        </div>
    </div>     
</section>
          <script type="text/javascript">   
              <?php   
              echo $a;   
              echo $b; ?>  
              function changeValue(id){  
                document.getElementById('stok').value = stok[id].stok;  
                document.getElementById('satuan').value = satuan[id].satuan;  
              };  
          </script>  

          <script>
              function sum() {
                    var txtFirstNumberValue = document.getElementById('stok').value;
                    var txtSecondNumberValue = document.getElementById('jumlah').value;
                    var result = parseFloat(txtFirstNumberValue) + parseFloat(txtSecondNumberValue);
                    if (!isNaN(result)) {
                       document.getElementById('total').value = result;
                    }
              }
          </script>

<script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
  </body>
</html>