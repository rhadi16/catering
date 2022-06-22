<?php 
    session_start();
    include "config/auth.php";
?>
<?php 
  include("config/connect.php");

	if(!isset($_SESSION['user'])){
	    // fungsi redirect menggunakan javascript
	    echo '<script language="javascript"> window.location.href = "../index.php" </script>';
	}
  if($_SESSION['utenti'] != "admin"){
      // fungsi redirect menggunakan javascript
      echo '<script language="javascript"> window.location.href = "../pelanggan" </script>';
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Signika&family=Varela+Round&display=swap" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="asset/css/style.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Catering Abah Ayi</title>
</head>
<body>
	<div class="navbar-fixed">
      <nav class="indigo darken-4">
        <div class="container">
          <div class="nav-wrapper">
            <a href="index.php" class="brand-logo">Catering Abah Ayi</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a href="index.php">Utama</a></li>
              <!-- <?php if ($_SESSION['user'] == 1) { ?>
                <li><a href="pegawai.php">Pegawai</a></li>
              <?php } ?>
              <li><a href="list-barang.php">Kelola Barang</a></li>
              <li><a href="pembelian.php">Kelola Pembelian</a></li>
              <li><a href="penjualan.php">Kelola Penjualan</a></li> -->
              <li><a class="waves-effect waves-light btn modal-trigger red darken-4 confirmation-logout" style="cursor: pointer;">Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <ul class="sidenav" id="mobile-demo">
      <li><a href="index.php">Utama</a></li>
      <!-- <li><a href="pegawai.php">Pegawai</a></li>
      <li><a href="list-barang.php">Kelola Barang</a></li>
      <li><a href="pembelian.php">Kelola Pembelian</a></li>
      <li><a href="penjualan.php">Kelola Penjualan</a></li> -->
      <li><a class="waves-effect waves-light btn modal-trigger red darken-4 confirmation-logout" style="cursor: pointer;">Logout</a></li>
    </ul>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="asset/sweetalert/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
      $('.confirmation-logout').on('click', function(e) {
        Swal.fire({
          title: 'Anda Yakin?',
          text: "Ingin Logout!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, Yakin!'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href = "<?php echo '../index.php?logout=1' ?>";
          }
        })
      });
    </script>