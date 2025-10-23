<?php
// Koneksi ke database
include('koneksi.php');

// Ambil ID Pemasukan
$id = isset($_GET['id_pemasukan']) ? (int)$_GET['id_pemasukan'] : 0;

// Validasi ID
if ($id <= 0) {
    die("ID tidak valid!");
}

// Query hapus data
$query = mysqli_query($koneksi, "DELETE FROM pemasukan WHERE id_pemasukan = '$id'");

if ($query) {
    // Redirect jika berhasil
    header("location:pendapatan.php");
    exit;
} else {
    // Tampilkan error jika gagal
    echo "ERROR, data gagal dihapus: " . mysqli_error($koneksi);
}
?>
