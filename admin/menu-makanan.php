<?php 
	include('template/header.php');
	include('asset/datetime/datetimeFormat.php');
?>

<?php 

	$qry = "SELECT * FROM list_makanan";

	$orderby = "";

  $view   = "menu-makanan.php";

  $column = [
              'value'  => ['nama_menu', 'harga', 'stok', 'kategori'],
              'label'  => ['Nama Menu', 'Harga Menu', 'Stok', 'Kategori'],
              'type'   => ['text', 'double', 'int', 'text']
            ];

?>

	<section id="list-barang">
		<div class="container">
			<h5 class="title">Menu Makanan</h5>
			<a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#tambah-menu"><i class="material-icons left">add</i>Tambah Menu</a>

			<!-- Modal Structure -->
		  <div id="tambah-menu" class="modal">
			  <form action="func/menu_makanan_func.php?action=insert" enctype="multipart/form-data" method="post">
			    <div class="modal-content">
			      <h4>Form Tambah Menu</h4>
				      <div class="row">
				        <div class="input-field col s12">
				          <input id="nama_menu" type="text" class="validate" name="nama_menu" required>
				          <label for="nama_menu">Nama Menu</label>
				        </div>
				        <div class="input-field col s12">
				          <input id="harga" type="number" class="validate" name="harga" required>
				          <label for="harga">Harga Menu</label>
				        </div>
				        <div class="input-field col s12">
				          <input id="stok" type="number" class="validate" name="stok" required>
				          <label for="stok">Stok Menu</label>
				        </div>
				        <div class="input-field col s12">
				          <input id="kategori" type="text" class="validate" name="kategori">
				          <label for="kategori">Kategori Menu</label>
				        </div>
				        <div class="file-field col s12 input-field">
						      <div class="btn">
						        <span>Foto Menu</span>
						        <input type="file" name="file_name" required>
						      </div>
						      <div class="file-path-wrapper">
						        <input class="file-path validate" type="text">
						      </div>
						    </div>
				      </div>
			    </div>
			    <div class="modal-footer">
			      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
			      <button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Tambah</button>
			    </div>
			  </form>
		  </div>

      <div class="container pencarian-barang">
        <div class="card">
          <?php include('../paginasi/pencarian.php'); ?>
        </div>
      </div>

			<div class="list">
				<div class="row parent">
					<?php 
						include('../paginasi/main-paginasi.php');

						while($data = mysqli_fetch_array($dt)) {
					?>
					<div class="col s12 m6 l4">
						<div class="card-panel">
			        <div class="row">
		            <div class="col s12">
		              <div class="img" style="background-image: url('foto_menu/<?php echo $data['foto']; ?>');"></div>
		            </div>
		            <div class="col s12">
		              <table>
		                <tbody>
		                  <tr>
		                    <th>Nama Menu</th>
		                    <td class="center-align"><?php echo $data['nama_menu']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>Harga</th>
		                    <td class="center-align">
		                    	Rp. <?php echo number_format($data['harga'],0,",","."); ?>	
		                    </td>
		                  </tr>
		                  <tr>
		                    <th>Stok</th>
		                    <td class="center-align">
		                    	<?php 
		                    		if ($data['stok'] == 0) {
		                    		 	echo 'Sold Out';
		                    		 } else {
		                    		 	echo 'Ready '.$data['stok'];
		                    		 }
		                    	?>
		                    </td>
		                  </tr>
		                  <tr>
		                    <th>Kategori</th>
		                    <td class="center-align"><?php echo $data['kategori']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>aksi</th>
		                    <td class="center-align">
		                    	<a class="waves-effect waves-light btn modal-trigger lime darken-1" href="#edit-menu<?php echo $data['id_menu']; ?>">edit</a>
		                    	<a class="waves-effect waves-light btn red darken-1 confirm-delete<?php echo $data['id_menu']; ?>" style="cursor: pointer;">hapus</a>

		                    	<script type="text/javascript">
											      $('.confirm-delete<?php echo $data['id_menu']; ?>').on('click', function(e) {
											        Swal.fire({
											          title: 'Anda Yakin?',
											          text: "Ingin Menghapus <?php echo $data['nama_menu']; ?>!",
											          icon: 'warning',
											          showCancelButton: true,
											          confirmButtonColor: '#3085d6',
											          cancelButtonColor: '#d33',
											          confirmButtonText: 'Ya, Yakin!'
											        }).then((result) => {
											          if (result.isConfirmed) {
											            window.location.href = "<?php echo 'func/menu_makanan_func.php?action=delete&id_menu='.$data['id_menu'].'&foto='.$data['foto'] ?>";
											          }
											        })
											      });
											    </script>
		                    </td>
		                  </tr>
		                </tbody>
		              </table>
		            </div>
		          </div>
			      </div>
					</div>

					<!-- Modal Structure -->
				  <div id="edit-menu<?php echo $data['id_menu']; ?>" class="modal edit-menu">
					  <form action="func/menu_makanan_func.php?action=update" enctype="multipart/form-data" method="post">
					    <div class="modal-content">
					      <h4>Edit Menu</h4>
					      <input type="hidden" name="id_menu" value="<?php echo $data['id_menu']; ?>">
						      <div class="row">
						        <div class="input-field col s12">
						          <input id="nama_menu" type="text" class="validate" name="nama_menu" required value="<?php echo $data['nama_menu']; ?>">
						          <label for="nama_menu">Nama Menu</label>
						        </div>
						        <div class="input-field col s12">
						          <input id="harga" type="number" class="validate" name="harga" required value="<?php echo $data['harga']; ?>">
						          <label for="harga">Harga Menu</label>
						        </div>
						        <div class="input-field col s12">
						          <input id="stok" type="number" class="validate" name="stok" required value="<?php echo $data['stok']; ?>">
						          <label for="stok">Stok</label>
						        </div>
						        <div class="input-field col s12">
						          <input id="kategori" type="text" class="validate" name="kategori" value="<?php echo $data['kategori']; ?>">
						          <label for="kategori">Kategori</label>
						        </div>
						        <div class="file-field col s12 input-field">
								      <div class="btn">
								        <span>Foto Barang</span>
								        <input type="file" name="file_name">
								        <input type="hidden" name="file_name_sebelum" value="<?php echo $data['foto']; ?>">
								      </div>
								      <div class="file-path-wrapper">
								        <input class="file-path validate" type="text">
								      </div>
								    </div>
						      </div>
					    </div>
					    <div class="modal-footer">
					      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
					      <button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Ubah</button>
					    </div>
					  </form>
				  </div>
				<?php } ?>
				</div>
					<?php include('../paginasi/btn-paginasi.php'); ?>
			</div>
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
	      'Anda Telah Melakukan Penambahan Menu',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penambahan Barang',
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