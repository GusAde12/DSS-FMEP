<?php
require 'cek-sesi.php';
require 'koneksi.php';

// Ambil data kriteria dan bobot
$query_kriteria = mysqli_query($koneksi, "SELECT * FROM data_kriteria");
$kriteria = [];
while ($row = mysqli_fetch_assoc($query_kriteria)) {
    $kriteria[] = $row;
}

// Ambil data penilaian
$query_penilaian = mysqli_query($koneksi, "
    SELECT dp.id_alternatif, a.nama_alternatif, dp.id_sub_kriteria, sk.nilai AS nilai_sub_kriteria, k.id_kriteria, k.bobot
    FROM data_penilaian dp
    JOIN data_alternatif a ON dp.id_alternatif = a.id_alternatif
    JOIN data_sub_kriteria sk ON dp.id_sub_kriteria = sk.id_sub_kriteria
    JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria
");
$penilaian = [];
while ($row = mysqli_fetch_assoc($query_penilaian)) {
    $penilaian[] = $row;
}

// Proses normalisasi dan perhitungan
$normalisasi = [];
$hasil = [];

// Normalisasi data
foreach ($kriteria as $k) {
    $id_kriteria = $k['id_kriteria'];

    // Cari nilai maksimum untuk setiap kriteria
    $nilai_filtered = array_column(array_filter($penilaian, function ($p) use ($id_kriteria) {
        return $p['id_kriteria'] === $id_kriteria;
    }), 'nilai_sub_kriteria');
    $nilai_maks = !empty($nilai_filtered) ? max($nilai_filtered) : 0;

    // Normalisasi nilai berdasarkan kriteria
    foreach ($penilaian as $p) {
        if ($p['id_kriteria'] === $id_kriteria) {
            $normalisasi[$p['id_alternatif']][$id_kriteria] = $p['nilai_sub_kriteria'] / $nilai_maks;
        }
    }
}

// Hitung nilai akhir (Total) dan simpan rincian bobot evaluasi
foreach ($normalisasi as $id_alternatif => $nilai_kriteria) {
    $total = 0;
    $bobot_evaluasi = [];
    foreach ($nilai_kriteria as $id_kriteria => $nilai_normalisasi) {
        $bobot = array_column($kriteria, 'bobot', 'id_kriteria')[$id_kriteria];
        $bobot_evaluasi[$id_kriteria] = $nilai_normalisasi * $bobot;
        $total += $bobot_evaluasi[$id_kriteria];
    }
    $hasil[] = [
        'id_alternatif' => $id_alternatif,
        'nama_alternatif' => array_column($penilaian, 'nama_alternatif', 'id_alternatif')[$id_alternatif],
        'nilai_akhir' => $total,
        'bobot_evaluasi' => $bobot_evaluasi
    ];
}

// Urutkan hasil berdasarkan nilai akhir
usort($hasil, function ($a, $b) {
    return ($b['nilai_akhir'] < $a['nilai_akhir']) ? -1 : (($b['nilai_akhir'] > $a['nilai_akhir']) ? 1 : 0);

});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Perhitungan</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <?php require 'sidebar.php'; ?>
    <div id="content">
        <?php require 'navbar.php'; ?>
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Data Perhitungan</h1>

            <!-- Tabel Nilai Bobot Evaluasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Bobot Evaluasi (WE)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alternatif</th>
                                    <?php foreach ($kriteria as $k): ?>
                                        <th><?php echo $k['nama_kriteria'] . ' (' . $k['kode'] . ')'; ?></th>
                                    <?php endforeach; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($hasil as $row) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$row['nama_alternatif']}</td>";
                                    foreach ($kriteria as $k) {
                                        $id_kriteria = $k['id_kriteria'];
                                        $bobot_evaluasi = isset($row['bobot_evaluasi'][$id_kriteria]) ? number_format($row['bobot_evaluasi'][$id_kriteria], 4) : '-';
                                        echo "<td>{$bobot_evaluasi}</td>";
                                    }
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Nilai Total Evaluasi -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nilai Total Evaluasi (∑WE)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alternatif</th>
                                    <th>Total Nilai ∑WE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($hasil as $row) {
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$row['nama_alternatif']}</td>";
                                    echo "<td>" . number_format($row['nilai_akhir'], 4) . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Matrix Keputusan (X) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Matrix Keputusan (X)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Alternatif</th>
                                    <?php foreach ($kriteria as $k): ?>
                                        <th><?php echo $k['nama_kriteria'] . ' (' . $k['kode'] . ')'; ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Kelompokkan data berdasarkan id_alternatif
                                $alternatif_grouped = [];
                                foreach ($penilaian as $row) {
                                    $alternatif_grouped[$row['id_alternatif']][] = $row;
                                }

                                // Menampilkan data dalam tabel
                                $no = 1;
                                foreach ($alternatif_grouped as $id_alternatif => $rows) {
                                    // Ambil nama alternatif dari baris pertama dalam grup
                                    $nama_alternatif = $rows[0]['nama_alternatif'];
                                    
                                    // Mulai baris untuk alternatif
                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$nama_alternatif}</td>";

                                    // Untuk setiap kriteria, ambil nilai yang sesuai
                                    foreach ($kriteria as $k) {
                                        $id_kriteria = $k['id_kriteria'];
                                        $nilai_sub_kriteria = '-';
                                        
                                        // Cari nilai untuk kriteria tertentu
                                        foreach ($rows as $row) {
                                            if ($row['id_kriteria'] == $id_kriteria) {
                                                $nilai_sub_kriteria = $row['nilai_sub_kriteria'];
                                                break;
                                            }
                                        }

                                        echo "<td>{$nilai_sub_kriteria}</td>";
                                    }

                                    // Tutup baris untuk alternatif
                                    echo "</tr>";
                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel Bobot Kriteria dan Nilai Evaluasi Faktor (E) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bobot Kriteria dan Nilai Evaluasi Faktor (E)</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Kriteria</th>
                                    <th>Nama Kriteria</th>
                                    <th>Bobot</th>
                                    <th>Nilai Evaluasi Faktor (E)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Ambil data kriteria
                                $query_kriteria = mysqli_query($koneksi, "SELECT * FROM data_kriteria");
                                $no = 1;

                                // Iterasi untuk menampilkan data kriteria
                                while ($k = mysqli_fetch_assoc($query_kriteria)) {
                                    $id_kriteria = $k['kode'];
                                    $nama_kriteria = $k['nama_kriteria'];
                                    $bobot = $k['bobot'];

                                    // Hitung nilai evaluasi faktor (E)
                                    $nilai_evaluasi_faktor = 0;
                                    foreach ($penilaian as $row) {
                                        if ($row['id_kriteria'] == $id_kriteria) {
                                            // Ambil nilai sub-kriteria yang sudah dinormalisasi
                                            $nilai_sub_kriteria = isset($normalisasi[$row['id_alternatif']][$id_kriteria]) ? $normalisasi[$row['id_alternatif']][$id_kriteria] : 0;
                                            // Nilai evaluasi faktor (E) = Normalisasi * Bobot
                                            $nilai_evaluasi_faktor += $nilai_sub_kriteria * $bobot;
                                        }
                                    }

                                    echo "<tr>";
                                    echo "<td>{$no}</td>";
                                    echo "<td>{$id_kriteria}</td>";
                                    echo "<td>{$nama_kriteria}</td>";
                                    echo "<td>" . number_format($bobot, 4) . "</td>";
                                    echo "<td>" . number_format($nilai_evaluasi_faktor, 4) . "</td>";
                                    echo "</tr>";

                                    $no++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>




        </div>
    </div>
    <?php require 'footer.php'; ?>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>
</html>
