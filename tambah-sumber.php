<?php
//include('dbconnected.php');
include('koneksi.php');

$nama = $_GET['nama'];
$akun = $_GET['akun'];


//query update
$query = mysqli_query($koneksi,"INSERT INTO `sumber` (`id_sumber`, `nama`, `akun`) VALUES (null, '$nama', '$akun')");

if ($query) {
 # credirect ke page index
 header("location:sumber.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>