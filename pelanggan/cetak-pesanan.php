<?php 
	session_start();

	$id_pelanggan = $_SESSION['user'];
	if(!isset($_SESSION['user'])){
	    // fungsi redirect menggunakan javascript
	    echo '<script language="javascript"> window.location.href = "../index.php" </script>';
	}
	// echo '<link rel="shortcut icon" href="assets/gambar/logo_lutra.png" type="image/x-icon">';
	// require_once __DIR__ . '../admin/lib/mpdf/vendor/autoload.php';
	require_once '../admin/lib/mpdf/vendor/autoload.php';

	$mpdf = new \Mpdf\Mpdf();

	$html = '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Daftar Pesanan</title>
			<style type="text/css">
				body, main, h1, table, td, th {
					margin: 0;
					padding: 0;
					border-collapse: collapse;
					font-family: calibri, sans-serif;
				}
				main {
					width: 100%;
					position: relative;
				}
				h1 {
					text-align: center;
					border-bottom: 2px solid black;
					padding-bottom: 10px;
					margin-bottom: 20px;
					line-height: 1.5rem;
					font-size: 1.2rem;
				}
				table {
		  		width: 100%;
				}
				td, th {
					border: 1px solid #212121;
				  text-align: left;
				  padding: 8px;
		  		text-align: center;
				}
				tr:nth-child(even) {
				  background-color: #dddddd;
				}
			</style>
		</head>';

	include '../admin/config/connect.php';
  include '../admin/config/auth.php';
  include '../admin/asset/datetime/datetimeFormat.php';

  $dt = mysqli_query($mysqli, "SELECT 
																a.id,
																a.id_menu,
																b.nama_menu,
																b.harga,
																a.jum_yg_dibeli,
																a.tot_harga,
																a.tanggal
															FROM penjualan a
															LEFT JOIN list_makanan b ON a.id_menu = b.id_menu
															WHERE id_pelanggan = $id_pelanggan AND status = 'proses'");

  $ad = mysqli_query($mysqli, "SELECT * FROM pelanggan WHERE id = $id_pelanggan");
	$ad1 = mysqli_fetch_array($ad);

	$html .= '
		  <body>
				<main>
					<h1>Daftar Pesanan Milik <br>'.$ad1['email'].'<br>'.$ad1['nama'].'</h1>

					<table>
						<tr>
							<th>No.</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Harga</th>
							<th>Quantity</th>
							<th>Total Harga</th>
						</tr>';
					$no = 1; 
      		while($d  = mysqli_fetch_array($dt)){
	      		$html .= '
	      			<tr>
	      				<td>'. $no .'</td>
	      				<td>'. datetimeFormat::TanggalIndo($d['tanggal']) .'</td>
	      				<td>'. $d['nama_menu'] .'</td>
	      				<td>Rp. '. number_format($d['harga'],0,",",".") .'</td>
	      				<td>'. $d['jum_yg_dibeli'] .'</td>
	      				<td>Rp. '. number_format($d['tot_harga'],0,",",".") .'</td>
	      			</tr>
	      		';
	      		$total_penjualan += $d['tot_harga'];
	      		$no++;
	      	}
$html .='
				    <tr>
							<th colspan="5">Total Belanja</th>
							<th>Rp. '. number_format($total_penjualan,0,",",".") .'</th>
						</tr>
					</table>
				</main>
			</body>
			</html>';
	$mpdf->WriteHTML($html);
	$mpdf->Output('Daftar_belanja.pdf', \Mpdf\Output\Destination::INLINE);

?>