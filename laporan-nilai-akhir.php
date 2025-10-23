<?php
require 'cek-sesi.php';
require 'koneksi.php';

// Atur zona waktu ke Indonesia
date_default_timezone_set('Asia/Jakarta');

// Format tanggal dalam bahasa Indonesia
$hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
$bulan = array(1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

$hari_ini = $hari[date("w")];
$tanggal = date("j");
$bulan_ini = $bulan[date("n")];
$tahun = date("Y");

$tanggal_lengkap = "$hari_ini, $tanggal $bulan_ini $tahun";

// Ambil data kriteria
$query_kriteria = mysqli_query($koneksi, "SELECT * FROM data_kriteria");
$kriteria = [];
while ($row = mysqli_fetch_assoc($query_kriteria)) {
    $kriteria[] = $row;
}

// Ambil hasil perhitungan (normalisasi dan total)
$query_hasil = mysqli_query($koneksi, "
    SELECT a.nama_alternatif, SUM((sk.nilai / max_nilai.max) * k.bobot) AS nilai_akhir
    FROM data_penilaian dp
    JOIN data_alternatif a ON dp.id_alternatif = a.id_alternatif
    JOIN data_sub_kriteria sk ON dp.id_sub_kriteria = sk.id_sub_kriteria
    JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria
    JOIN (
        SELECT sk.id_kriteria, MAX(sk.nilai) AS max
        FROM data_sub_kriteria sk
        GROUP BY sk.id_kriteria
    ) max_nilai ON max_nilai.id_kriteria = k.id_kriteria
    GROUP BY a.nama_alternatif
    ORDER BY nilai_akhir DESC
");

$hasil = [];
while ($row = mysqli_fetch_assoc($query_hasil)) {
    $hasil[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Hasil Perhitungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            min-height: 100vh;
        }

        .container {
            width: 800px;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: auto;
            height: auto;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 100px;
            height: 100px;
        }

        .header h1 {
            font-size: 18px;
            margin: 10px 0;
        }

        .table-container {
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: center;
        }

        .footer {
            text-align: right;
            margin-top: 20px;
        }

        .footer p {
            margin: 5px 0;
        }

        /* Aturan untuk pencetakan */
        @media print {
            body {
                background-color: white; /* Set background putih saat print */
            }

            .container {
                width: 100%;
                max-width: 100%;
                padding: 10px;
                box-shadow: none;
                border: none;
            }

            .header img {
                width: 120px;
                height: 120px;
            }

            .table-container {
                max-height: none;
                overflow: visible;
            }

            table {
                border: 1px solid #000;
            }

            table th, table td {
                padding: 12px;
                text-align: left;
            }

            .footer {
                text-align: right; /* Menempatkan footer di sisi kanan */
                margin-top: 20px;
            }

            /* Mengatur margin halaman cetak */
            @page {
                margin: 10mm; /* Mengatur margin untuk halaman cetak */
            }

            /* Hapus tombol print saat mencetak */
            .print-button {
                display: none;
            }
        }

        .print-button {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .print-button button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
        <img src="img/logo.png" alt="Logo">
            <h1>Waringin Jaya, kec. Bojonggede, Kabupaten Bogor, Jawa Barat<br>16925</h1>
        </div>
        <h2 style="text-align: center;">Hasil Perhitungan</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Peringkat</th>
                        <th>Nama Alternatif</th>
                        <th>Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $peringkat = 1;
                    foreach ($hasil as $row) {
                        echo "<tr>";
                        echo "<td>{$peringkat}</td>";
                        echo "<td>{$row['nama_alternatif']}</td>";
                        echo "<td>" . number_format($row['nilai_akhir'], 4) . "</td>";
                        echo "</tr>";
                        $peringkat++;
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>Bojonggede, <?php echo $tanggal_lengkap; ?></p>
            <p>Lurah</p>
            <p>Rohmat, SE</p>
        </div>
        <div class="print-button">
            <button onclick="window.print()">Print Laporan</button>
        </div>
    </div>
</body>

</html>
