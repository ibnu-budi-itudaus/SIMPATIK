  
 <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
      <div class="container">
      <a class="navbar-brand" href="#"><img src="img1/logokab.png" width="35" height="35" class="d-inline-block align-top" alt="" loading="lazy"> <b>SIMPATIK</b> </a>

       <div class="collapse navbar-collapse" id="navbarSupportedContent2">

          <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION["admin"])): ?>
            <?php $id_admin = $_SESSION["admin"]['id_admin']; ?>
            <?php $ambil = $koneksi->query("SELECT * FROM t_admin WHERE id_admin='$id_admin' "); ?>
        <?php $pecah = $ambil->fetch_assoc(); ?>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-cog mr-2"></i> 
                <?php echo $pecah['nama_admin'] ?>
              </a>
              <div class="dropdown-menu ml-auto" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Profil</a>
                <a onclick = "return confirm('apakah anda yakin ingin logout?');" class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </li>
            <?php endif ?>  
          </ul>

       </div>
      
      
        <div class="icon ml-4">
          <h5>
         <!--    <i class="fas fa-envelope mr-3" data-toggle="tooltip" title="Pesan Masuk"></i>-->
            <i class="fas fa-bell mr-3" data-toggle="tooltip" title="Notifikasi"></i> 
            <a href="logout.php"><i onclick = "return confirm('apakah anda yakin ingin logout?');" class="fas fa-sign-out-alt mr-3 mt-2" data-toggle="tooltip" title="Logout"></i></a>
            
          </h5>
        </div>
      </div>
    </nav>
</nav>
<div class="navy">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
 <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ">
        <li class="nav-item mr-3">
          <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Home</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="kategori.php"><i class="fas fa-briefcase"></i> Data ATK</a>
        </li>
          <li class="nav-item dropdown mr-3">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-people-carry"></i> Transaksi
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="barmas.php"><i class="far fa-circle"></i> Barang Masuk</a>
              <a class="dropdown-item" href="barangkeluar.php"><i class="far fa-circle"></i> Barang Keluar</a>
            </div>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="permintaan.php"><i class="fas fa-clipboard-list"></i> Permintaan</a>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="pengadaan.php"><i class="fas fa-tasks"></i> Pengadaan</a>
        </li>
        <li class="nav-item dropdown mr-3">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <i class="fas fa-file-alt"></i> Laporan
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="laporan.php"><i class="far fa-circle"></i> Barang Masuk & Keluar</a>
              <a class="dropdown-item" href="laporanstok.php"><i class="far fa-circle"></i> Stok Barang </a>
            </div>
        </li>
        <li class="nav-item mr-3">
          <a class="nav-link" href="datadivisi.php"><i class="fas fa-users"></i> Data Bidang</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
</div>
<!-- script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script src="bootstrap/js/jquery.js"></script> 
  <script src="bootstrap/js/popper.js"></script> 
  <script src="bootstrap/js/bootstrap.js"></script> -->