<?php 
include 'koneksi.php';

$koneksi->query("DELETE FROM t_satuan WHERE id_satuan='$_GET[id]'");

echo "<script>alert('satuan terhapus'); </script>";
echo "<script>location='satuan.php';</script>";
 ?>