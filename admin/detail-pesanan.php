<?php 
	include('template/header.php');
	include('asset/datetime/datetimeFormat.php');
?>

<?php 
  $sess = $_SESSION['user'];
  $id_pel = $_GET['id_pel'];

	$qry = "SELECT
					a.id,
					a.id_pelanggan,
					b.id_menu,
					b.nama_menu,
					b.harga,
					a.jum_yg_dibeli,
					a.tot_harga,
					a.tanggal,
					c.nama,
					c.email,
					a.status
				FROM penjualan a
				LEFT JOIN list_makanan b ON a.id_menu = b.id_menu
				LEFT JOIN pelanggan c ON a.id_pelanggan = c.id";

	$orderby = "tanggal";

  $view   = "pesanan-masuk.php";

  $column = [
              'value'  => ['nama_menu', 'email','nama'],
              'label'  => ['Nama Menu', 'Email', 'Nama Pelanggan'],
              'type'   => ['text', 'text', 'text']
            ];

  $sel_qry = mysqli_query($mysqli, $qry);
  $jum_data = mysqli_num_rows($sel_qry);
?>

	<section id="saran-diskon">
		<div class="container">
			<h5 class="title">Detail Pesanan Pelanggan</h5>
			<a class="waves-effect waves-light btn light-blue darken-1" id="tambah-kolom" href="pesanan-masuk.php"><i class="material-icons left">near_me</i>Daftar Pesanan</a>
			<?php 
			 if ($jum_data == 0) {
			?>
				<h5 class="center-align title-form red-text text-darken-1">Belum Ada Pesanan Yang Masuk</h5>	
			<?php } else { ?>

      <div class="container pencarian-barang">
        <div class="card">
          <?php include('../paginasi/pencarian.php'); ?>
        </div>
      </div>

			<div class="list">
				<div class="card-panel">
					<table class="striped centered responsive-table">
		        <thead>
		          <tr>
	          		<th>No.</th>
	          		<th>Nama Pelanggan</th>
	              <th>Nama Menu</th>
	              <th>Harga</th>
	              <th>Quantity</th>
	              <th>Total</th>
	              <th>Tanggal</th>
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
							  $dt = mysqli_query($mysqli, "$qry WHERE id_pelanggan = $id_pel AND status = 'proses' ORDER BY $orderby ASC");
							}else{
							//kondisi jika parameter kolom pencarian diisi
							  $dt = mysqli_query($mysqli, "$qry WHERE $kolomCari LIKE '%$kolomKataKunci%' AND id_pelanggan = $id_pel AND status = 'proses' ORDER BY $orderby ASC");
							}

							while($data = mysqli_fetch_array($dt)) {
						?>
		          <tr>
		          	<td><?php echo $no; ?></td>
		          	<td><?php echo $data['nama']; ?></td>
		            <td><?php echo $data['nama_menu']; ?></td>
		            <td>Rp. <?php echo number_format($data['harga'],0,",","."); ?> </td>
		            <td><?php echo $data['jum_yg_dibeli']; ?></td>
		            <td>Rp. <?php echo number_format($data['tot_harga'],0,",","."); ?> </td>
		            <td><?php echo datetimeFormat::TanggalIndo($data['tanggal']); ?></td>
		            <td>
		            	<a class="waves-effect waves-light btn modal-trigger lime darken-1" href="#edit-pesanan<?php echo $data['id']; ?>">Edit Quantity</a>
		            	<a class="waves-effect waves-light btn modal-trigger red darken-1 hapus-pesanan<?php echo $data['id']; ?>" style="cursor: pointer;">Hapus Pesanan</a>
		            	<a class="waves-effect waves-light btn modal-trigger" href="#konfir-pesanan<?php echo $data['id']; ?>">Konfirmasi Pesanan</a>
		            </td>
		          </tr>

		          <script type="text/javascript">
					      $('.hapus-pesanan<?php echo $data['id']; ?>').on('click', function(e) {
					        Swal.fire({
					          title: 'Anda Yakin?',
					          text: "Menghapus Pesanan <?php echo $data['nama_menu']; ?>",
					          icon: 'warning',
					          showCancelButton: true,
					          confirmButtonColor: '#3085d6',
					          cancelButtonColor: '#d33',
					          confirmButtonText: 'Ya, Yakin!'
					        }).then((result) => {
					          if (result.isConfirmed) {
					            window.location.href = "<?php echo 'func/pesan_func.php?action=delete&id='.$data['id'].'&id_menu='.$data['id_menu'].'&id_pelanggan='.$id_pel ?>";
					          }
					        })
					      });
					    </script>

		          <!-- Modal Structure -->
						  <div id="edit-pesanan<?php echo $data['id']; ?>" class="modal input-dispro">
						  	<form action="func/pesan_func.php?action=update" enctype="multipart/form-data" method="post">
							    <div class="modal-content">
							      <h4>Edit Jumah Pesanan</h4>
							      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							      <input type="hidden" name="id_menu" value="<?php echo $data['id_menu']; ?>">
							      <input type="hidden" name="id_pelanggan" value="<?php echo $id_pel ?>">
							      <div class="row">
							      	<div class="input-field col s12">
							          <input id="nama_menu" type="text" class="validate" name="nama_menu" value="<?php echo $data['nama_menu']; ?>" readonly>
							          <label for="nama_menu">Nama Menu</label>
							        </div>
							        <div class="input-field col s12">
							        	<input type="hidden" name="jum_yg_dibeli_lama" value="<?php echo $data['jum_yg_dibeli']; ?>">
							          <input id="jum_yg_dibeli" type="text" class="validate" name="jum_yg_dibeli" value="<?php echo $data['jum_yg_dibeli']; ?>">
							          <label for="jum_yg_dibeli">Quantity</label>
							        </div>
					      		</div>
							    </div>
							    <div class="modal-footer">
							      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
				      			<button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Ubah</button>
							    </div>
						  	</form>
						  </div>

						  <!-- Modal Structure -->
						  <div id="konfir-pesanan<?php echo $data['id']; ?>" class="modal input-dispro">
						  	<form action="func/pesan_func.php?action=insert" enctype="multipart/form-data" method="post">
							    <div class="modal-content">
							      <h4>Konfirmasi Pesanan</h4>
							      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
							      <input type="hidden" name="id_admin" value="<?php echo $sess; ?>">
							      <input type="hidden" name="status" value="selesai">
							      <div class="row">
							      	<div class="input-field col s12">
							          <input id="nama_pelanggan" type="text" class="validate" name="nama_pelanggan" value="<?php echo $data['nama']; ?>" readonly>
							          <label for="nama_pelanggan">Nama Pelanggan</label>
							        </div>
							      	<div class="input-field col s12">
							          <input id="nama_menu" type="text" class="validate" name="nama_menu" value="<?php echo $data['nama_menu']; ?>" readonly>
							          <label for="nama_menu">Nama Menu</label>
							        </div>
							        <div class="input-field col s12">
							          <input id="jum_yg_dibeli" type="text" class="validate" name="jum_yg_dibeli" value="<?php echo $data['jum_yg_dibeli']; ?>" readonly>
							          <label for="jum_yg_dibeli">Quantity</label>
							        </div>
							        <div class="input-field col s12">
							          <input id="tot_yg_dibeli" type="text" class="validate" name="tot_yg_dibeli" value="Rp. <?php echo number_format($data['tot_harga'],0,',','.'); ?>" readonly>
							          <label for="tot_yg_dibeli">Total Harga</label>
							        </div>
					      		</div>
							    </div>
							    <div class="modal-footer">
							      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
				      			<button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Konfirmasi</button>
							    </div>
						  	</form>
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
    if ($desc == "success-ed") {
	?>
	  <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-ed") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "success-del") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-del") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "success-in") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-ed2") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } ?>

	<script type="text/javascript">
		const desc_in = $('.desc-in').data('flashdata')
	  if (desc_in == "success-ed") {
	    Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Perubahan Jumlah Pesanan',
	      'success'
	    )
	  } else if (desc_in == "failed-ed") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Perubahan Jumlah Pesanan',
	      'error'
	    )
	  } else if (desc_in == "success-del") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penghapusan Pesanan',
	      'success'
	    )
	  } else if (desc_in == "failed-del") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penghapusan Pesanan',
	      'error'
	    )
	  } else if (desc_in == "success-in") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Konfirmasi Pesanan',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Konfirmasi Pesanan',
	      'error'
	    )
	  } else if (desc_in == "failed-ed2") {
	  	Swal.fire(
	      'Gagal!',
	      'Jumlah Quantity Melebihi Stok',
	      'error'
	    )
	  }
	</script>

<?php include('template/footer.php'); ?>