<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_alternatif'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `data_alternatif` WHERE id_alternatif = '$id'");

if ($query) {
 # credirect ke page index
 header("location:data-alternatif.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>