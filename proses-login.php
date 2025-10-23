<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$pass = mysqli_real_escape_string($koneksi, $_POST['password']);

// menyeleksi data admin dengan email dan password yang sesuai
$data = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND password='$pass'");

// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

if ($cek > 0) {
    $sesi = mysqli_fetch_assoc($data);

    // menyimpan data ke session
    $_SESSION['id_user'] = $sesi['id_user'];
    $_SESSION['nama'] = $sesi['nama'];
    $_SESSION['level'] = $sesi['level'];
    $_SESSION['status'] = "login";

    // aksi berdasarkan level user
    if ($sesi['level'] == "admin") {
        header("location:index.php");
    } elseif ($sesi['level'] == "manajer") {
        header("location:manajer_dashboard.php");
    } elseif ($sesi['level'] == "staff") {
        header("location:staff_dashboard.php");
    } else {
        header("location:index.php"); // fallback jika level tidak terdaftar
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>
