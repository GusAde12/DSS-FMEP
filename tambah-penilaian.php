<?php
require 'koneksi.php'; // Pastikan koneksi database telah terhubung

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_alternatif = $_POST['id_alternatif'];
    $id_sub_kriteria = $_POST['id_sub_kriteria'];
    $nilai = $_POST['nilai'];

    // Query untuk menambah data penilaian
    $query = "INSERT INTO data_penilaian (id_alternatif, id_sub_kriteria, nilai) VALUES ('$id_alternatif', '$id_sub_kriteria', '$nilai')";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect ke halaman data penilaian
        header("Location: data-penilaian.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
