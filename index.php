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

  <title>Dashboard - Admin</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

<?php
require ('koneksi.php');
require ('sidebar.php');

$jumlah_kriteria = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_kriteria");
$kriteria_data = mysqli_fetch_assoc($jumlah_kriteria);
$total_kriteria = $kriteria_data['total'];

$jumlah_sub_kriteria = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_sub_kriteria");
$sub_kriteria_data = mysqli_fetch_assoc($jumlah_sub_kriteria);
$total_sub_kriteria = $sub_kriteria_data['total'];

$jumlah_alternatif = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_alternatif");
$alternatif_data = mysqli_fetch_assoc($jumlah_alternatif);
$total_alternatif = $alternatif_data['total'];

// $total_karyawan = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM materi");
// $karyawan_data = mysqli_fetch_assoc($total_karyawan);
// $karyawan = $karyawan_data['total'];

// $total_materi = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM materi_bahan_ajar");
// $materi_data = mysqli_fetch_assoc($total_materi);
// $materi = $materi_data['total'];
?>
      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Greeting -->
          <h1>Selamat Datang, <?=$_SESSION['nama']?></h1>

          <?php require 'user.php'; ?>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <!-- <a href="export-data.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Download Data</a>
           -->
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Total Users Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kriteria</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_kriteria?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                      <!-- <i class="fas fa-users fa-2x text-gray-300"></i> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Active Forums Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Sub-Kriteria</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_sub_kriteria?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Events Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Data Alternatif</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$total_alternatif?></div>
                    </div>
                    <div class="col-auto">
                    <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Employees Card -->
            <!-- <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Materi Mata Pelajaran</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$karyawan?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->


            <!-- Total Bahan Ajar -->
            <!-- <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Materi Membaca</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$materi?></div>
                              
                              <a href="materi-bahan-ajar.php" class="btn btn-danger mt-3">Lihat Materi</a>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-briefcase fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div> -->


          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

<?php require 'footer.php'?>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

<?php require 'logout-modal.php'; ?>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
