<?php 	
include 'koneksi.php';
$id = $_GET['id'];
$id2 = $_GET['id'];
$val = $_GET['val'];
$validin = "Disetujui";
$validun = "Ditolak";
$validan = "Selesai";

$data=array();
$ambil = $koneksi->query("SELECT*FROM td_permintaan_atk where id_permintaan = '$id'");
while ($permint = $ambil->fetch_assoc()){
	$data[]=$permint;
}

if($val == 1){
		 $koneksi->query("UPDATE t_permintaan SET status = '$validin'
                          WHERE id_permintaan='$id2'");

		 foreach ($data as $key => $value){
				$idatk=$value['id_atk'];
				$ambil = $koneksi->query("SELECT*from t_barang_atk WHERE id_atk='$idatk'");
				while($peratk = $ambil->fetch_assoc()){

				$jumlah = $value['jumlah'];
				$stok = $peratk['stok'] - $jumlah;

				 $koneksi->query("UPDATE t_barang_atk SET stok = '$stok'
                          WHERE id_atk='$idatk'");
				

			}
             
             
                      echo "<script>alert('Permintaan telah disetujui, silahkan menuju menu pengadaan !'); </script>";
                      echo "<script>location='pengadaan.php'; </script>";         
  		}



       


			

}elseif ($val == 0) {
	$koneksi->query("UPDATE t_permintaan SET status = '$validun'
                          WHERE id_permintaan='$id'");
                      echo "<script>alert('Permintaan telah ditolak!'); </script>";
                      echo "<script>location='permintaan.php'; </script>";
}else{
	  $koneksi->query("INSERT INTO t_pengadaan (id_permintaan) 
	                    VALUES ('$id')");
	 foreach ($data as $key => $value){

		$query = mysqli_query($koneksi, "SELECT max(id_barang_keluar) as idTerbesar FROM t_barang_keluar");
		$data = mysqli_fetch_array($query);
		$kodeBarang = $data['idTerbesar'];
		 
		// mengambil angka dari kode barang terbesar, menggunakan fungsi substr
		// dan diubah ke integer dengan (int)
		$urutan = (int) substr($kodeBarang, 8, 4);
		 
		// bilangan yang diambil ini ditambah 1 untuk menentukan nomor urut berikutnya
		$urutan++;
		//Mengambil data tahun sekarang
		 date_default_timezone_set('Asia/Jakarta');
		    $year = date('Y');
		    $today = date("y-m-d");
		// membentuk kode barang baru
		// perintah sprintf("%03s", $urutan); berguna untuk membuat string menjadi 3 karakter
		// misalnya perintah sprintf("%03s", 15); maka akan menghasilkan '015'
		// angka yang diambil tadi digabungkan dengan kode huruf yang kita inginkan, misalnya BRG 
		$huruf = "TK-";
		$kodbarkel = $huruf . $year ."-" . sprintf("%04s", $urutan);
	 	
	 	$jumlah = $value['jumlah'];
	 	$idatk=$value['id_atk'];
	 	
		$set = $koneksi->query("SELECT*FROM t_barang_atk WHERE id_atk='$idatk'");
		$set2 = $set->fetch_assoc();
		$namaatk = $set2["nama_atk"];

		  $koneksi->query("INSERT INTO t_barang_keluar (id_barang_keluar,tanggal_keluar,id_atk,nama_atk,jumlah_keluar) 
	                    VALUES ('$kodbarkel','$today','$idatk','$namaatk','$jumlah')");
		  $koneksi->query("UPDATE t_permintaan SET status = '$validan'
	                          WHERE id_permintaan='$id'");
	                      echo "<script>alert('Permintaan telah selesai diproses!'); </script>";
	                      echo "<script>location='pengadaan.php'; </script>";
   }
                 
}
 ?>
