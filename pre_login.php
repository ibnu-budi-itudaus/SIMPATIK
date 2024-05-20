<?php 
session_start();



 ?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="atk_admin/login2.css">
    <title>Pre-Login</title>
  </head>
 <body>
 	<div class="container" >
 		<div class="row text-center ">
            <div class="col-md-12">
                <br />
                <h2><img src="atk_admin/img1/logokab.png" width="38" height="40" class="d-inline-block align-top" alt="" loading="lazy"> BAPPEDA</h2>
                <!-- <h5>Kabupaten Serang</h5> -->
            </div>
        </div>
 	</div>




<div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-4">
          <div class="card text-center  ">
            <div class="card-body">
               <p class="card-text"><i class="fa-2x fas fa-user"></i></p>
              <p class="card-text">Anda ingin login sebagai?</p>
                <div class="row">
                <div class="col-md-1"></div> 
                  <div class="col-md-10">  
                     <form role="form text-center" method="post">
                            <div class="form-group row">
            
                              <input type="submit" name="user" value="User" class="btn btn-primary ml-4 mr-3" style="width: 70px;"> atau 
                               <input type="submit" name="admin" value="Admin" class="btn btn-danger mr-4 ml-3" style="width: 70px;">
                            </div>
                     </form>
                </div>
                <div class="col-md-1"></div> 

             
                
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>


             <?php 
                if (isset($_POST['user']))
                {
                 
                    $_SESSION["right"] = "user";
                    echo "<meta http-equiv='refresh' content='1;url=login1.php'>";
                  
                }

                 if (isset($_POST['admin']))
                {
                 
                    $_SESSION["right"] = "admin";
                    echo "<meta http-equiv='refresh' content='1;url=atk_admin/login.php'>";
                  
                }



              ?>






<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
  <script type="text/javascript" src="assets/admin.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="assets/bootstrap/js/bootstrap.js"></script>



 </body>
 </html>

