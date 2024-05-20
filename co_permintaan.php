 <?php

 include 'koneksi.php';

session_start();
error_reporting(0); 
                

                  //mendapatkan jumlah yang dinputkan
                      $jumla = $_POST["jumla"];
                      $id_atk = $_POST["id_atk"];
                      //masukan disession keranjang2
                   
                     
                    if($_SESSION['permintaan'][$id_atk] >= 1){

                      $_SESSION['permintaan'][$id_atk] += $jumla;
                    }else{
                       $_SESSION['permintaan'][$id_atk] = $jumla;
                    }
                    
                echo "<script>location='permintaan.php';</script>";

               ?>
