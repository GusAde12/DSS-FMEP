<?php
require 'cek-sesi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Sub-Kriteria</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">
<?php require 'koneksi.php'; ?>
<?php require 'sidebar.php'; ?>

<!-- Main Content -->
<div id="content">

<?php require 'navbar.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

<button type="button" class="btn btn-success" style="margin:5px" data-toggle="modal" data-target="#myModalTambah"><i class="fa fa-plus"> Sub-Kriteria</i></button><br>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Daftar Sub-Kriteria</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID Sub Kriteria</th>
              <th>Nama Kriteria</th>
              <th>Nama Sub Kriteria</th>
              <th>Nilai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>ID Sub Kriteria</th>
              <th>Nama Kriteria</th>
              <th>Nama Sub Kriteria</th>
              <th>Nilai</th>
              <th>Aksi</th>
            </tr>
          </tfoot>
          <tbody>
          <?php 
          $query = "SELECT sk.*, k.nama_kriteria 
                    FROM data_sub_kriteria sk 
                    JOIN data_kriteria k ON sk.id_kriteria = k.id_kriteria";
          $result = mysqli_query($koneksi, $query);
          while ($data = mysqli_fetch_assoc($result)) 
          {
          ?>
            <tr>
              <td><?=$data['id_sub_kriteria']?></td>
              <td><?=$data['nama_kriteria']?></td>
              <td><?=$data['nama_sub_kriteria']?></td>
              <td><?=$data['nilai']?></td>
              <td>
                <!-- Button untuk modal edit -->
                <a href="#" type="button" class="fa fa-edit btn btn-primary btn-md" data-toggle="modal" data-target="#myModal<?=$data['id_sub_kriteria']?>"></a>
              </td>
            </tr>

            <!-- Modal Edit Sub-Kriteria -->
            <div class="modal fade" id="myModal<?=$data['id_sub_kriteria']?>" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Ubah Data Sub-Kriteria</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <form role="form" action="proses-edit-sub-kriteria.php" method="post">
                      <input type="hidden" name="id_sub_kriteria" value="<?=$data['id_sub_kriteria']?>">
                      <div class="form-group">
                        <label>Nama Sub-Kriteria</label>
                        <input type="text" name="nama_sub_kriteria" class="form-control" value="<?=$data['nama_sub_kriteria']?>">
                      </div>
                      <div class="form-group">
                        <label>Nilai</label>
                        <input type="number" step="0.01" name="nilai" class="form-control" value="<?=$data['nilai']?>">
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Ubah</button>
                        <a href="hapus-sub-kriteria.php?id_sub_kriteria=<?=$data['id_sub_kriteria']?>" onclick="return confirm('Anda yakin ingin menghapus?')" class="btn btn-danger">Hapus</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php 
          } 
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php require 'footer.php' ?>

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Modal Tambah Sub-Kriteria -->
<div id="myModalTambah" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Sub-Kriteria</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="tambah-sub-kriteria.php" method="post">
          <div class="form-group">
            <label>Nama Kriteria</label>
            <select name="id_kriteria" class="form-control" required>
              <option value="">-- Pilih Kriteria --</option>
              <?php
              $queryKriteria = "SELECT * FROM data_kriteria";
              $resultKriteria = mysqli_query($koneksi, $queryKriteria);
              while ($kriteria = mysqli_fetch_assoc($resultKriteria)) {
                echo "<option value=\"{$kriteria['id_kriteria']}\">{$kriteria['nama_kriteria']}</option>";
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Nama Sub-Kriteria</label>
            <input type="text" class="form-control" name="nama_sub_kriteria" required>
          </div>
          <div class="form-group">
            <label>Nilai</label>
            <input type="number" step="0.01" class="form-control" name="nilai" required>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Tambah</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Keluar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal -->
<?php require 'logout-modal.php'; ?>

<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>



</body>

</html>
