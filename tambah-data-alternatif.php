<?php
// Koneksi ke database
require 'koneksi.php';

// Cek apakah data telah dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama_alternatif = mysqli_real_escape_string($koneksi, $_POST['nama_alternatif']);

    // Validasi data (opsional, tambahkan sesuai kebutuhan)
    if (empty($nama_alternatif)) {
        echo "Nama alternatif tidak boleh kosong.";
        exit;
    }

    // Query untuk menambahkan data alternatif ke database
    $query = "INSERT INTO data_alternatif (nama_alternatif) VALUES ('$nama_alternatif')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Berhasil menambahkan data
        echo "<script>
                alert('Data alternatif berhasil ditambahkan!');
                window.location.href = 'data-alternatif.php';
              </script>";
    } else {
        // Gagal menambahkan data
        echo "<script>
                alert('Gagal menambahkan data alternatif: " . mysqli_error($koneksi) . "');
                window.location.href = 'data-alternatif.php';
              </script>";
    }
} else {
    // Jika file diakses langsung tanpa mengirim data POST
    echo "<script>
            alert('Akses tidak valid!');
            window.location.href = 'data-alternatif.php';
          </script>";
}
?>
