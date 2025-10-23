<?php
require 'cek-sesi.php';
require 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Data Penilaian</title>

  <!-- Custom fonts and styles -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="page-top">
  <?php require 'sidebar.php'; ?>
  <div id="content">
    <?php require 'navbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid">

      <!-- Button Tambah Penilaian -->
      <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#myModalTambahPenilaian">
        <i class="fa fa-plus"></i> Tambah Penilaian
      </button>

      <!-- Modal Tambah -->
      <div class="modal fade" id="myModalTambahPenilaian" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Tambah Penilaian</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="tambah-penilaian.php" method="post">
                <!-- Alternatif -->
                <div class="form-group">
                  <label>Alternatif</label>
                  <select name="id_alternatif" class="form-control" required>
                    <?php
                    $alternatif_query = mysqli_query($koneksi, "SELECT * FROM data_alternatif");
                    while ($alt = mysqli_fetch_assoc($alternatif_query)) {
                      echo "<option value='{$alt['id_alternatif']}'>{$alt['nama_alternatif']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <!-- Sub-Kriteria -->
                <div class="form-group">
                  <label>Sub-Kriteria</label>
                  <select name="id_sub_kriteria" class="form-control sub-kriteria-select" data-nilai-input="nilaiInputTambah" required>
                    <?php
                    // Query untuk mengambil data sub-kriteria beserta kriteria terkait
                    $subkriteria_query = mysqli_query($koneksi, "
                        SELECT sk.id_sub_kriteria, sk.nama_sub_kriteria, sk.nilai, k.nama_kriteria 
                        FROM data_sub_kriteria sk
                        JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria
                    ");
                    // Loop untuk menampilkan opsi dengan nama kriteria
                    while ($sk = mysqli_fetch_assoc($subkriteria_query)) {
                      echo "<option value='{$sk['id_sub_kriteria']}' data-nilai='{$sk['nilai']}'>
                              {$sk['nama_kriteria']} - {$sk['nama_sub_kriteria']}
                            </option>";
                    }
                    ?>
                  </select>
                </div>


                <!-- Nilai -->
                <div class="form-group">
                  <label>Nilai</label>
                  <input type="number" name="nilai" id="nilaiInputTambah" class="form-control" required>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Data Table -->
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Data Penilaian</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>ID Penilaian</th>
                  <th>Alternatif</th>
                  <th>Kriteria</th>
                  <th>Sub-Kriteria</th>
                  <th>Nilai</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $query = mysqli_query($koneksi, "
                    SELECT dp.id_penilaian, dp.id_alternatif, dp.id_sub_kriteria, 
                          a.nama_alternatif, sk.nama_sub_kriteria, k.nama_kriteria, dp.nilai
                    FROM data_penilaian dp
                    JOIN data_alternatif a ON dp.id_alternatif = a.id_alternatif
                    JOIN data_sub_kriteria sk ON dp.id_sub_kriteria = sk.id_sub_kriteria
                    JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria
                ");

                while ($data = mysqli_fetch_assoc($query)) {
                ?>
                  <tr>
                    <td><?= $data['id_penilaian'] ?></td>
                    <td><?= $data['nama_alternatif'] ?></td>
                    <td><?= $data['nama_kriteria'] ?></td>
                    <td><?= $data['nama_sub_kriteria'] ?></td>
                    <td><?= $data['nilai'] ?></td>
                    <td>
                      <!-- Button Edit -->
                      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEditPenilaian<?= $data['id_penilaian'] ?>">
                        <i class="fa fa-edit"></i> Edit
                      </button>
                      <!-- Button Hapus -->
                      <a href="hapus-penilaian.php?id_penilaian=<?= $data['id_penilaian'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?')">
                        <i class="fa fa-trash"></i> Hapus
                    </td>
                  </tr>

                  <!-- Modal Edit -->
                  <div class="modal fade" id="myModalEditPenilaian<?= $data['id_penilaian'] ?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Edit Penilaian</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form action="proses-edit-penilaian.php" method="post">
                            <input type="hidden" name="id_penilaian" value="<?= $data['id_penilaian'] ?>">

                            <!-- Alternatif -->
                            <div class="form-group">
                              <label>Alternatif</label>
                              <select name="id_alternatif" class="form-control" required>
                                <?php
                                $alternatif_query = mysqli_query($koneksi, "SELECT * FROM data_alternatif");
                                while ($alt = mysqli_fetch_assoc($alternatif_query)) {
                                  $selected = $alt['id_alternatif'] == $data['id_alternatif'] ? 'selected' : '';
                                  echo "<option value='{$alt['id_alternatif']}' $selected>{$alt['nama_alternatif']}</option>";
                                }
                                ?>
                              </select>
                            </div>

                            <!-- Sub-Kriteria -->
                            <div class="form-group">
                              <label>Sub-Kriteria</label>
                              <select name="id_sub_kriteria" class="form-control sub-kriteria-select" data-nilai-input="nilaiInput<?= $data['id_penilaian'] ?>" required>
                                <?php
                                // Query untuk mengambil data sub-kriteria beserta kriteria terkait
                                $subkriteria_query = mysqli_query($koneksi, "
                                    SELECT sk.id_sub_kriteria, sk.nama_sub_kriteria, sk.nilai, k.nama_kriteria 
                                    FROM data_sub_kriteria sk
                                    JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria
                                ");
                                // Loop untuk menampilkan opsi dengan nama kriteria
                                while ($sk = mysqli_fetch_assoc($subkriteria_query)) {
                                  // Menentukan opsi yang dipilih (selected)
                                  $selected = $sk['id_sub_kriteria'] == $data['id_sub_kriteria'] ? 'selected' : '';
                                  echo "<option value='{$sk['id_sub_kriteria']}' data-nilai='{$sk['nilai']}' $selected>
                                          {$sk['nama_kriteria']} - {$sk['nama_sub_kriteria']}
                                        </option>";
                                }
                                ?>
                              </select>
                            </div>


                            <!-- Nilai -->
                            <div class="form-group">
                              <label>Nilai</label>
                              <input type="number" name="nilai" id="nilaiInput<?= $data['id_penilaian'] ?>" class="form-control" value="<?= $data['nilai'] ?>" required>
                            </div>

                            <div class="modal-footer">
                              <button type="submit" class="btn btn-success">Simpan</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- Script for Auto-Updating Nilai -->
<script>
  $('.sub-kriteria-select').change(function () {
    const nilai = $(this).find('option:selected').data('nilai');
    const targetInput = $(this).data('nilai-input');
    $('#' + targetInput).val(nilai);
  });
</script>
</html>


  <?php require 'footer.php'; ?>



  <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="js/demo/datatables-demo.js"></script>
</body>

</html>
