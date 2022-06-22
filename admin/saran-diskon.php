<?php 
	include('template/header.php');
	include('asset/datetime/datetimeFormat.php');
?>

<?php 

	$qry = "SELECT 
						* 
					FROM list_barang
					WHERE tgl_expire <= CURDATE() + INTERVAL 3 MONTH";

	$orderby = "tgl_expire";

  $view   = "saran-diskon.php";

  $column = [
              'value'  => ['nama_barang'],
              'label'  => ['Nama Barang'],
              'type'   => ['text']
            ];

  $sel_qry = mysqli_query($mysqli, $qry);
  $jum_data = mysqli_num_rows($sel_qry);
?>

	<section id="saran-diskon">
		<div class="container">
			<h5 class="title">Kelola Diskon Atau Promo Barang</h5>
			<?php 
			 if ($jum_data == 0) {
			?>
				<h5 class="center-align title-form red-text text-darken-1">Belum Ada Saran yang Cocok untuk Diberikan</h5>	
			<?php } else { ?>

      <div class="container pencarian-barang">
        <div class="card">
          <?php include('../paginasi/pencarian.php'); ?>
        </div>
      </div>

			<div class="list">
			<h5 class="title">List Barang yang Akan Expire Dalam 3 Bulan, Disarankan untuk Diberikan Diskon Atau Promo</h5>
				<div class="card-panel">
					<table class="striped centered responsive-table">
		        <thead>
		          <tr>
	          		<th>No.</th>
	              <th>Nama Barang</th>
	              <th>Promo</th>
	              <th>Diskon</th>
	              <th>Tanggal Expire</th>
	              <th>Aksi</th>
		          </tr>
		        </thead>

		        <tbody>
		        <?php 
		        	$no = 1;
							$page = (isset($_GET['page']))? (int) $_GET['page'] : 1;
							$kolomCari=(isset($_GET['Kolom']))? $_GET['Kolom'] : "";
							$kolomKataKunci=(isset($_GET['KataKunci']))? $_GET['KataKunci'] : "";

							//kondisi jika parameter pencarian kosong
							if($kolomCari=="" && $kolomKataKunci==""){
							  $dt = mysqli_query($mysqli, "$qry ORDER BY $orderby ASC");
							}else{
							//kondisi jika parameter kolom pencarian diisi
							  $dt = mysqli_query($mysqli, "$qry AND $kolomCari LIKE '%$kolomKataKunci%' ORDER BY $orderby ASC");
							}

							while($data = mysqli_fetch_array($dt)) {
						?>
		          <tr>
		          	<td><?php echo $no; ?></td>
		            <td><?php echo $data['nama_barang']; ?></td>
		            <td><?php echo $data['promo']; ?></td>
		            <td><?php echo $data['diskon']; ?>%</td>
		            <td><?php echo datetimeFormat::TanggalIndo($data['tgl_expire']); ?></td>
		            <td><a class="waves-effect waves-light btn modal-trigger green" href="#input-dispro<?php echo $data['id_barang']; ?>">Input Diskon/Promo</a></td>
		          </tr>

		          <!-- Modal Structure -->
						  <div id="input-dispro<?php echo $data['id_barang']; ?>" class="modal input-dispro">
						  	<?php 
						  		if ($data['tgl_expire'] < date('Y-m-d')) {
						  	?>
						  	<div class="modal-content">
						      <p style="color: #C00; text-align: center;"><b>Barang Sudah Expired</b></p>
						    </div>
						    <div class="modal-footer">
						      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
			      			<a class="waves-effect waves-light btn light-green accent-4" href="list-barang.php">Ke List Barang</a>
						    </div>
						  	<?php 
						  		} else {
						  	?>
							  	<form action="func/list_barang_func.php?action=dispro" enctype="multipart/form-data" method="post">
								    <div class="modal-content">
								      <h4>Input Diskon/Promo</h4>
								      <input type="hidden" name="id_barang" value="<?php echo $data['id_barang']; ?>">
								      <div class="row">
								      	<div class="input-field col s12">
								          <input id="nama_barang" type="text" class="validate" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" readonly>
								          <label for="nama_barang">Nama Barang</label>
								        </div>
								        <div class="input-field col s12">
								          <input id="promo" type="text" class="validate" name="promo" value="<?php echo $data['promo']; ?>">
								          <label for="promo">Promo (Boleh Tidak Diisi)</label>
								        </div>
								        <div class="input-field col s12">
								          <input id="diskon" type="number" class="validate" name="diskon" value="<?php echo $data['diskon']; ?>">
								          <label for="diskon">Diskon (0-100)%</label>
								        </div>
						      		</div>
								    </div>
								    <div class="modal-footer">
								      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
					      			<button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Tambah</button>
								    </div>
							  	</form>
							  <?php } ?>
						  </div>
		        <?php $no++; } ?>
		        </tbody>
		      </table>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>

	<?php
    error_reporting(0);
    $desc = $_GET['desc']; 
    if ($desc == "success-in") {
	?>
	  <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-in") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } ?>

	<script type="text/javascript">
		const desc_in = $('.desc-in').data('flashdata')
	  if (desc_in == "success-in") {
	    Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penambahan Diskon/Promo',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penambahan Diskon/Promo',
	      'error'
	    )
	  }
	</script>

<?php include('template/footer.php'); ?>