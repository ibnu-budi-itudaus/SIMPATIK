<?php
use Mpdf\Mpdf;
require_once __DIR__ . '/vendor/autoload.php';

include 'koneksi.php'; 


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
		



		<h3 style="text-align: center; font-family: serif;">Permintaan Barang Pakai Habis (ATK)</h3><br>';

		

	$html .='<p id="sedang">Hari/Tanggal : '.$day.'<br>
        	Bidang : '. $bidang["nama_bidang"].'</p>';
    
		$html.='<table border="1" cellpadding="10" cellspacing="0">
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
					<tbody>';
					$i=1;
					foreach($detail as $key => $value){
						$nomor = 1;
						 $id_atk = $value["id_atk"];
						 $take = $koneksi->query("SELECT * FROM t_barang_atk WHERE id_atk='$id_atk'");
						 $atk = $take->fetch_assoc();
						$html.= '<tr>
								<td>'. $i++.'</td>
								<td>'. $atk["kategori_atk"].'</td>
								<td>'. $value["nama_atk"].'</td>
								<td>'. $value["jumlah"].'</td>
								<td>'. $value["satuan"].'</td>
								<td>'.'Rp. '.number_format($value["harga"]).'</td>
								<td>'.'Rp. '.number_format($value["subharga"]).'</td>
						</tr>';
							$total += $value["subharga"];
					}

	$html .='</tbody>
			<tfoot>
				<tr>
		          <th colspan="6">Total</th>
		          <th>'.'Rp. '.number_format($total).'</th>
		        </tr>
      		</tfoot>
			</table>

					
</body>
</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('daftar_permintaan_atk.pdf','I');







?>

