<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

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
    <title>Permintaan ATK</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

   
<?php include 'menu1.php'; ?>

<section class="konten">
  <div class="container">
   <div class="row">
      <div class="col-sm-2 mb-3 mt-2">
        <div class="card" style="border : 0">
          <div class="card-body">
             <h5 class="card-title">Kategori ATK</h5>
             <form role="form" method="post">
              <?php $ambil = $koneksi->query("SELECT*FROM t_kategori") ;?>
              <?php while($kat = $ambil->fetch_assoc()){ ?>
             <div class="form-check">
              <a href="permintaan.php?id=<?php echo $kat["nama_kategori"]; ?>""><input class="form-check-input" type="radio" name="kate" id="kate" value="<?php echo $kat["nama_kategori"]; ?>" ></a>
              <label class="form-check-label" for="kate">
                <?php echo $kat["nama_kategori"]; ?>
              </label>
            </div>
          <?php } ?>
               <div class="form-group">
                  <input type="submit" name="input" value="pilih" class="btn btn-primary btn-sm btn-block mt-3">
                </div>
            </form>

          </div>
        </div>
      </div>
      <div class="col-sm-5 mb-3 mt-2" id="atk">
          <div class="card" style="border : 0">
            <div class="card-body">
              <h5 class="card-title">Nama ATK</h5>
              <!-- <p class="card-text">Total Permintaan</p> -->
              <table class="table">
                <thead>
                  <tr style="background-color: #ADD8E6">
                    <th>Nama ATK</th>
                    <th style="width: 140px;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($_POST["input"])){?>
                    <script>location='#atk';</script>
                  <?php   unset($_SESSION['atk']); ?>
                  <?php $ambil = $koneksi->query("SELECT*FROM t_barang_atk WHERE kategori_atk = '$_POST[kate]'"); ?>
                  <?php while($atk = $ambil->fetch_assoc()){ 
                          $id_atuk = $atk["id_atk"];
                          $nama_atuk = $atk["nama_atk"];
                          $_SESSION["atk"][$id_atuk] = $nama_atuk;
                        }
                    ?>
                  <?php } ?>

                  <?php   if(!empty($_SESSION['atk'])): ?>
                  <?php foreach ($_SESSION["atk"] as $id_atuk => $nama_atuk): ?>
                    <?php 
                  $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atuk'");
                  $atuk = $ambil->fetch_assoc();
                  
                   ?>
                  
                  <tr>
                    <td><?php echo $atuk["nama_atk"] ?></td>
                    <td>
                     <form role="form"method="post" action='co_permintaan.php'>
                      <div class="form-group">
                        <input type="hidden" name="id_atk" id="id_atk" value="<?php echo $atuk["id_atk"] ?>" class="form-control">

                        <div class="input-group">
                          <input style="width : 3px; height: 30px;" type="number" min="1" max="<?php echo $atuk["stok"]; ?>" class="form-control" name="jumla">
                          <div class="input-group-btn ml-2">
                            <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" title="ambil ini" name="ambil"><i class="fas fa-plus"></i></button>
                          </div>
                        </div>
                      </div>
                    </form>
                    
                    
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php  endif ?>
              




                </tbody>
              </table>
               
            </div>
          </div>
        </div>
        
        
      <div class="col-sm-5 mb-3 mt-2" id="permintaan">
        <div class="card" style="border : 0">
            <div class="card-body">
              <h5 class="card-title">Permintaan</h5>
              <!-- <p class="card-text">Total Permintaan</p> -->
              <div class="table-responsive"> 
              <table class="table">
                <thead>
                  <tr  style="background-color: #ADD8E6">
                    <th>Nama ATK</th>
                    <th>Satuan</th>
                    <th>Qty.</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($_SESSION['permintaan'])): ?>
                   <script>location='#permintaan';</script>
                  <?php $totalbeli=0; ?>
                  <?php $nomor = 1; ?>
                  <?php foreach ($_SESSION["permintaan"] as $id_atk => $jumla): ?>
                  <!-- menampilkan produk yang sedang diperulangkan berdasarkan id produk -->
                  <?php 
                  $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
                  $pecah = $ambil->fetch_assoc();
                  $subharga = $pecah["harga"]*$jumla;
                   ?>
                  <tr>
                    <td><?php echo $pecah["nama_atk"]; ?></td>
                    <td><?php echo $pecah["satuan"]; ?></td>
                     <td><?php echo $jumla; ?></td>
                     <td><a href="hapuspermintaan.php?id=<?php echo $id_atk; ?>" class="btn btn-danger btn-sm"  data-toggle="tooltip" title="Hapus data"><i class="fas fa-trash-alt"></i></a></td>
                  </tr>
                  <?php $totalbeli+=$subharga; ?>

                <?php endforeach ?>
                <?php endif ?>

                </tbody>
              </table>
              </div>

                <form method="post" role="form">
                   <?php if(empty($_SESSION["permintaan"])):?>
                      <div class="form-group">
                    <input type="hidden" name="kirim" style="width: 50%; height: 10px;" class="form-control">
                    </div>
                  <?php else: ?>
                    <div class="form-group">
                    <input type="submit" style="width: 50%; margin-left: 95px;" name="kirim" value="submit permintaan" class="btn btn-success btn-sm btn-block mt-3">
                    </div>
                  <?php endif ?>
                </form>
                
                <?php 
                  if(isset($_POST["kirim"]))
                  {
                    $id_bidang = $_SESSION["bidang"]["id_bidang"];
                    $id_atk = $pecah["id_atk"];
                    $tanggal_permintaan = date ("y-m-d");
                    $satuan = $pecah["satuan"];
                    $total_harga = $totalbeli;


                    //1. menyimpan data ke tabel pembelian
                    $koneksi->query("INSERT INTO t_permintaan(id_bidang,id_atk,tanggal_permintaan,total_harga) 
                      VALUES ('$id_bidang','$id_atk','$tanggal_permintaan','$total_harga')");

                    //mendapatkan id pembelian yg baru saja terjadi
                    $id_permintaan_barusan = $koneksi->insert_id;

                    foreach($_SESSION["permintaan"] as $id_atk => $jumla)
                    {
                      
                      //mendapatkan data produk berdasarkan id_produk
                      $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
                      $perproduk = $ambil->fetch_assoc();

                       /*stock - jumlah. Namun anehnya --> $stock = $perproduk['stock'] - $jumlah; hasilnya (- x), karena hasilnya (-x) maka saya kalikan lagi dgn (-1) agar didapatkan hasil angka/jumlah yg positif (+x)*/
                      $stok = $perproduk['stok'] - $jumla;
                      // $stok = $stock*-1;

                      $nama = $perproduk['nama_atk'];
                      $harga = $perproduk['harga'];
                      $satuan = $perproduk['satuan'];
                      $subharga = $perproduk['harga'] * $jumla;
                      $koneksi->query("INSERT INTO td_permintaan_atk (id_permintaan,id_atk,nama_atk,satuan,harga,jumlah,subharga)
                        VALUES ('$id_permintaan_barusan','$id_atk','$nama','$satuan','$harga','$jumla','$subharga')");
                      // script untuk update stock yang telah dikurangi dgn jumlah yg dibeli
                      // $koneksi->query("UPDATE t_barang_atk SET stok = '$stok' WHERE id_atk = '$id_atk'");
                    }

                    //mengosongkan permintaan
                    unset($_SESSION["permintaan"]);
                    unset($_SESSION["atk"]);



                    //tampilan dialihkan ke halaman riwayat permintaan
                    echo "<script>alert('permintaan telah dikirim');</script>";
                    echo "<script>location='riwayat_permintaan.php?id=$id_permintaan_barusan';</script>";

                  }   

                 ?>
                
                    
                  
                </div>
            </div>
          </div>
      </div>
  </div>

  </div>
</section>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
   <script type="text/javascript" src="atk_admin/admin.js"></script>
     <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="assets/bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>
  </body>
</html>
