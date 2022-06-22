<?php include('template/header.php'); ?>

<?php 

	$qry = "SELECT * FROM pegawai";

	$orderby = "";

  $view   = "pegawai.php";

  $column = [
              'value'  => ['nama', 'jabatan'],
              'label'  => ['Nama Pegawai', 'Jabatan'],
              'type'   => ['text', 'text']
            ];

  if($_SESSION['user'] != 1){
    // fungsi redirect menggunakan javascript
    echo '<script language="javascript"> window.location.href = "index.php" </script>';
	}

?>

	<section id="pegawai">
		<div class="container">
			<h5 class="title">List Pegawai</h5>
			<a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#tambah-pegawai"><i class="material-icons left">add</i>Tambah Pegawai</a>

			<!-- Modal Structure -->
		  <div id="tambah-pegawai" class="modal">
			  <form action="func/pegawai_func.php?action=insert" enctype="multipart/form-data" method="post">
			    <div class="modal-content">
			      <h4>Form Tambah Pegawai</h4>
				      <div class="row">
				        <div class="input-field col s12">
				          <i class="material-icons prefix">account_circle</i>
				          <input id="nama" type="text" class="validate" name="nama" required>
				          <label for="nama">Nama</label>
				        </div>
				        <div class="input-field col s12">
				          <i class="material-icons prefix">work</i>
				          <input id="jabatan" type="text" class="validate" name="jabatan" required>
				          <label for="jabatan">Jabatan</label>
				        </div>
				        <div class="input-field col s12">
				          <i class="material-icons prefix">email</i>
				          <input id="email" type="email" class="validate" name="email" required>
				          <label for="email">Email</label>
				        </div>
				        <div class="input-field col s12">
				          <i class="material-icons prefix">local_phone</i>
				          <input id="hp" type="text" class="validate" name="hp" required>
				          <label for="hp">Nomor Hp</label>
				        </div>
				        <div class="file-field col s12 input-field">
						      <div class="btn">
						        <span>Foto</span>
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

			<div class="list">
				<div class="container pencarian-barang">
	        <div class="card-panel">
	          <?php include('../paginasi/pencarian.php'); ?>
	        </div>
	      </div>
				<div class="row parent">
					<?php 
						include('../paginasi/main-paginasi.php');

						while($data = mysqli_fetch_array($dt)) {
					?>
					<div class="col s12 m6 l4">
						<div class="card-panel">
			        <div class="row">
		            <div class="col s12">
		              <div class="img" style="background-image: url('foto/<?php echo $data['foto']; ?>');"></div>
		            </div>
		            <div class="col s12">
		              <table>
		                <tbody>
		                  <tr>
		                    <th>Nama</th>
		                    <td class="center-align"><?php echo $data['nama']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>Jabatan</th>
		                    <td class="center-align"><?php echo $data['jabatan']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>Email</th>
		                    <td class="center-align"><?php echo $data['email']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>Nomor Hp</th>
		                    <td class="center-align"><?php echo $data['hp']; ?></td>
		                  </tr>
		                  <tr>
		                    <th>aksi</th>
		                    <td class="center-align">
		                    	<a class="waves-effect waves-light btn modal-trigger lime darken-1" href="#edit-pegawai<?php echo $data['id']; ?>">edit</a>
		                    	<a class="waves-effect waves-light btn red darken-1 confirm-delete<?php echo $data['id']; ?>" style="cursor: pointer;">hapus</a>
		                    	<?php 
				    								$tu = mysqli_query($mysqli, "SELECT * FROM utenti WHERE email = '".$data['email']."'");
				    								$du = mysqli_fetch_array($tu);

				    								if ($du['email'] == $data['email']) {
		                    	?>
		                    		<a class="waves-effect waves-light btn red darken-4 delete-account<?php echo $du['id']; ?>" style="cursor: pointer;">hapus akun</a>
		                    		<script type="text/javascript">
												      $('.delete-account<?php echo $du['id']; ?>').on('click', function(e) {
												        Swal.fire({
												          title: 'Anda Yakin?',
												          text: "Ingin Menghapus Akun <?php echo $data['email']; ?>!",
												          icon: 'warning',
												          showCancelButton: true,
												          confirmButtonColor: '#3085d6',
												          cancelButtonColor: '#d33',
												          confirmButtonText: 'Ya, Yakin!'
												        }).then((result) => {
												          if (result.isConfirmed) {
												            window.location.href = "<?php echo 'func/register_func.php?action=delete&email='.$data['email'] ?>";
												          }
												        })
												      });
												    </script>
		                    	<?php } else { ?>
		                    		<a class="waves-effect waves-light btn modal-trigger green darken-3" href="#tambah-akun<?php echo $data['id']; ?>">Tambah Akun</a>
		                    	<?php } ?>

		                    	<script type="text/javascript">
											      $('.confirm-delete<?php echo $data['id']; ?>').on('click', function(e) {
											        Swal.fire({
											          title: 'Anda Yakin?',
											          text: "Ingin Menghapus Data <?php echo $data['nama']; ?>!",
											          icon: 'warning',
											          showCancelButton: true,
											          confirmButtonColor: '#3085d6',
											          cancelButtonColor: '#d33',
											          confirmButtonText: 'Ya, Yakin!'
											        }).then((result) => {
											          if (result.isConfirmed) {
											            window.location.href = "<?php echo 'func/pegawai_func.php?action=delete&id='.$data['id'].'&foto='.$data['foto'] ?>";
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
				  <div id="edit-pegawai<?php echo $data['id']; ?>" class="modal edit-pegawai">
					  <form action="func/pegawai_func.php?action=update" enctype="multipart/form-data" method="post">
					    <div class="modal-content">
					      <h4>Edit Data Pegawai</h4>
					      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
						      <div class="row">
						        <div class="input-field col s12">
						          <i class="material-icons prefix">account_circle</i>
						          <input id="nama" type="text" class="validate" name="nama" required value="<?php echo $data['nama']; ?>">
						          <label for="nama">Nama</label>
						        </div>
						        <div class="input-field col s12">
						          <i class="material-icons prefix">work</i>
						          <input id="jabatan" type="text" class="validate" name="jabatan" required value="<?php echo $data['jabatan']; ?>">
						          <label for="jabatan">Jabatan</label>
						        </div>
						        <div class="input-field col s12">
						          <i class="material-icons prefix">email</i>
						          <input id="email" type="email" class="validate" name="email" required value="<?php echo $data['email']; ?>">
						          <input type="hidden" name="email_lama" value="<?php echo $data['email']; ?>">
						          <label for="email">Email</label>
						        </div>
						        <div class="input-field col s12">
						          <i class="material-icons prefix">local_phone</i>
						          <input id="hp" type="text" class="validate" name="hp" required value="<?php echo $data['hp']; ?>">
						          <label for="hp">Nomor Hp</label>
						        </div>
						        <div class="file-field col s12 input-field">
								      <div class="btn">
								        <span>Foto</span>
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

				  <!-- Modal Structure -->
				  <div id="tambah-akun<?php echo $data['id']; ?>" class="modal edit-pegawai">
					  <form action="func/register.php" enctype="multipart/form-data" method="post">
					    <div class="modal-content">
					      <h4>Tambah Akun</h4>
					      <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
						      <div class="row">
						        <div class="input-field col s12">
						          <i class="material-icons prefix">email</i>
						          <input id="email" type="email" class="validate" name="email" required readonly value="<?php echo $data['email']; ?>">
						          <label for="email">Email</label>
						        </div>
						        <div class="input-field col s12">
						          <i class="material-icons prefix">lock</i>
						          <input id="password<?php echo $data['id']; ?>" type="password" class="validate" name="password" pattern=".{8,}" minlength="8" required>
						          <label for="password<?php echo $data['id']; ?>">Masukkan Password</label>
						        </div>
						      </div>
					    </div>
					    <div class="modal-footer">
					      <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
					      <input type="hidden" name="register" value="register">
					      <button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">add</i>Tambah</button>
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
	<?php } elseif ($desc == "short-pass") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "email-ready") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } elseif ($desc == "succes-regis") { ?>
		<div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
	<?php } ?>

	<script type="text/javascript">
  
	  const desc_in = $('.desc-in').data('flashdata')
	  if (desc_in == "success-in") {
	    Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penambahan Data',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penambahan Data',
	      'error'
	    )
	  } else if (desc_in == "success-ed") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Perubahan Data',
	      'success'
	    )
	  } else if (desc_in == "failed-ed") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Perubahan Data',
	      'error'
	    )
	  } else if (desc_in == "success-del") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penghapusan Data',
	      'success'
	    )
	  } else if (desc_in == "failed-del") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penghapusan Data',
	      'error'
	    )
	  } else if (desc_in == "short-pass") {
	  	Swal.fire(
	      'Gagal!',
	      'Password Kurang Dari 8 Karakter',
	      'error'
	    )
	  } else if (desc_in == "email-ready") {
	  	Swal.fire(
	      'Gagal!',
	      'Email Telah Terdaftar',
	      'error'
	    )
	  } else if (desc_in == "succes-regis") {
	  	Swal.fire(
	      'Berhasil!',
	      'Admin Telah Ditambahkan',
	      'success'
	    )
	  }

	</script>

<?php include('template/footer.php'); ?>