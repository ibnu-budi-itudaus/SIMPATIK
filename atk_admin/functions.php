<?php 


	$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'data_atk';
	$koneksi = mysqli_connect($host, $username, $password, $database);
	if(!$koneksi){
		die("error bro". mysqli_connect_error());
	}

function queryy($query) {
	global $koneksi;

	$result = mysqli_query($koneksi,$query);
	$rows=[];
	while ($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}


function queryy2($query) {
	global $koneksi;

	$result2 = mysqli_query($koneksi,$query);
	$bows=[];
	while ($bow = mysqli_fetch_assoc($result2)){
		$bows[] = $bow;
	}
	return $bows;
}

function kueri($kueri) {
	global $koneksi;

	$data = mysqli_query($koneksi,$kueri);
	$arrows=[];
	while ($arrow = mysqli_fetch_assoc($data)){
		$arrows[] = $arrow;
	}
	return $arrows;
}

function quest($query) {
	global $koneksi;

	$hasil = mysqli_query($koneksi,$query);
	$cows=[];
	while ($cow = mysqli_fetch_assoc($hasil)){
		$cows[] = $cow;
	}
	return $cows;
}

$perpage = 5;//perhalaman

$pageaktif  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start = ($pageaktif > 1) ? ($perpage * $pageaktif) - $perpage : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan");
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



function cari($keyword){
global $start;
global  $perpage;

	$query = "SELECT * FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang 
				WHERE 
		nama_bidang LIKE '%$keyword%' OR 
		tanggal_permintaan LIKE '%$keyword%' OR
		status LIKE '%$keyword%'



	ORDER BY t_permintaan.id_permintaan DESC LIMIT $start, $perpage";
	
	return queryy($query);
}

$pageper = 5;//perhalaman

$activepg  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$starto = ($activepg > 1) ? ($pageper * $activepg) - $pageper : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_permintaan");
$total  = mysqli_num_rows($result);//jumlah data

$pages  = ceil($total / $pageper);//jumlah halaman

$jumlahlink = 2;
if($activepg > $jumlahlink) {
  $start_number = $activepg - $jumlahlink;
}else{
  $start_number = 1;
}

if($activepg < ($pages - $jumlahlink)){
  $end_number = $activepg + $jumlahlink;
}else{
  $end_number = $pages;
}



function carilah($keyword){
global $starto;
global  $pageper;

	$query = "SELECT * FROM t_permintaan JOIN t_bidang ON t_permintaan.id_bidang=t_bidang.id_bidang 
				WHERE 
		nama_bidang LIKE '%$keyword%' OR 
		tanggal_permintaan LIKE '%$keyword%' OR
		status LIKE '%$keyword%'



	ORDER BY t_permintaan.id_permintaan DESC LIMIT $starto, $pageper";

	return queryy2($query);
}

$perpage2 = 5;//perhalaman

$pageaktif2  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start2 = ($pageaktif2 > 1) ? ($perpage2 * $pageaktif2) - $perpage2 : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_barang_atk");
$total2  = mysqli_num_rows($result);//jumlah data
$pages2  = ceil($total2 / $perpage2);//jumlah halaman

$jumlahling = 2;
if($pageaktif2 > $jumlahling) {
  $start_numbers = $pageaktif2 - $jumlahling;
}else{
  $start_numbers = 1;
}

if($pageaktif2 < ($pages2 - $jumlahling)){
  $end_numbers= $pageaktif2 + $jumlahling;
}else{
  $end_numbers= $pages2;
}

function carik($keyy){
global $start2;
global  $perpage2;

	$query = "SELECT * FROM t_barang_atk
				WHERE 
		nama_atk LIKE '%$keyy%' OR 
		kategori_atk LIKE '%$keyy%' OR
		satuan LIKE '%$keyy%' OR
		harga LIKE '%$keyy%'
		LIMIT $start2,$perpage2";



	return queryy($query);
}

$perpage3 = 5;//perhalaman

$pageaktif3  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start3 = ($pageaktif3 > 1) ? ($perpage3 * $pageaktif3) - $perpage3 : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_kategori");
$total3  = mysqli_num_rows($result);//jumlah data
$pages3  = ceil($total3 / $perpage3);//jumlah halaman

function cari3($keys){
global $start3;
global  $perpage3;

	$query = "SELECT * FROM t_kategori
				WHERE 
		nama_kategori LIKE '%$keys%'
		LIMIT $start3,$perpage3";

	return queryy($query);
}



$perpage4 = 5;//perhalaman

$pageaktif4  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start4 = ($pageaktif4 > 1) ? ($perpage4 * $pageaktif4) - $perpage4 : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_satuan");
$total4  = mysqli_num_rows($result);//jumlah data
$pages4  = ceil($total4 / $perpage4);//jumlah halaman



function cari4($key){
global $start4;
global  $perpage4;

	$query = "SELECT * FROM t_satuan
				WHERE 
		nama_satuan LIKE '%$key%'
		LIMIT $start4,$perpage4";



	return kueri($query);
}

$perpage5 = 5;//perhalaman

$pageaktif5  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start5 = ($pageaktif5 > 1) ? ($perpage5 * $pageaktif5) - $perpage5 : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_barang_atk");
$total5  = mysqli_num_rows($result);//jumlah data
$pages5  = ceil($total5 / $perpage5);//jumlah halaman

$numoflink = 2;
if($pageaktif5 > $numoflink) {
  $starter = $pageaktif5 - $numoflink;
}else{
  $starter = 1;
}

if($pageaktif5 < ($pages5 - $numoflink)){
  $ender = $pageaktif5 + $numoflink;
}else{
  $ender = $pages5;
}


function cari22($katana){
global $start5;
global  $perpage5;

	$query = "SELECT*FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk
				WHERE 
		id_transaksi LIKE '%$katana%' OR 
		tanggal_masuk LIKE '%$katana%' OR
		id_atk LIKE '%$katana%'OR
		nama_atk LIKE '%$katana%'OR
		jumlah_masuk LIKE '%$katana%'

 LIMIT $start5, $perpage5";

	return queen($query);
}



$perpage7 = 5;//perhalaman

$pageaktif7  = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
$start7 = ($pageaktif7 > 1) ? ($perpage7 * $pageaktif7) - $perpage7 : 0;

$result = mysqli_query($koneksi,"SELECT*FROM t_barang_masuk");
$tot  = mysqli_num_rows($result);//jumlah data

$pages7  = ceil($tot / $perpage7);//jumlah halaman

$jumlahlingx = 2;
if($pageaktif7 > $jumlahlingx) {
  $start_num = $pageaktif7 - $jumlahlingx;
}else{
  $start_num = 1;
}

if($pageaktif7 < ($pages7 - $jumlahlingx)){
  $end_num = $pageaktif7 + $jumlahlingx;
}else{
  $end_num = $pages7;
}



function cari7($phrase){
global $start7;
global  $perpage7;

	$kueri = "SELECT * FROM t_barang_masuk JOIN t_barang_atk ON t_barang_masuk.id_atk=t_barang_atk.id_atk WHERE 
		id_barang_masuk LIKE '%$phrase%' OR 
      tanggal_masuk LIKE '%$phrase%' OR
      id_atk LIKE '%$phrase%' OR
      nama_atk LIKE '%$phrase%' OR
      jumlah_masuk LIKE '%$phrase%'
	ORDER BY t_barang_masuk.id_barang_masuk DESC LIMIT $start7, $perpage7";

	return quest($kueri);
}


?>