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
$ambil = $koneksi->query("SELECT*FROM t_bidang WHERE id_bidang ='$id_bidang'");
$bidang = $ambil->fetch_assoc();


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
    <title>Detail Permintaan</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->


<?php include 'menu.php'; ?>

<section class="konten">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12 mt-3">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Detail Permintaan</h5>
              <div class="container">
              	<div class="row">
              		<div class="col-sm-12 col-md-12 mt-2">
              			<h5 class="card-text text-center"><hr>Daftar Permintaan Barang</h5>
              			<br>
              			<h6 class="card-text"><?php echo $day; ?></h5>
              			<h6 class="card-text">Bidang <?php echo $bidang["nama_bidang"]; ?></h5>
              		</div>
              		<br>
              	</div>
              </div>
               <table class="table table-bordered mt-3">
					<thead>
						<tr>
							<th>No</th>
							<th>Jenis Barang</th>
							<th>Nama ATK</th>
							<th>Jumlah</th>
              <th>Satuan</th>
							<th>Harga</th>
							<th>Subtotal</th>
						</tr>
					</thead>
					<tbody>
            <?php $total=0; ?>
						<?php $nomor=1; ?>
						<?php foreach ($detail as $key => $value): ?>
            <?php
              $id_atk = $value['id_atk'];
              $jumla = $value['jumlah'];
              $take = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
              $atk = $take->fetch_assoc();
              $subharga = $atk["harga"]*$jumla;
             ?>
						<tr>
							<td><?php echo $nomor; ?></td>
							<td><?php echo $atk['kategori_atk']; ?></td>
							<td><?php echo $value['nama_atk']; ?></td>
							<td><?php echo $value['jumlah']; ?></td>
              <td><?php echo $value['satuan']; ?></td>
							<td> Rp. <?php echo number_format($value['harga']); ?></td>
							<td>
								Rp. <?php echo number_format($subharga);?>
							</td>
						</tr>
						<?php $nomor++; ?>
            <?php $total += $subharga  ?>
						<?php endforeach ?>
					</tbody>
          <tfoot>
        <tr>
          <th class="text-center" colspan="6">Total</th>
          <th>Rp. <?php echo number_format($total) ?></th>
        </tr>
      </tfoot>
				</table>
				<br>	
				<hr>	
				<a class="btn btn-sm btn-info mt-2" href="dashboard.php"><i class="fas fa-arrow-left"></i> Kembali</a>	
                        
          </div>
        </div>
      </div>
  </div>
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