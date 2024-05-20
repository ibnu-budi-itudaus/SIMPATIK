



$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

function ubahKategori($data)
{
	

	$id = $data['id_kategori'];
	$nama = $data['nama_kategori'];

	mysqli_query($koneksi, "UPDATE t_kategori SET nama_kategori = '$nama' WHERE id_kategori = $id
	");

	return mysqli_affected_rows($koneksi);

}
