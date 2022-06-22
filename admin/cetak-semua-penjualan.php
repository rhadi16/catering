<?php 
	session_start();

	$id_admin = $_SESSION['user'];
	if(!isset($_SESSION['user'])){
	    // fungsi redirect menggunakan javascript
	    echo '<script language="javascript"> window.location.href = "../index.php" </script>';
	}
	// echo '<link rel="shortcut icon" href="assets/gambar/logo_lutra.png" type="image/x-icon">';
	require_once __DIR__ . '/lib/mpdf/vendor/autoload.php';

	$mpdf = new \Mpdf\Mpdf();

	$html = '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Laporan Penjualan</title>
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

	include 'config/connect.php';
    include 'config/auth.php';
    include 'asset/datetime/datetimeFormat.php';

    if ($id_admin == 1) {
    	$dt = mysqli_query($mysqli, "SELECT 
									a.*,
									b.nama_barang
								FROM penjualan a
								LEFT JOIN list_barang b ON a.id_barang=b.id_barang
								ORDER BY id DESC");
    } else {
    	$dt = mysqli_query($mysqli, "SELECT 
									a.*,
									b.nama_barang
								FROM penjualan a
								LEFT JOIN list_barang b ON a.id_barang=b.id_barang
								WHERE id_admin = $id_admin
								ORDER BY id DESC");
    }
    $ad = mysqli_query($mysqli, "SELECT * FROM utenti WHERE id = $id_admin");
  	$ad1 = mysqli_fetch_array($ad);

	$html .= '
		  <body>
				<main>
					<h1>LAPORAN SEMUA BARANG TERJUAL DARI <br>'.$ad1['email'].'<br>TOKO MEGA TONY</h1>

					<table>
						<tr>
							<th>No.</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Jumlah Terjual</th>
							<th>Total Harga Terjual</th>
						</tr>';
					$no = 1; 
      		while($d  = mysqli_fetch_array($dt)){
      		$html .= '
      			<tr>
      				<td>'. $no .'</td>
      				<td>'. datetimeFormat::TanggalIndo($d['tanggal']) .'</td>
      				<td>'. $d['nama_barang'] .'</td>
      				<td>'. $d['jum_yg_dibeli'] .'</td>
      				<td>Rp. '. number_format($d['tot_yg_dibeli'],0,",",".") .'</td>
      			</tr>
      		';
      		$total_penjualan += $d['tot_yg_dibeli'];
      		$no++;
      	}
$html .='
				    <tr>
							<th colspan="4">Total Pemasukan</th>
							<th>Rp. '. number_format($total_penjualan,0,",",".") .'</th>
						</tr>
					</table>
				</main>
			</body>
			</html>';
	$mpdf->WriteHTML($html);
	$mpdf->Output('Daftar Barang Terjual.pdf', \Mpdf\Output\Destination::INLINE);

?>