<?php include('template/header.php'); ?>

<?php
  $id = $_SESSION['user'];
  $dt = mysqli_query($mysqli, "SELECT * FROM pelanggan WHERE id = $id");
  $d  = mysqli_fetch_array($dt);
?>

	<section id="hal-utama">
		<div class="container">
			<div class="container">
				<div class="row">
			    <div class="col s12">
			      <div class="card-panel blue darken-2 center-align">
			        <div class="row">
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn modal-trigger blue-grey lighten-2" href="#edit-profile">Edit Profile</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn amber darken-1" href="pesan.php">Pesan Makanan</a>
			        	</div>
			        	<div class="col s12">
			        		<a class="waves-effect waves-light btn yellow darken-1" href="daftar-pesan.php">Daftar Pesanan</a>
			        	</div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

		<!-- Modal Structure -->
	  <div id="edit-profile" class="modal edit-pegawai">
		  <form action="func/edit_profile_func.php" enctype="multipart/form-data" method="post">
		    <div class="modal-content">
		      <h4>Edit Profile</h4>
		      <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="email" type="email" class="validate" name="email" required value="<?php echo $d['email']; ?>">
			          <label for="email">Email</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="nama" type="text" class="validate" name="nama" required value="<?php echo $d['nama']; ?>">
			          <label for="nama">Nama Pelanggan</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="alamat" type="text" class="validate" name="alamat" required value="<?php echo $d['alamat']; ?>">
			          <label for="alamat">Alamat Pelanggan</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="no_wa" type="text" class="validate" name="no_wa" required value="<?php echo $d['no_wa']; ?>">
			          <label for="no_wa">Nomor HP/WA Pelanggan</label>
			        </div>
			        <div class="input-field col s12">
			          <input id="tgl_lahir" type="date" class="validate" name="tgl_lahir" required value="<?php echo $d['tgl_lahir']; ?>">
			          <label for="tgl_lahir">Tanggal Lahir Pelanggan</label>
			        </div>
			        <div class="input-field col s12">
			        	<input type="hidden" name="pass-lama" value="<?php echo $d['password']; ?>">
			          <input id="password" type="password" class="validate" name="password" pattern=".{8,}" minlength="8">
			          <label for="password">Masukkan Password Baru</label>
			        </div>
			      </div>
		    </div>
		    <div class="modal-footer">
		      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
		      <input type="hidden" name="register" value="register">
		      <button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Edit</button>
		    </div>
		  </form>
	  </div>
	</section>

	<?php
    // error_reporting(0);
    $desc = $_GET['desc']; 
    if ($desc == "success-adm") {
	?>
	  <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "failed-adm") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "success-ed") { ?>
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
	  } else if (desc_in == "success-ed") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Perubahan Data',
	      'success'
	    )
	  }
</script>