<?php 

include 'koneksi.php';
function queny($query) {
	global $koneksi;

	$result = mysqli_query($koneksi,$query);
	$rows=array();
	while ($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}


$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_barang_masuk");
$total  = mysqli_num_rows($result);//jumlah data

$pages  = ceil($total / $perpage);//jumlah halaman

$jumlahlink = 2;
if($pageaktif > $jumlahlink) {
  $start_number = $pageaktif - $jumlahlink;
}else{
  $start_number = 1;
}

if($pageaktif < ($pages - $jumlahlink)){
  $end_number = $pageaktif + $jumlahlink;
}else{
  $end_number = $pages;
}


function carina($kword){

global $start;
global $perpage;

	$query = "SELECT * FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk 
				WHERE 
		id_barang_masuk LIKE '%$kword%' OR 
		tanggal_masuk LIKE '%$kword%' OR
		id_atk LIKE '%$kword%' OR
		nama_atk LIKE '%$kword%' OR
		jumlah_masuk LIKE '%$kword%'



	ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start, $perpage";

	return queny($query);
}

?>