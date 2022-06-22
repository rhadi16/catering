<?php 
	include('template/header.php');
	include('asset/datetime/datetimeFormat.php');
?>

<?php 
  $sess = $_SESSION['user'];

	$qry = "SELECT DISTINCT
						a.id,
						a.id_pelanggan,
						c.nama,
						c.email,
						c.alamat
					FROM penjualan a
					LEFT JOIN list_makanan b ON a.id_menu = b.id_menu
					LEFT JOIN pelanggan c ON a.id_pelanggan = c.id
					WHERE a.`status` = 'proses'";	

	$orderby = "";

  $view   = "pesanan-masuk.php";

  $column = [
              'value'  => ['nama', 'email'],
              'label'  => ['Nama Pelanggan/Toko', 'Email'],
              'type'   => ['text', 'text']
            ];

  $sel_qry = mysqli_query($mysqli, $qry);
  $jum_data = mysqli_num_rows($sel_qry);
?>

	<section id="saran-diskon">
		<div class="container">
			<h5 class="title">Daftar Pelanggan Yang Memesan</h5>
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
	          		<th>Nama Pelanggan/Toko</th>
	          		<th>Email</th>
	          		<th>Alamat</th>
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
							  $dt = mysqli_query($mysqli, "$qry GROUP BY c.nama");
							}else{
							//kondisi jika parameter kolom pencarian diisi
							  $dt = mysqli_query($mysqli, "$qry WHERE $kolomCari LIKE '%$kolomKataKunci%' GROUP BY c.nama");
							}

							while($data = mysqli_fetch_array($dt)) {
						?>
		          <tr>
		          	<td><?php echo $no; ?></td>
		          	<td><?php echo $data['nama']; ?></td>
		          	<td><?php echo $data['email']; ?></td>
		          	<td><?php echo $data['alamat']; ?></td>
		            <td>
		            	<a class="waves-effect waves-light btn modal-trigger" href="detail-pesanan.php?id_pel=<?php echo $data['id_pelanggan']; ?>">Lihat Detail Pesanan</a>
		            </td>
		          </tr>

		        <?php $no++; } ?>
		        </tbody>
		      </table>
				</div>
			</div>
			<?php } ?>
		</div>
	</section>

	<?php
    // error_reporting(0);
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
	  }
	</script>

<?php include('template/footer.php'); ?>