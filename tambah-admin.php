<?php
//include('dbconnected.php');
include('koneksi.php');

$nama = $_GET['nama'];
$email = $_GET['email'];
$pass = $_GET['pass'];
$level = $_GET['level']; // Tambahan untuk level user

//query insert
$query = mysqli_query($koneksi, "INSERT INTO `admin` (`nama`, `email`, `pass`, `level`) VALUES ('$nama', '$email', '$pass', '$level')");

if ($query) {
    // redirect ke halaman profile
    header("location:profile.php"); 
} else {
    echo "ERROR, data gagal ditambahkan: " . mysqli_error($koneksi);
}

//mysql_close($host);
?>
