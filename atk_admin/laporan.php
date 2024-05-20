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

$semuadata=array();
$tgl_mulai="-";
$tgl_selesai="-";
$table="";
// $barmas = queryy("SELECT*FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start, $perpage");

if(isset($_POST["kirim"]))
{
  
  $table = $_POST["laporan"];
  $total = strlen($table);//jumlah data
  $sisa = $total - 9;
  $name = substr($table, 9, $sisa);
  $tgl_mulai = $_POST["tglmul"];
  $tgl_selesai = $_POST["tglsel"];
  $ambil = $koneksi->query("SELECT * FROM ".$table." WHERE tanggal_".$name." BETWEEN '$tgl_mulai' AND '$tgl_selesai'");

  while ($pecah = $ambil->fetch_assoc())
  {
    $semuadata[]=$pecah;
  }
 $tanggal  = $tgl_mulai;
  $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
  $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $hari = date('l, j F Y', strtotime($tanggal));
  $mulai = date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));

  $tggl  = $tgl_selesai;
  $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
  $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $hari = date('l, j F Y', strtotime($tggl));
  $selesai = date('j',strtotime($tggl)) . " " . $namaBulan[(date('n',strtotime($tggl))-1)] . " " . date('Y',strtotime($tggl));
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

<?php include 'menu.php'; ?>

<section class="konten">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <h4 class="card-title"><i class="fas fa-file-alt mr-2"></i>Laporan Barang Pakai Habis (ATK)</h4>
    
                    <hr> 
                    <form method="post">
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <label>Laporan</label>
                            <select class="form-control" name="laporan" required>
                              <option selected disabled value="">-- Pilih Jenis Laporan --</option>
                              <option value="t_barang_masuk">Data Barang Masuk</option>
                              <option value="t_barang_keluar">Data Barang Keluar</option>
                            </select>
                          </div>
                        </div>
                      </div>  
                      <div class="row"> 
                        <div class="col-md-5">
                          <div class="form-group">  
                            <label>Tanggal Mulai</label>
                            <input type="date" class="form-control" name="tglmul" value="$tgl_mulai" required>
                          </div>  
                        </div>  
                        <div class="col-md-5">
                          <div class="form-group">  
                            <label>Tanggal Selesai</label>
                            <input type="date" class="form-control" name="tglsel" value="$tgl_selesai" required>
                          </div>  
                        </div>  
                          
                        <div class="col-md-2">Tombol
                          <label>&nbsp;</label><br> 
                          <button class="btn btn-primary" name="kirim"><i class="fas fa-search" data-toggle="tooltip" title="print"></i> Lihat</button>
                        </div>
                      </div>

                    </form>
                    

                   
                       
                  </div>
        </div>
            </div>      
        </div>
<?php if($table==!null): ?>
    <?php if($table=="t_barang_masuk"): ?>
        <div class="row">
            <div class="col-sm-12 mt-4">
                <div class="card" style="border : 0">
                  <div class="card-body">
                    <!-- <h3 class="card-title">Laporan Barang Pakai Habis (ATK)</h3> -->
 
                   <div class="kontenlap">
                     
                        <h5 style="text-align: center; border-bottom: 2px;">Laporan Barang Masuk<br>Dari <?php echo $mulai; ?> Hingga <?php echo $selesai; ?></h5>
                      
                    </div>
                     <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No.</th>
                              <th>ID Transaksi</th>
                              <th>Tanggal</th>
                              <th>ID Barang</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Masuk</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                            <?php $nomor=1; ?>
                            
                            <?php foreach ( $semuadata as $atk ): ?>
                            <?php
                              $tanggal  = $atk["tanggal_masuk"];
                              $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                              $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                              $hari = date('l, j F Y', strtotime($tanggal));
                              $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
                             ?>
                            <tr>
                              <td><?php echo $nomor; ?></td>
                              <td><?php echo $atk["id_barang_masuk"];?></td>
                              <td><?php echo $day;?></td>
                              <td><?php echo $atk["id_atk"];?></td>
                              <?php $id_atk = $atk["id_atk"];?>
                              <?php $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk = '$id_atk'") ?>
                              <?php $take = $ambil->fetch_assoc(); ?>
                              <td><?php echo $take["nama_atk"];?></td>
                              <td><?php echo $atk["jumlah_masuk"];?> <?php echo $take["satuan"]; ?></td> 
                            </tr>
                             <?php $nomor++; ?>
                             <?php endforeach; ?>
                          </tbody>
                        </table>
                         <div class="row">
                          <div class="col-md-12 text-right">
                            <a class="btn btn-md btn-info" href="cetaklaporan.php?table=<?php echo $table;?>&target=<?php echo  $name;?>&tglmulai=<?php echo $tgl_mulai;?>&tglselesai=<?php echo $tgl_selesai;?>" style="margin-right: 70px;"target="_BLANK"> <i class="fas fa-print" data-toggle="tooltip" title="print"></i> Cetak</a> 
                          </div>
                         </div>
                        <?php elseif($table=="t_barang_keluar"):?>
                           <div class="row">
                            <div class="col-sm-12 mt-4">
                                <div class="card" style="border : 0">
                                  <div class="card-body">
                           <caption><h5 style="text-align: center;">Laporan Barang Keluar</h5></caption>
                           <h5 style="text-align: center;">Dari <?php echo $tgl_mulai; ?> Hingga <?php echo $tgl_selesai; ?></h5>
                           <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>No.</th>
                                    <th>ID Transaksi</th>
                                    <th>Tanggal</th>
                                    <th>ID Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah keluar</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $nomor=1; ?>
                                  
                                  <?php foreach ( $semuadata as $atk ): ?>
                                  <?php
                                    $tanggal  = $atk["tanggal_keluar"];
                                    $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                                    $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                    $hari = date('l, j F Y', strtotime($tanggal));
                                    $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));
                                   ?>
                                  <tr>
                                    <td><?php echo $nomor; ?></td>
                                    <td><?php echo $atk["id_barang_keluar"];?></td>
                                    <td><?php echo $day;?></td>
                                    <td><?php echo $atk["id_atk"];?></td>
                                    <?php $id_atk = $atk["id_atk"];?>
                                    <?php $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk = '$id_atk'") ?>
                                    <?php $take = $ambil->fetch_assoc(); ?>
                                    <td><?php echo $take["nama_atk"];?></td>
                                    <td><?php echo $atk["jumlah_keluar"];?></td> 
                                  </tr>
                                   <?php $nomor++; ?>
                                   <?php endforeach; ?>
                                </tbody>
                              </table>
                               <div class="row">
                                <div class="col-md-12 text-right">
                                  <a class="btn btn-md btn-info" href="cetaklaporankel.php?table=<?php echo $table;?>&target=<?php echo  $name;?>&tglmulai=<?php echo $tgl_mulai;?>&tglselesai=<?php echo $tgl_selesai;?>" style="margin-right: 70px;"target="_BLANK"> <i class="fas fa-print" data-toggle="tooltip" title="print"></i> Cetak</a> 
                                </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>

                            <?php else: ?>
                               <div class="row">
                                  <div class="col-sm-12 mt-4">
                                      <div class="card" style="border : 0">
                                        <div class="card-body">
                               <caption><h5 style="text-align: center;">Laporan Stok Barang</h5></caption>
                               <h5 style="text-align: center;">Dari <?php echo $tgl_mulai; ?> Hingga <?php echo $tgl_selesai; ?></h5>
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th>ID Barang</th>
                                        <th>Jenis Barang</th>
                                        <th>Nama Barang</th>
                                        <th>stok</th>
                                        <th>Satuan Barang</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php $nomor=1; ?>
                                      
                                      <?php foreach ( $semuadata as $atk ): ?>
                                      <?php
                                        $tanggal  = $atk["tanggal_masuk"];
                                        $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
                                        $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                        $hari = date('l, j F Y', strtotime($tanggal));
                                        $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));

                                        $id_atk = $atk["id_atk"];
                                        $ambil = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
                                        $take = $ambil->fetch_assoc();
                                       ?>
                                      <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo $atk["id_atk"];?></td>
                                        <td><?php echo $take["kategori_atk"];?></td>
                                        <td><?php echo $take["nama_atk"];?></td>
                                        <td><?php echo $atk["stok"];?></td>
                                        <td><?php echo $atk["satuan_barang"];?></td>  
                                      </tr>
                                       <?php $nomor++; ?>
                                       <?php endforeach; ?>
                                    </tbody>
                                  </table>
                                   <div class="row">
                                      <div class="col-md-12 text-right">
                                        <a class="btn btn-md btn-info" href="cetaklaporan.php?table=<?php echo $table;?>&target=<?php echo  $name;?>&tglmulai=<?php echo $tgl_mulai;?>&tglselesai=<?php echo $tgl_selesai;?>" style="margin-right: 70px;"target="_BLANK"> <i class="fas fa-print" data-toggle="tooltip" title="print"></i> Cetak</a> 
                                      </div>
                                     </div>
                             
                  
                       
                  </div>
        </div>
            </div>      
        </div>
         <?php endif; ?>
                            <?php else: ?>
                              

                            <?php endif; ?>


    </div>
</section>

 

<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
   <script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
  </body>
</html>