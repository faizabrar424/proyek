
<?php 
include "koneksi.php";

$sql = mysqli_query($koneksi, "SELECT* FROM kontrol");
$data = mysqli_fetch_array($sql);

$pintu = $data['pintu'];

session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php");
    exit;
}

// Ambil data pengguna dari session
$loggedin_username = $_SESSION['username'];


$koneksi = mysqli_connect($servername, $username, $password, $dbname);
if ($koneksi->connect_error) {
    die("Koneksi ke database gagal: " . $koneksi->connect_error);
}

// Query untuk mengambil data pengguna dari database
$query = "SELECT * FROM users WHERE username = '$loggedin_username'";
$result = $koneksi->query($query);
$row = $result->fetch_assoc();


// Tutup koneksi ke database
$koneksi->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>WLDM - Dashboard</title>
  <link href="vendor/huruf/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    .nav-item.active .nav-link:hover{color: rgb(76, 96, 218);}
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
        <div class="sidebar-brand-icon">
          <img src="img/logo/bendungan_putih.svg">
        </div>
        <div class="sidebar-brand-text mx-3">WLDM</div>
      </a>
      <li class="nav-item active">
        <a class="nav-link" href="dashboard.php">
          <i class="fas fa-10x fa-brands fa-codepen"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <li class="nav-item active">
        <a class="nav-link" href="datatables.php">
          <i class="fas fa-fw fa-solid fa-table-list"></i>
          <span>Table</span>
        </a>
      </li>
    </ul>

    <!-- Topbar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <nav class=" navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-sm-block"></div>
            <li class="nav-item active">
              <a class="nav-link" href="logout.php">
                <i class="fa-solid fa-right-from-bracket" style="margin-right: 15px;"></i>
                <span>Log Out</span></a>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <script>
            function ubahposisi(nilai) {
              const posisi = parseInt(nilai);
              const posisiLabel = document.getElementById('posisi');

              if (posisi === 0) {
                posisiLabel.innerText = 'Tertutup';
              } else if (posisi === 90) {
                posisiLabel.innerText = 'Terbuka setengah';
              } else if (posisi === 180) {
                posisiLabel.innerText = 'Terbuka';
              }

              // Simpan nilai posisi ke local storage
              localStorage.setItem('status_pintu', posisi);

              // Ajax untuk mengubah nilai servo
              var xmlhttp = new XMLHttpRequest();

              xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                  document.getElementById('posisi').innerHTML = xmlhttp.responseText;
                }
              }
              // Mengirim nilai posisi ke file PHP untuk memperbarui nilai database
              xmlhttp.open("GET", "pintu.php?posisi=" + posisi, true);
              xmlhttp.send();
            }

            // Periksa dan kembalikan nilai dari local storage saat halaman dimuat
            window.onload = function() {
              const statusPintu = localStorage.getItem('status_pintu');
              if (statusPintu !== null) {
                ubahposisi(statusPintu);
              }
            };
          </script>


          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <!-- Kartu Pintu -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="h5 mb-0 font-weight-bold text-gray-800">Kontrol Pintu</div>
                      <div class="mt-2 mb-0 text-muted text-xs">
                      <form>
                        <div class="form-group">
                          <!---range--->
                          <label for="formControlRange"><span id="posisi"><?php echo $pintu; ?></span></label>
                          <input type="range" class="form-control-range" id="pintu2"
                          min="0" max="180" step="90" value="<?php echo $pintu; ?>" onchange="ubahposisi(this.value)">
                        </div>
                      </form>

                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-solid fa-door-closed fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Ketinggian Air Bendungan</h6>
                </div>
                <div class="card-body">
                  <div class="chart-area">
                    <canvas id="grafik_air"></canvas>
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); 
            </script> -By Faiz Abrar</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>

  <!-- script diagram-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="chart.php"></script>

</body>

</html>