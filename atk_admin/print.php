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
			<img src="img1/logo_kab_serang.png">
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
			SERAH TERIMA BARANG PAKAI HABIS
		</h4>
	</div>
	<h4 style="text-align: center; font-family: serif; font-weight: none; border-bottom: 5px; margin-top: 3px;">NOMOR : 027 /&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/ Bapp / '.date('Y',strtotime($tanggal)).'</h4>
	<div class="text-konten">
		<p>Pada hari ini '.$hari[date('N')] .' tanggal '.date('j').' bulan '.$bulan[(date('n')-1)] .' tahun '.date('Y').' yang bertanda tangan dibawah ini :</p>
		<p>1. &nbsp;&nbsp;&nbsp;
				<ul>
				  <li>Nama Lengkap&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;Faroji</li>
				  <li>Jabatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;Penyimpan Barang</li>
				  <li>Pangkat/Gol&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; :&nbsp;&nbsp;Pengatur Muda Tk.I.&nbsp;&nbsp;II/a</li>
			    </ul>
		</p>
		<p>Yang dengan Surat Keputusan Sekretaris Daerah Kabupaten Serang Nomor: 030 / Kep. 63 - Huk / 2019 Tanggal Januari 2019 ditugaskan sebagai Pengurus /Penyimpan Barang Pada Badan Perencanaan Pembangunan Daerah Kabupaten Serang.</p>  
			 
	</div>
		';

		

	// $html .='<p id="sedang">Hari/Tanggal : '.$day.'<br>
 //        	Bidang : '. $bidang["nama_bidang"].'</p>';
    
		$html.='<table border="1" cellpadding="8" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>Jenis Barang</th>
							<th>Merek</th>
							<th>Vol.</th>
              				<th>Satuan</th>
							<th>  Digunakan  </th>
							<th>  Keterangan  </th>
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
								<td></td>
								<td></td>
						</tr>';
							$total += $value["subharga"];
					}

	$html .='</tbody>
			</table>
			<div class="btw">
				<p>Demikian berita Acara Pengeluaran ini dibuat, untuk dipergunakan sebagai mana mestinya</p>
			</div>
		<div class="container-noborder">
			<div id="kiri">
				<p>Yang Mengeluarkan<br>Penyimpan Barang</p>
			</div>
			<div id="kanan">
				<p>Yang Menerima</p>
			</div>

		</div>
					
</body>
</html>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('daftar_permintaan_atk.pdf','I');
