<?php
use Mpdf\Mpdf;
require_once __DIR__ . '/vendor/autoload.php';

include 'koneksi.php'; 


$katakun = $_GET['katakun'];
$detail=array();
if(!isset($_GET["katakun"])){
$ambill = $koneksi->query("SELECT * FROM t_barang_atk");

}else{

	 $ambill = mysqli_query($koneksi,"SELECT*FROM t_barang_atk WHERE
      nama_atk LIKE '%$katakun%' OR 
      kategori_atk LIKE '%$katakun%' OR
      satuan LIKE '%$katakun%' OR
      harga LIKE '%$katakun%' OR
      stok LIKE '%$katakun%'");

}

while($ambil = $ambill ->fetch_assoc())
	{
		$detail[]=$ambil;
	}

foreach($detail as $key =>  $value){


 date_default_timezone_set('Asia/Jakarta');
    $hari = array("Ahad", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu","Minggu");
    $bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $nowaday = date('l, F, j, Y');
    $sekarang = $hari[date('N')] . ", " . date('j') . " " . $bulan[(date('n')-1)] . " " . date('Y');

$id_bidang = $value["id_bidang"];
$ambil = $koneksi->query("SELECT*FROM t_bidang WHERE id_bidang ='$id_bidang'");
$bidang = $ambil->fetch_assoc();

}
$spasi = "     ";

$mpdf = new \Mpdf\Mpdf();

$html = '<bookmark content="Start of the Document" />

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Daftar Permintaan ATK</title>
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
		


	<div class="konten">
		<h4 style="text-align: center; font-family: serif; font-weight: none; border-bottom: 5px; ">
			BERITA ACARA<br>
			LAPORAN STOK BARANG PAKAI HABIS (ATK)
		</h4>
	</div>
	<h4 style="text-align: center; font-family: serif; font-weight: none; border-bottom: 5px; margin-top: 3px;">NOMOR : 027 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ Bapp / '.date('Y').'</h4>
	
		';

		

	// $html .='<p id="sedang">Hari/Tanggal : '.$day.'<br>
 //        	Bidang : '. $bidang["nama_bidang"].'</p>';
    
		$html.='<table border="1" cellpadding="8" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>ID Barang</th>
							<th>Jenis Barang</th>
							<th>Merek</th>
              				<th>Stok</th>
							<th>Satuan</th>
							
						</tr>

					</thead>
					<tbody>';
					$i=1;
					foreach($detail as $key => $value){
						$nomor = 1;
						 
						$html.= '<tr>
								<td>'. $i++.'</td>
								<td>'. $value["id_atk"].'</td>
								<td>'. $value["kategori_atk"].'</td>
								<td>'. $value["nama_atk"].'</td>
								<td>'. $value["stok"].'</td>
								<td>'. $value["satuan"].'</td>
							
						</tr>';
							
					}

	$html .='</tbody>
			</table>
			<div class="btw">
				<p>Demikian berita Acara Laporan Stok Barang ini dibuat, untuk dipergunakan sebagai mana mestinya</p>
			</div>
		
					
</body>
</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_Stok_Barang_atk.pdf','I');
