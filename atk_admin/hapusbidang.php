<?php 
include 'koneksi.php';

$koneksi->query("DELETE FROM t_bidang WHERE id_bidang='$_GET[id]'");

echo "<script>alert(bidang terhapus'); </script>";
echo "<script>location='datadivisi.php';</script>";
 ?>