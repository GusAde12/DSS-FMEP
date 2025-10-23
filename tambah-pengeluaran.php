<?php
session_start();
include('koneksi.php');

// Tangkap data dari form
$tgl_pengeluaran = $_GET['tgl_pengeluaran'];
$jumlah = abs((int)$_GET['jumlah']);
$id_sumber = (int)$_GET['id_sumber'];
$nama_sumber = mysqli_real_escape_string($koneksi, $_GET['nama']); // Hindari SQL Injection

// Validasi input
if (empty($tgl_pengeluaran) || empty($jumlah) || empty($id_sumber) || empty($nama_sumber)) {
    die("Semua data harus diisi!");
}

// Query untuk menambahkan data ke tabel pengeluaran
$query = mysqli_query($koneksi, "INSERT INTO pengeluaran (tgl_pengeluaran, jumlah, id_sumber, nama) VALUES ('$tgl_pengeluaran', '$jumlah', '$id_sumber', '$nama_sumber')");

$namaadmin = $_SESSION['nama']; // Nama admin untuk logging
if ($query) {
    // Tulis log
    define('LOG', 'log.txt');
    $time = @date('[Y-m-d H:i:s]');
    $logMessage = $time . " Nama Admin: $namaadmin => Tambah Pengeluaran: Tanggal=$tgl_pengeluaran, Jumlah=$jumlah, ID Sumber=$id_sumber, Nama Sumber=$nama_sumber => Sukses\n";
    file_put_contents(LOG, $logMessage, FILE_APPEND);

    // Redirect kembali ke halaman pengeluaran
    header("Location: pengeluaran.php");
    exit;
} else {
    echo "ERROR: Gagal menambahkan data! " . mysqli_error($koneksi);
}
?>
