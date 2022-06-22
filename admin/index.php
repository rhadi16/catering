<?php include('template/header.php'); ?>

	<section id="hal-utama">
		<div class="container">
			<div class="container">
				<div class="row">
			    <div class="col s12">
			      <div class="card-panel blue darken-2 center-align">
			        <div class="row">
			        	<?php if ($_SESSION['user'] == 1) { ?>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn brown darken-1" href="pegawai.php">Kelola Pegawai</a>
			        	</div>
			        	<?php } ?>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn blue-grey lighten-2" href="menu-makanan.php">Kelola Menu Makanan</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn amber darken-4" href="pesanan-masuk.php">Pesanan Masuk</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn yellow darken-1" href="penjualan.php">Kelola Penjualan</a>
			        	</div>
			        	<!-- <div class="col s12">
			        		<a class="waves-effect waves-light btn amber darken-1" href="pembelian.php">Kelola Pembelian</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn lime darken-1" href="cetak-semua-pembelian.php" target="_blank">Cetak Semua Barang Masuk</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn light-green darken-1 modal-trigger" href="#cetak-beberapa-pembelian">Cetak Beberapa Barang Masuk</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn green darken-1" href="cetak-semua-penjualan.php" target="_blank">Cetak Semua Penjualan</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn teal darken-1 modal-trigger" href="#cetak-beberapa-penjualan">Cetak Beberapa Penjualan</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn light-blue darken-1" href="cetak-penghasilan.php" target="_blank">Cetak Pengahasilan</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn indigo darken-1" href="saran-diskon.php">Saran Untuk Menentukan Diskon</a>
			        	</div> -->
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

	  <!-- Modal Structure -->
	  <div id="cetak-beberapa-pembelian" class="modal">
	  	<form action="cetak-beberapa-pembelian.php" method="post" target="_blank">
		    <div class="modal-content">
		      <h4 class="center-align">Cetak Laporan Barang Masuk</h4>
		      <div class="row">
		      	<div class="input-field col s12 m6">
		          <input type="text" class="datepicker" name="tanggal_awal">
		          <label for="from">Dari Tanggal</label>
		        </div>
		        <div class="input-field col s12 m6">
		          <input type="text" class="datepicker" name="tanggal_akhir">
		          <label for="to">Sampai Tanggal</label>
		        </div>
		      </div>
		    </div>
		    <div class="modal-footer">
		      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
					<button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">local_printshop</i>cetak</button>
		    </div>
	  	</form>
	  </div>

	  <!-- Modal Structure -->
	  <div id="cetak-beberapa-penjualan" class="modal">
	  	<form action="cetak-beberapa-penjualan.php" method="post" target="_blank">
		    <div class="modal-content">
		      <h4 class="center-align">Cetak Laporan Penjualan</h4>
		      <div class="row">
		      	<div class="input-field col s12 m6">
		          <input type="text" class="datepicker" name="tanggal_awal">
		          <label for="from">Dari Tanggal</label>
		        </div>
		        <div class="input-field col s12 m6">
		          <input type="text" class="datepicker" name="tanggal_akhir">
		          <label for="to">Sampai Tanggal</label>
		        </div>
		      </div>
		    </div>
		    <div class="modal-footer">
		      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
					<button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">local_printshop</i>cetak</button>
		    </div>
	  	</form>
	  </div>
	</section>

	<?php
    error_reporting(0);
    $desc = $_GET['desc']; 
    if ($desc == "success-adm") {
	?>
	  <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-adm") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } ?>

<?php include('template/footer.php'); ?>

<script type="text/javascript">
	$(document).ready(function(){
    $('.datepicker').datepicker({
    	format: 'yyyy-mm-dd'
    });
  });

  const desc_in = $('.desc-in').data('flashdata')
	  if (desc_in == "success-adm") {
	    Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Perubahan Admin',
	      'success'
	    )
	  } else if (desc_in == "failed-adm") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Perubahan Admin',
	      'error'
	    )
	  }
</script>