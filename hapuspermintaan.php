<?php 
session_start();
$id_atk=$_GET["id"];

unset($_SESSION["permintaan"][$id_atk]);


echo "<script>location='permintaan.php';</script>";
 ?>