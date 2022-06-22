<?php 
	include('template/header.php'); 
	include('asset/datetime/datetimeFormat.php');
?>
<link rel="stylesheet" type="text/css" href="asset/css/pembelian-penjualan-style.css">
<?php 
	$id_admin = $_SESSION['user'];

	if ($id_admin == 1) {
		$qry    = "SELECT 
							a.*,
							b.nama_barang,
							b.stok
						FROM pembelian a
						LEFT JOIN list_barang b ON a.id_barang=b.id_barang";
	} else {
		$qry    = "SELECT 
							a.*,
							b.nama_barang,
							b.stok
						FROM pembelian a
						LEFT JOIN list_barang b ON a.id_barang=b.id_barang
						WHERE id_admin = $id_admin";
	}
      
  $orderby = "id"; 

  $view   = "pembelian.php";

  $column = [
              'value'  => ['nama_barang', 'stok'],
              'label'  => ['Nama Barang', 'Stok Barang'],
              'type'   => ['text', 'int']
            ];

  $sel_qry = mysqli_query($mysqli, "SELECT * FROM pembelian");
  $jum_data = mysqli_num_rows($sel_qry);
?>

	<section id="pembelian">
		<div class="container">
			<h5 class="center-align title-form">Form Tambah Pembelian</h5>
			<a class="waves-effect waves-light btn  light-blue darken-1" id="tambah-kolom"><i class="material-icons left">add</i>Tambah Form Isian</a>
			<div class="row">
				<form action="func/pembelian_func.php?action=insert" enctype="multipart/form-data" method="post">
				<div class="element col s12" id="div_1">
			    <div id="txt_1">
			      <div class="card-panel bg">
							<div class="row">
						    <div class="col s12 m6 l3">
					        <div class="ui-widget input-field">
					          <select id="combobox1" name="id_barang[]" required>
					            <option value="">Select one...</option>
					            <?php 
                        $qry1 = "SELECT * FROM list_barang";

                        $dt1 = mysqli_query($mysqli, $qry1);

                        while($data1 = mysqli_fetch_array($dt1)){
                      ?>
						            <option value="<?php echo $data1['id_barang'].'||'.$data1['stok']; ?>"><?php echo $data1['nama_barang']; ?></option>
					          	<?php } ?>
					          </select>
					          <label>Pilih Barang</label>
					        </div>
						    </div>
						    <div class="input-field col s12 m6 l3">
				          <input placeholder="" id="harga_yg_dibeli" type="number" class="validate" name="harga_yg_dibeli[]" required>
				          <label for="harga_yg_dibeli">Harga Total</label>
				        </div>
				        <div class="input-field col s12 m6 l3">
				          <input placeholder="" id="stok_yg_dibeli" type="number" class="validate" name="stok_yg_dibeli[]" required>
				          <label for="stok_yg_dibeli">Jumlah Barang</label>
				        </div>
				        <div class="input-field col s12 m6 l3">
				          <input placeholder="" id="tanggal" type="text" class="validate datepicker" name="tanggal[]" required>
				          <label for="tanggal">Tanggal Beli</label>
				        </div>
				        <input type="hidden" name="id_admin" value="<?php echo $id_admin; ?>">
						  </div>
			      </div>
			    </div>
				</div>
				<div class="col s12">
					<button type="submit" class="waves-effect waves-light btn green darken-1" id="input-pembelian"><i class="material-icons left">send</i>Input</button>
				</div>
				</form>
		  </div>
		</div>

		<div class="container list-barang">
			<?php 
			 if ($jum_data == 0) {
			?>
				<h5 class="center-align title-form red-text text-darken-1">Pembelian Belum Ada</h5>	
			<?php } else { ?>
			<h5 class="center-align title-form">List Pembelian</h5>
			<div class="pencarian-barang">
        <div class="card-panel bg">
          <?php include('../paginasi/pencarian.php'); ?>
        </div>
      </div>
			<div class="btn-delete center-align">
				<?php 
					$data_pembelian = mysqli_query($mysqli, "SELECT * FROM pembelian");

					$jum_pembelian = mysqli_num_rows($data_pembelian);

					if ($jum_pembelian > 0) {
				?>
					<a class="waves-effect waves-light btn red darken-1 confirm-delete-all-stok" style="cursor: pointer;">Hapus Semua Stok</a>
					<a class="waves-effect waves-light btn lime darken-1 confirm-delete-all-data" style="cursor: pointer;">Hapus Semua Data</a>
				<?php } ?>

				<script type="text/javascript">
		      $('.confirm-delete-all-stok').on('click', function(e) {
		        Swal.fire({
		          title: 'Anda Yakin?',
		          text: "Menghapus Semua Barang, Jumlah Stok Barang Juga Akan Berkurang Di List Barang!",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Ya, Yakin!'
		        }).then((result) => {
		          if (result.isConfirmed) {
		            window.location.href = "<?php echo 'func/pembelian_func.php?action=delete-all-stok'?>";
		          }
		        })
		      });

		      $('.confirm-delete-all-data').on('click', function(e) {
		        Swal.fire({
		          title: 'Anda Yakin?',
		          text: "Menghapus Semua Barang, Jumlah Stok Barang Tidak Akan Berkurang Di List Barang!",
		          icon: 'warning',
		          showCancelButton: true,
		          confirmButtonColor: '#3085d6',
		          cancelButtonColor: '#d33',
		          confirmButtonText: 'Ya, Yakin!'
		        }).then((result) => {
		          if (result.isConfirmed) {
		            window.location.href = "<?php echo 'func/pembelian_func.php?action=delete-all-data'?>";
		          }
		        })
		      });
		    </script>
			</div>
			<div class="card-panel">
				<table class="striped centered responsive-table">
	        <thead>
	          <tr>
	          		<th>No.</th>
	              <th>Nama Barang</th>
	              <th>Stok Yang Dibeli</th>
	              <th>Harga</th>
	              <th>Stok Sekarang</th>
	              <th>Tanggal</th>
	              <th>aksi</th>
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
						  $dt = mysqli_query($mysqli, "$qry ORDER BY $orderby DESC");
						}else{
						//kondisi jika parameter kolom pencarian diisi
						  $dt = mysqli_query($mysqli, "$qry WHERE $kolomCari LIKE '%$kolomKataKunci%'");
						}

						while($data = mysqli_fetch_array($dt)) {
					?>
	          <tr>
	          	<td><?php echo $no; ?></td>
	            <td><?php echo $data['nama_barang']; ?></td>
	            <td><?php echo $data['stok_yg_dibeli']; ?></td>
	            <td>Rp. <?php echo number_format($data['harga_yg_dibeli'],0,",","."); ?></td>
	            <td><?php echo $data['stok']; ?></td>
	            <td><?php echo datetimeFormat::TanggalIndo($data['tanggal']); ?></td>
	            <td>
	            	<a class="waves-effect waves-light btn red darken-1 confirm-delete-stok<?php echo $data['id']; ?>" style="cursor: pointer;">Hapus Stok</a>
	            	<a class="waves-effect waves-light btn lime darken-1 confirm-delete-data<?php echo $data['id']; ?>" style="cursor: pointer;">Hapus Data</a>
	            </td>
	          </tr>
	          <script type="text/javascript">
				      $('.confirm-delete-stok<?php echo $data['id']; ?>').on('click', function(e) {
				        Swal.fire({
				          title: 'Anda Yakin?',
				          text: "Menghapus Barang <?php echo $data['nama_barang']; ?>, Jumlah Stok Barang Juga Akan Berkurang Di List Barang!",
				          icon: 'warning',
				          showCancelButton: true,
				          confirmButtonColor: '#3085d6',
				          cancelButtonColor: '#d33',
				          confirmButtonText: 'Ya, Yakin!'
				        }).then((result) => {
				          if (result.isConfirmed) {
				            window.location.href = "<?php echo 'func/pembelian_func.php?action=delete-stok&id='.$data['id'].'&id_barang='.$data['id_barang'] ?>";
				          }
				        })
				      });

				      $('.confirm-delete-data<?php echo $data['id']; ?>').on('click', function(e) {
				        Swal.fire({
				          title: 'Anda Yakin?',
				          text: "Menghapus Barang <?php echo $data['nama_barang']; ?>, Jumlah Stok Barang Tidak Akan Berkurang Di List Barang!",
				          icon: 'warning',
				          showCancelButton: true,
				          confirmButtonColor: '#3085d6',
				          cancelButtonColor: '#d33',
				          confirmButtonText: 'Ya, Yakin!'
				        }).then((result) => {
				          if (result.isConfirmed) {
				            window.location.href = "<?php echo 'func/pembelian_func.php?action=delete-data&id='.$data['id'] ?>";
				          }
				        })
				      });
				    </script>
	        <?php $no++; } ?>
	        </tbody>
	      </table>
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
	<?php } elseif ($desc == "success-ed") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-ed") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "success-del") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-del") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } ?>

	<script type="text/javascript">
  
	  const desc_in = $('.desc-in').data('flashdata')
	  if (desc_in == "success-in") {
	    Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penambahan Jumlah Barang',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penambahan Jumlah Barang',
	      'error'
	    )
	  } else if (desc_in == "success-ed") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Perubahan Barang',
	      'success'
	    )
	  } else if (desc_in == "failed-ed") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Perubahan Barang',
	      'error'
	    )
	  } else if (desc_in == "success-del") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penghapusan Barang',
	      'success'
	    )
	  } else if (desc_in == "failed-del") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penghapusan Barang',
	      'error'
	    )
	  }

	</script>

<?php include('template/footer.php'); ?>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="asset/js/jquery-ui.js"></script>
<script type="text/javascript" src="asset/js/pembelian-script.js"></script>