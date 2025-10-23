<?php 
// cek apakah sudah login
session_start();
require 'koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:login.php?pesan=belum_login");
    exit;
}

// cek level user dan arahkan jika diperlukan
if ($_SESSION['level'] == "admin") {
    // akses untuk admin
    // kode tambahan untuk admin jika diperlukan
} elseif ($_SESSION['level'] == "manajer") {
    // akses untuk manajer
    // kode tambahan untuk manajer jika diperlukan
} elseif ($_SESSION['level'] == "staff") {
    // akses untuk staff
    // kode tambahan untuk staff jika diperlukan
} else {
    // jika level tidak sesuai, kembalikan ke login
    header("location:login.php?pesan=akses_ditolak");
    exit;
}
?>
