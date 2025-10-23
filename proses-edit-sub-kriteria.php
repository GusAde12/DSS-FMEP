<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_sub_kriteria = $_POST['id_sub_kriteria'];
    //$id_kriteria = $_POST['id_kriteria'];
    $nama_sub_kriteria = $_POST['nama_sub_kriteria'];
    $nilai = $_POST['nilai'];

    // Query untuk memperbarui data sub-kriteria
    $query = "UPDATE data_sub_kriteria SET nama_sub_kriteria='$nama_sub_kriteria', nilai='$nilai' WHERE id_sub_kriteria='$id_sub_kriteria'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Sub-kriteria berhasil diperbarui!'); window.location.href='sub-kriteria.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui sub-kriteria: " . mysqli_error($koneksi) . "'); window.location.href='sub-kriteria.php';</script>";
    }
}
?>