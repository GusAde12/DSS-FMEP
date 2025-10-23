<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kriteria = $_POST['id_kriteria'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $nilai = $_POST['nilai'];

    // Query untuk menambahkan data sub-kriteria baru
    $query = "INSERT INTO data_sub_kriteria (id_kriteria, nama_sub_kriteria, nilai) VALUES ('$id_kriteria', '$nama_sub_kriteria', '$nilai')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Sub-kriteria berhasil ditambahkan!'); window.location.href='sub-kriteria.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan sub-kriteria: " . mysqli_error($koneksi) . "'); window.location.href='sub-kriteria.php';</script>";
    }
}
?>