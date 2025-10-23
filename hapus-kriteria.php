<?php
//include('dbconnected.php');
include('koneksi.php');

$id = $_GET['id_kriteria'];

//query update
$query = mysqli_query($koneksi,"DELETE FROM `data_kriteria` WHERE id_kriteria = '$id'");

if ($query) {
 # credirect ke page index
 header("location:kriteria.php"); 
}
else{
 echo "ERROR, data gagal diupdate". mysqli_error($koneksi);
}

//mysql_close($host);
?>