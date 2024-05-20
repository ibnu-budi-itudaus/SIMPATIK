<?php 
include 'koneksi.php';

$id_barmas = $_GET["id_barmas"];
$jumlah = $_GET["jumlah"];
$id_atk = $_GET["id_atk"];
$ambil = $koneksi->query("SELECT*FROM t_barang_atk WHERE id_atk = '$id_atk' ");
$atk = $ambil->fetch_assoc();
$stok = $atk["stok"];
$stok_akhir = $stok - $jumlah;

$koneksi->query("UPDATE t_barang_atk SET stok = '$stok_akhir' WHERE id_atk='$id_atk'");


$koneksi->query("DELETE FROM t_barang_masuk WHERE id_barang_masuk='$id_barmas'");

echo "<script>alert('data barang masuk dengan id $id_barmas telah terhapus'); </script>";
echo "<script>location='barmas.php';</script>";




 ?>