<?php
require 'koneksi.php'; // Pastikan koneksi database telah terhubung

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $id_penilaian = $_POST['id_penilaian'];
    $id_alternatif = $_POST['id_alternatif'];
    $id_sub_kriteria = $_POST['id_sub_kriteria'];
    $nilai = $_POST['nilai'];

    // Query untuk update data penilaian
    $query = "UPDATE data_penilaian SET id_alternatif = '$id_alternatif', id_sub_kriteria = '$id_sub_kriteria', nilai = '$nilai' WHERE id_penilaian = '$id_penilaian'";

    if (mysqli_query($koneksi, $query)) {
        // Jika berhasil, redirect ke halaman data penilaian
        header("Location: data-penilaian.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
