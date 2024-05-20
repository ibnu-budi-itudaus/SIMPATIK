  
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="user1.css">
   

 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
  <div class="container">
      <a class="navbar-brand" href="#"><img src="atk_admin/img1/logokab.png" width="35" height="35" class="d-inline-block align-top" alt="" loading="lazy"> <b>SIMPATIK</b> </a>

       <div class="collapse navbar-collapse" id="navbarSupportedContent">

          <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION["bidang"])): ?>
            <?php $id_bidang = $_SESSION["bidang"]['id_bidang']; ?>
            <?php $ambil = $koneksi->query("SELECT * FROM t_bidang WHERE id_bidang='$id_bidang' "); ?>
        <?php $pecah = $ambil->fetch_assoc(); ?>
             <li class="nav-item active">
              <a class="nav-link" href="#"><i class="fas fa-users mr-1"></i> <?php echo $pecah['nama_bidang'] ?></a>
            </li>
           
            <?php endif ?>  
          </ul>

       </div>
      
      
        <div class="icon ml-4">
          <h5>
           <!--  <i class="fas fa-envelope mr-3" data-toggle="tooltip" title="Pesan Masuk"></i>
            <i class="fas fa-bell mr-3" data-toggle="tooltip" title="Notifikasi"></i> -->
            <a href="logout1.php" onclick = "return confirm('apakah anda yakin ingin logout?');"><i class="fas fa-sign-out-alt mr-3 mt-2" data-toggle="tooltip" title="Logout"></i></a>
            
          </h5>
        </div>
      </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <div class="container">
    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav">
        <li class="nav-item mr-3">
          <a class="nav-link" href="index1.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="permintaan.php"><i class="fas fa-exchange-alt"></i> Permintaan</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="riwayat_permintaan.php" tabindex="-1" aria-disabled="true"><i class="fas fa-history"></i> Riwayat</a>
        </li>
      </ul>
    </div>
    </div>
    
</nav>
</div>
