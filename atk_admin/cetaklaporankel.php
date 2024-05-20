<?php
use Mpdf\Mpdf;
require_once __DIR__ . '/vendor/autoload.php';

include 'koneksi.php'; 

$table = $_GET['table'];
$name = $_GET['target'];
$tgl_mulai = $_GET['tglmulai'];
$tgl_selesai = $_GET['tglselesai'];

$semuadata=array();
 $ambil = $koneksi->query("SELECT * FROM ".$table." WHERE tanggal_".$name." BETWEEN '$tgl_mulai' AND '$tgl_selesai'");

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


  while ($pecah = $ambil->fetch_assoc())
  {
    $semuadata[]=$pecah;
  }

foreach($semuadata as $key =>  $value){

  $tanggal  = $value["tanggal_keluar"];
  $namaHari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
  $namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
  $hari = date('l, j F Y', strtotime($tanggal));
  $day = $namaHari[date('N',strtotime($tanggal))] . ", " . date('j',strtotime($tanggal)) . " " . $namaBulan[(date('n',strtotime($tanggal))-1)] . " " . date('Y',strtotime($tanggal));

}

$mpdf = new \Mpdf\Mpdf();

$html = '<bookmark content="Start of the Document" />

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Laporan Barang Keluar</title>
	<link rel="stylesheet" type="text/css" href="cetak.css">
</head>
<body>
		<div class="container">
			<div id="head">
			<img src="img1/logokab.png">
			</div>
			 <div id="head1">
                <p>PEMERINTAH KABUPATEN SERANG</p>
                <p class="besar"><b>BADAN PERENCANAAN PEMBANGUNAN DAERAH</b></p>
                <h3>(BAPPEDA)</h3>
                <p class="kecil">JLN. VETERAN NOMOR 1 TELEPON 200252 - 203135 SERANG</p>
                <p class="kecil">e-mail : <u>bappeda@serang.go.id,</u>  <u>http://www.serang.go.id</u></p>
             </div>
			
		
		</div>



		<div class="konten" style="margin-bottom: 10px;">
			<h4 style="text-align: center; font-family: serif; font-weight: none; border-bottom: 5px;">Laporan Barang Keluar<br>
			tanggal '.$mulai.' s.d '.$selesai.'</h4>
		</div>';

	
    
		$html.='<table border="1" cellpadding="10" cellspacing="0" style="margin-top: 15px;">
					<thead>
						<tr>
							  <th>No.</th>
                              <th>ID Transaksi</th>
                              <th>Tanggal</th>
                              <th>ID Barang</th>
                              <th>Nama Barang</th>
                              <th>Jumlah Keluar</th>
						</tr>

					</thead>
					<tbody>';
					$i=1;
					foreach($semuadata as $key => $value){
						$nomor = 1;
						 $id_atk = $value["id_atk"];
						 $take = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
						 $atk = $take->fetch_assoc();
						$html.= '<tr>
								<td>'. $i++.'</td>
								<td>'. $value["id_barang_keluar"].'</td>
								<td>'. $day.'</td>
								<td>'. $value["id_atk"].'</td>
								<td>'. $atk["nama_atk"].'</td>
								<td>'.$value["jumlah_keluar"].' '.$atk["satuan"].'</td>
								
						</tr>';
							
					}

	$html .='</tbody>
			</table>

					
</body>
</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('laporan_barang_keluar.pdf','I');







?>