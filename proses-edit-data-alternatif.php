<?php
// Menghubungkan ke database
require 'koneksi.php';

// Mengecek apakah ada data yang dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengambil data dari form
    $id_alternatif = $_POST['id_alternatif'];
    $nama_alternatif = $_POST['nama_alternatif'];

    // Query untuk memperbarui data alternatif
    $query = "UPDATE data_alternatif SET nama_alternatif = ? WHERE id_alternatif = ?";

    // Menyiapkan statement
    if ($stmt = mysqli_prepare($koneksi, $query)) {

        // Mengikat parameter untuk statement
        mysqli_stmt_bind_param($stmt, 'si', $nama_alternatif, $id_alternatif);

        // Mengeksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil, alihkan ke halaman data alternatif
            header('Location: data-alternatif.php');
        } else {
            // Jika terjadi kesalahan, tampilkan pesan error
            echo "Terjadi kesalahan saat memperbarui data.";
        }

        // Menutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan query.";
    }
}

// Menutup koneksi ke database
mysqli_close($koneksi);
?>
