<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_sumber'];
$nama = $_GET['nama'];
$akun = $_GET['akun'];


//query update
$query = mysqli_query($koneksi,"UPDATE sumber SET nama='$nama', akun='$akun' WHERE id_sumber='$id' ");

if ($query) {
 # credirect ke page index
 header("location:sumber.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysql_error();
}

//mysql_close($host);
?>