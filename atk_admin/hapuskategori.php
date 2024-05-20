<?php 
include 'koneksi.php';

$koneksi->query("DELETE FROM t_kategori WHERE id_kategori='$_GET[id]'");

echo "<script>alert('kategori terhapus'); </script>";
echo "<script>location='kategori.php';</script>";
 ?>