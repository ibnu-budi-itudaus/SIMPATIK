<?php 
include 'koneksi.php';

$koneksi->query("DELETE FROM t_barang_atk WHERE id_atk='$_GET[id]'");

echo "<script>alert('data atk terhapus'); </script>";
echo "<script>location='list.php';</script>";
 ?>