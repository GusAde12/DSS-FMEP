<?php
// File: proses-edit-kriteria.php
require 'koneksi.php'; // Menghubungkan ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kriteria = (int) $_POST['id_kriteria'];
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $nama_kriteria = mysqli_real_escape_string($koneksi, $_POST['nama_kriteria']);
    
    $bobot = (float) $_POST['bobot'];

    // Validasi input
    if (empty($nama_kriteria) || $bobot <= 0) {
        echo "Nama kriteria dan bobot tidak boleh kosong atau nol.";
        exit;
    }

    // Query untuk memperbarui data di tabel kriteria
    $query = "UPDATE data_kriteria SET kode='$kode', nama_kriteria='$nama_kriteria', bobot='$bobot' WHERE id_kriteria='$id_kriteria'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: kriteria.php?status=updated"); // Redirect jika sukses
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
