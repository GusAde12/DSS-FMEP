<?php
// File: tambah-kriteria.php
require 'koneksi.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kriteria = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $bobot = (float) $_POST['bobot'];

    // Validasi input
    if (empty($nama_kriteria) || $bobot <= 0) {
        echo "Nama kriteria dan bobot tidak boleh kosong atau nol.";
        exit;
    }

    // Query untuk menambahkan data ke tabel kriteria
    $query = "INSERT INTO data_kriteria (nama_kriteria, kode, bobot) VALUES ('$nama_kriteria', '$kode', '$bobot')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: kriteria.php?status=success"); // Redirect jika sukses
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
