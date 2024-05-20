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
$id_permintaan = $_GET['id'];
$detail=array();
$ambill = $koneksi->query("select * FROM t_permintaan JOIN td_permintaan_atk ON t_permintaan.id_permintaan=td_permintaan_atk.id_permintaan WHERE t_permintaan.id_permintaan='$id_permintaan'");
while($ambil = $ambill ->fetch_assoc())
{
	$detail[]=$ambil;
}

foreach($detail as $key =>  $value){

$tanggal  = $value["tanggal_permintaan"];
$namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
$namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$hari = date('l, j F Y', strtotime($tanggal));
$day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));

$id_bidang = $value["id_bidang"];
$take = $koneksi->query("SELECT*FROM t_bidang WHERE id_bidang = '$id_bidang'");
$bidang = $take->fetch_assoc();
$nama_bidang = $bidang["nama_bidang"];
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
    <title>Detail Permintaan</title>
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
            <h4 class="card-title">Detail Permintaan</h5>
              <div class="container">
              	<div class="row">
              		<div class="col-sm-12 mt-2">
              			<h5 class="card-text text-center"><hr>Daftar Permintaan Barang</h5>
              			<br>
              			<h6 class="card-text"><?php echo $day; ?></h5>
              			<h6 class="card-text">Bidang <?php echo $nama_bidang; ?></h5>
              		</div>
              		<br>
              	</div>
              </div>
               <table class="table table-bordered mt-2">
					<thead>
						<tr>
							<th>No.</th>
							<th>Jenis Barang</th>
							<th>Nama ATK</th>
							<th>Jumlah</th>
              <th>Satuan</th>
							
						</tr>
					</thead>
					<tbody>
						<?php $nomor=1; ?>
						<?php foreach ($detail as $key => $value): ?>
						<tr>
							<td style="width: 10px;"><?php echo $nomor.'. '; ?></td>
							<?php $id_atk = $value['id_atk']; ?>
							<?php $took = $koneksi->query("SELECT*FROM t_barang_atk WHERE id_atk = '$id_atk'") ?>
							<?php $atk = $took->fetch_assoc(); ?>
							<td><?php echo $atk['kategori_atk']; ?></td>
							<td><?php echo $value['nama_atk']; ?></td>
							<td><?php echo $value['jumlah']; ?></td>
              <td><?php echo $value['satuan']; ?></td>
							
						</tr>
						<?php $nomor++; ?>
						<?php endforeach ?>
					</tbody>
				</table>
				<br>	
				<hr>	
				<a class="btn btn-sm btn-info mt-2" href="index1.php"><i class="fas fa-arrow-left"></i> Kembali</a>	
                        
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