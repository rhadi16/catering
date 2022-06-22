<?php 
	include('template/header.php'); 
	include '../admin/asset/datetime/datetimeFormat.php';
?>
<link rel="stylesheet" type="text/css" href="asset/css/pesan.css">
<link rel="stylesheet" type="text/css" href="../css/style.css">
<?php 
	$id_pelanggan = $_SESSION['user'];

	$qry    = "SELECT * FROM list_makanan";
      
  $orderby = ""; 

  $view   = "pesan.php";

  $column = [
              'value'  => ['nama_menu', 'harga', 'kategori'],
              'label'  => ['Nama Menu', 'Harga Menu', 'Kategori Menu'],
              'type'   => ['text', 'double', 'text']
            ];
?>

	<section id="penjualan">
		<div class="container">
			<h5 class="center-align title-form">Menu Makanan</h5>
			<a class="waves-effect waves-light btn light-blue darken-1" id="tambah-kolom" href="daftar-pesan.php"><i class="material-icons left">near_me</i>Daftar Pesanan Anda</a>
			<!-- <a class="waves-effect waves-light btn  light-blue darken-1" id="tambah-kolom"><i class="material-icons left">add</i>Tambah Form Isian</a>
			<div class="row">
				<form action="func/pesan_func.php?action=insert" enctype="multipart/form-data" method="post">
				<div class="element col s12" id="div_1">
			    <div id="txt_1">
			      <div class="card-panel bg">
							<div class="row">
						    <div class="col s12 m6">
					        <div class="ui-widget input-field">
					          <select id="combobox1" name="id_barang[]" required>
					            <option value="">Select one...</option>
					            <?php 
                        $qry1 = "SELECT * FROM list_barang";

                        $dt1 = mysqli_query($mysqli, $qry1);

                        while($data1 = mysqli_fetch_array($dt1)){
                      ?>
						            <option value="<?php echo $data1['id_barang'].'||'.$data1['stok'].'||'.$data1['harga']; ?>"><?php echo $data1['nama_barang']; ?></option>
					          	<?php } ?>
					          </select>
					          <label>Pilih Barang</label>
					        </div>
						    </div>
				        <div class="input-field col s12 m6">
				          <input placeholder="" id="jum_yg_dibeli" type="number" class="validate" name="jum_yg_dibeli[]" required>
				          <label for="jum_yg_dibeli">Jumlah Barang Yang Dibeli</label>
				        </div>
				        <input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>">
						  </div>
			      </div>
			    </div>
				</div>
				<div class="col s12">
					<button type="submit" class="waves-effect waves-light btn green darken-1" id="input-penjualan"><i class="material-icons left">send</i>Pesan</button>
				</div>
				</form>
		  </div> -->
		</div>

		<div class="container" id="list-barang">
      <div class="container pencarian-barang">
        <div class="card">
          <?php include('../paginasi/pencarian.php'); ?>
        </div>
      </div>
    </div>

    <section id="list-barang">
    	<div class="container">
	      <div class="row">
	        <?php 
	          include('../paginasi/main-paginasi.php');

	          while($data = mysqli_fetch_array($dt)){
	        ?>
	        <div class="col s6 m3 l2">
	          <div class="card-panel">
	            <div class="img-brg" style="background-image: url('../admin/foto_menu/<?php echo $data['foto']; ?>');"></div>
	            <table>
	              <tbody>
	                <tr>
	                  <th class="center-align"><?php echo $data['nama_menu']; ?></th>
	                </tr>
	                <tr>
	                  <th class="center-align">
	                    Rp. <?php echo number_format($data['harga'],0,",","."); ?>
	                  </th>
	                </tr>
	                <tr>
	                  <?php 
	                    if ($data['stok'] == 0) {
	                      echo '<th class="center-align red-text">Sold Out</th>';
	                     } else {
	                      echo '<th class="center-align green-text">Ready '.$data['stok'].'</th>';
	                     }
	                  ?>
	                </tr>
	                <tr>
	                  <th class="center-align"><?php echo $data['kategori']; ?></th>
	                </tr>
	                <tr>
	                	<form action="func/pesan_func.php?action=insert-pes" enctype="multipart/form-data" method="post">
	                		<input type="hidden" name="id_menu" value="<?php echo $data['id_menu']; ?>">
	                		<input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>">
                  		<th class="pesan">
                  			<?php 
                  				if ($data['stok'] == 0) {
                  					echo '<button type="submit" class="waves-effect waves-light btn btn-pesan disabled">Pesan</button>';
                  				} else {
                  					echo '<button type="submit" class="waves-effect waves-light btn btn-pesan">Pesan</button>';
                  				}
                  			?>
                  		</th>
	                	</form>
	                </tr>
	              </tbody>
	            </table>
	          </div>
	        </div>
	        <?php } ?>
	      </div>

	      <?php include('../paginasi/btn-paginasi.php'); ?>
	    </div>
    </section>
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
	      'Anda Telah Melakukan Pemesanan. Silahkan Cek di Daftar Pesanan Anda dan Cetak Pesanan',
	      'success'
	    )
	  } else if (desc_in == "failed-in") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Pemesanan',
	      'error'
	    )
	  } else if (desc_in == "success-del") {
	  	Swal.fire(
	      'Berhasil!',
	      'Anda Telah Melakukan Penghapusan Penjualan',
	      'success'
	    )
	  } else if (desc_in == "failed-del") {
	  	Swal.fire(
	      'Gagal!',
	      'Anda Gagal Melakukan Penghapusan Penjualan',
	      'error'
	    )
	  }

	</script>

<?php include('template/footer.php'); ?>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="asset/js/jquery-ui.js"></script>
<script type="text/javascript" src="asset/js/pesan.js"></script>