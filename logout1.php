<?php 
session_start();
//menghancurkan $_SESSION['pelanggan']; ( session pelanggan )
unset($_SESSION['bidang']);
//menghancurkan $_SESSION
unset($_SESSION['permintaan']);
unset($_SESSION['atk']);
// unset($_SESSION['permintaan2']);
unset($_SESSION['right']);
echo "<script>alert('Anda telah logout');</script>";
echo "<script>location='login1.php';</script>";

 ?>