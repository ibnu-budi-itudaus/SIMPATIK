<?php 
session_start();
//koneksi ke database
include 'koneksi.php';

if (!isset($_SESSION['admin']))
{
    echo "<script>alert('anda harus login'); </script>";
    echo "<script>location='login.php'; </script>";
    header ('location:login.php');
    exit();
}

 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="fontawesome5/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <title>data divisi</title>
  </head>
  
  <body>
    <!-- Image and text -->
    <!-- As a heading -->
<!-- Image and text -->

<?php include 'menu.php'; ?>

<!-- <div class="container">
	 <nav aria-label="breadcrumb" id="bread1">
	  <ol class="breadcrumb" style="background-color: white">
	  	<li class="breadcrumb-item active" aria-current="page">Kategori</li>
	  	<li class="breadcrumb-item"><a href="satuan.php">Satuan</a></li>
	    <li class="breadcrumb-item"><a href="inputdata.php">Input Data</a></li>
	    <li class="breadcrumb-item"><a href="list.php">List</a></li>
	  </ol>
	</nav>
</div> -->
<section class="konten">
  
  <div class="container">
    
 <div class="row mt-4">
      <div class="col-sm-4 col-md-push-8 mb-3">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title mb-4">Input Data Bidang</h4>
           <!--  <p class="card-text">Total ATK Terdaftar</p> -->
          	<form role="form" method="post" autocomplete="off">
                <div class="form-group">
                	 <input type="text" name="nama" class="form-control" placeholder="Nama Bidang" autofill="off" autocomplete="off">
            	</div>
            	<div class="form-group">
                	 <input type="text" name="user" class="form-control" placeholder="Username Bidang" autocomplete="off" autofill="off">
            	</div>
            	<div class="form-group">
                	 <input type="password" name="pass" class="form-control" placeholder="Password Bidang" autocomplete="off">
            	</div>

            	 <div class="form-group">
                  <input type="submit" name="input" value="input" class="btn btn-primary btn-block">
                </div>
            </form>
          </div>
        </div>

        <?php 
			if (isset($_POST['input']))
			 {
				$koneksi->query("INSERT INTO t_bidang
				(nama_bidang,username,password)
				VALUES ('$_POST[nama]','$_POST[user]','$_POST[pass]')");

				echo "<script>alert('Data berhasil disimpan !');</script>";
				echo "<script>location='datadivisi.php';</script>";
			}
		 
		 ?>

      </div>
      <div class="col-sm-8 col-md-push-4"">
        <div class="card" style="border : 0">
          <div class="card-body">
            <h4 class="card-title mb-4"><i class="fas fa-users mr-2"></i>Data Bidang</h4>
            <!-- <p class="card-text">Total Permintaan</p> -->
            <table class="table">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Bidang</th>
          <th>Username</th>
          <th>Password</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      	<?php $nomor=1; ?>
      	<?php $ambil = $koneksi->query("SELECT * FROM t_bidang"); ?>
      	<?php while($pecah = $ambil->fetch_assoc()){?>
        <tr>
          <td><?php echo $nomor; ?></td>
          <td><?php echo $pecah['nama_bidang'] ?></td>
          <td><?php echo $pecah['username'] ?></td>
           <td><?php echo $pecah['password'] ?></td>
          <td><a class="btn btn-sm btn-warning" id="tombolUbah" data-toggle="modal" data-target="#ubahModal" data-id="<?php echo $pecah['id_bidang']; ?>" data-nama="<?php echo $pecah['nama_bidang']; ?>" data-user="<?php echo $pecah['username']; ?>" data-pass="<?php echo $pecah['password']; ?>" > <i class="fas fa-edit" data-toggle="tooltip" title="Ubah data"></i></a>
            <a onclick = "return confirm('apakah anda yakin ingin menghapus data?');" class="btn btn-sm btn-danger" href="hapusbidang.php?id=<?php echo $pecah['id_bidang']; ?>"> <i class="fas fa-trash-alt" data-toggle="tooltip" title="Hapus data"></i></a>
            </td>
                  </tr>
 		<?php $nomor++; ?>
        <?php } ?>
 
       
      </tbody>
    </table>
    
          </div>
        </div>
      </div>



  </div>
</section>
 <div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="ubahModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                 <div class="modal-header">
                   <h5 class="modal-title" id="ubahModalLabel">Ubah Data Bidang</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="close"></button>
                   <span aria-hidden="true" style="font-size: 18px">&times;</span>
                 </div>
                 <div class="modal-body">
                   <form role="form" method="post">

                    <input type="hidden" name="id_bidang" id="id_bidang" class="form-control">

                     <div class="form-group">
                       <label for="nama">Nama Bidang</label>
                       <input type="text" class="form-control" name="nama" id="nama">
                      </div>
                      <div class="form-group">
                       <label for="user">Username</label>
                       <input type="text" class="form-control" name="user" id="user">
                      </div>
                       <div class="form-group">
                       <label for="pass">Password</label>
                       <input type="text" class="form-control" name="pass" id="pass">
                      </div>
                      
                       
                      
                
                <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">close</button>
                   <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>

                 </div>
                 </form>
                <?php 


               if (isset($_POST["ubah"]))


                    {
                        $koneksi->query("UPDATE t_bidang SET nama_bidang='$_POST[nama]',username='$_POST[user]',password='$_POST[pass]'
                          WHERE id_bidang='$_POST[id_bidang]'");
                      echo "<script>alert('Data Bidang telah diubah'); </script>";
                      echo "<script>location='datadivisi.php'; </script>";
                    }

                 ?>
                  
                </div>                 
               
                


                </div>
              </div>
            </div>


<script type="text/javascript" src="admin.js"></script>
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="bootstrap/js/jquery.js"></script> 
  <script type="text/javascript" src="bootstrap/js/popper.js"></script> 
  <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>

<!-- JS untuk ubah data dgn modal -->
<script>
  $(document).on("click","#tombolUbah", function(){
      let id= $(this).data('id');
      let nama = $(this).data('nama');
      let user = $(this).data('user');
      let pass = $(this).data('pass');


      $("#id_bidang").val(id);
      $("#nama").val(nama);
      $("#user").val(user);
      $("#pass").val(pass);
  });

</script>
<script type="text/javascript">


 

</script>


  </body>
</html>

