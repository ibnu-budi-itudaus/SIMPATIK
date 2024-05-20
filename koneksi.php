<?php 
$host = 'localhost';
	$username = 'root';
	$password = '';
	$database = 'data_atk';
	$koneksi = mysqli_connect($host, $username, $password, $database);

	if(!$koneksi){
		die("error bro". mysqli_connect_error());
	}
 ?>