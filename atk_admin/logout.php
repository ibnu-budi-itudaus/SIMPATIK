<?php 
session_start();
//menghancurkan $_SESSION['admin']; (saja)
unset($_SESSION['admin']);
//menghancurkan $_SESSION
// session_destroy();

unset($_SESSION['right']);
unset($_SESSION['keyword']);
unset($_SESSION['keyworld']);
echo "<script>alert('Anda telah logout');</script>";
echo "<script>location='../pre_login.php';</script>";

 ?>