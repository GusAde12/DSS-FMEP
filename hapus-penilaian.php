<?php
// Include koneksi dan cek sesi
require 'cek-sesi.php';
require 'koneksi.php';

// Periksa apakah ada id_penilaian yang dikirimkan
if (isset($_GET['id_penilaian'])) {
    $id_penilaian = $_GET['id_penilaian'];

    // Hapus data penilaian berdasarkan id_penilaian
    $query = "DELETE FROM data_penilaian WHERE id_penilaian = '$id_penilaian'";
    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman data penilaian setelah penghapusan berhasil
        header('Location: data-penilaian.php');
        exit;
    } else {
        // Jika terjadi kesalahan
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    // Jika id_penilaian tidak ditemukan
    echo "ID Penilaian tidak ditemukan.";
}
?>
