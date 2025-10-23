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
  <title>Kriteria</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
<?php require 'sidebar.php'; ?>
<div id="content">
  <?php require 'navbar.php'; ?>
  <div class="container-fluid">
    <button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah">
      <i class="fa fa-plus"></i> Tambah Kriteria
    </button>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kriteria</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID Kriteria</th>
                <th>Nama Kriteria</th>
                <th>Bobot</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $query = mysqli_query($koneksi, "SELECT * FROM data_kriteria");
              if (mysqli_num_rows($query) > 0) {
                while ($data = mysqli_fetch_assoc($query)) {
              ?>
              <tr>
                <td><?= $data['kode'] ?></td>
                <td><?= $data['nama_kriteria'] ?></td>
                <td><?= $data['bobot'] ?></td>
                <td>
                    <!-- Button untuk modal -->
<a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?php echo $data['id_kriteria']; ?>"></a>
</td>
</tr>
<!-- Modal Edit Kriteria -->
<div class="modal fade" id="myModal<?php echo $data['id_kriteria']; ?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Data Kriteria</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="proses-edit-kriteria.php" method="post">
        <div class="modal-body">
        
        

        <input type="hidden" name="id_kriteria" value="<?php echo $data['id_kriteria']; ?>">

        <div class="form-group">
            <label>ID Kriteria</label>
            <input type="text" class="form-control" name="kode" value="<?php echo $data['kode']; ?>" readonly>
          </div>

        <div class="form-group">
          <label>Nama Kriteria</label>
          <input type="text" name="nama_kriteria" class="form-control" value="<?php echo $data['nama_kriteria']; ?>">      
        </div>

        <div class="form-group">
          <label>Bobot</label>
          <input type="number" step="0.01" name="bobot" class="form-control" value="<?php echo $data['bobot']; ?>">      
        </div>
        </div>
        
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Ubah</button>
          <a href="hapus-kriteria.php?id_kriteria=<?=$data['id_kriteria'];?>" Onclick="confirm('Anda Yakin Ingin Menghapus?')" class="btn btn-danger">Hapus</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
        </div>
      </form>
    </div>
  </div>
</div>
              </tr>
              <?php } } else { ?>
              <tr>
                <td colspan="4" class="text-center">Tidak ada data kriteria</td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Kriteria -->
<div id="myModalTambah" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kriteria</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="tambah-kriteria.php" method="post">
        <div class="modal-body">
          <?php
          $query_last_id = mysqli_query($koneksi, "SELECT kode FROM data_kriteria ORDER BY kode DESC LIMIT 1");
          $last_id = mysqli_fetch_assoc($query_last_id);
          $next_id_number = $last_id ? (int)substr($last_id['kode'], 1) + 1 : 1;
          $next_id = "C" . $next_id_number;
          ?>
          <div class="form-group">
            <label>ID Kriteria</label>
            <input type="text" class="form-control" name="kode" value="<?= $next_id ?>" readonly>
          </div>
          <div class="form-group">
            <label>Nama Kriteria</label>
            <input type="text" class="form-control" name="nama_kriteria" required>
          </div>
          <div class="form-group">
            <label>Bobot</label>
            <input type="number" step="0.01" class="form-control" name="bobot" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Tambah</button>
        </form>
        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
      </div>
    </div>
  </div>
</div>

<?php require 'footer.php'; ?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="js/sb-admin-2.min.js"></script>
</body>
</html>
