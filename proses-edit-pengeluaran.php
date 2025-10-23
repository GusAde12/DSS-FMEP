<?php
session_start();
include('koneksi.php');

define('LOG', 'log.txt');
function write_log($log) {  
    $time = @date('[Y-d-m:H:i:s]');
    $op = $time . ' ' . $log . "\n" . PHP_EOL;
    $fp = @fopen(LOG, 'a');
    $write = @fwrite($fp, $op);
    @fclose($fp);
}

// Validasi dan sanitasi input
$id = isset($_GET['id_pengeluaran']) ? (int)$_GET['id_pengeluaran'] : 0;
$tgl = isset($_GET['tgl_pengeluaran']) ? mysqli_real_escape_string($koneksi, $_GET['tgl_pengeluaran']) : '';
$jumlah = isset($_GET['jumlah']) ? abs((int)$_GET['jumlah']) : 0;
$id_sumber = isset($_GET['id_sumber']) ? abs((int)$_GET['id_sumber']) : 0;
$nama_sumber = isset($_GET['nama']) ? mysqli_real_escape_string($koneksi, $_GET['nama']) : '';

// Validasi input wajib
if ($id === 0 || empty($tgl) || $jumlah === 0 || $id_sumber === 0 || empty($nama_sumber)) {
    die('Data tidak lengkap! Pastikan semua data telah diisi.');
}

// Validasi format tanggal
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tgl)) {
    die('Format tanggal tidak valid!');
}

// Query update
$query = mysqli_query($koneksi, "UPDATE pengeluaran SET tgl_pengeluaran='$tgl', jumlah='$jumlah', id_sumber='$id_sumber', nama='$nama_sumber' WHERE id_pengeluaran='$id'");

$namaadmin = $_SESSION['nama'];
if ($query) {
    // Log jika berhasil
    write_log("Nama Admin: $namaadmin => Edit Pengeluaran => ID: $id => Sukses Edit, Data: Tanggal=$tgl, Jumlah=$jumlah, ID Sumber=$id_sumber, Nama Sumber=$nama_sumber");
    // Redirect ke halaman pendapatan
    header("location:pengeluaran.php"); 
    exit;
} else {
    // Log jika gagal
    write_log("Nama Admin: $namaadmin => Edit Pengeluaran => ID: $id => Gagal Edit, Error: " . mysqli_error($koneksi));
    echo "ERROR, data gagal diupdate: " . mysqli_error($koneksi);
}

// Close connection (optional, MySQLi akan otomatis menutup koneksi saat script selesai dieksekusi)
// mysqli_close($koneksi);
?>
