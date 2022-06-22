<?php 
	// echo '<link rel="shortcut icon" href="assets/gambar/logo_lutra.png" type="image/x-icon">';
	require_once __DIR__ . '/lib/mpdf/vendor/autoload.php';

	$mpdf = new \Mpdf\Mpdf();

	$html = '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Laporan Pembelian</title>
			<style type="text/css">
				body, main, h1, table, td, th, h5 {
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
				h5 {
					text-align: center;
					margin-bottom: 10px;
					font-size: 1.2rem;
				}
				table {
		  		width: 100%;
		  		margin-bottom: 10px;
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
    
    $dt = mysqli_query($mysqli, "SELECT 
																	a.*,
																	b.nama_barang
																FROM pembelian a
																LEFT JOIN list_barang b ON a.id_barang=b.id_barang
																ORDER BY id DESC");

    $dt2= mysqli_query($mysqli, "SELECT 
																	a.*,
																	b.nama_barang
																FROM penjualan a
																LEFT JOIN list_barang b ON a.id_barang=b.id_barang
																ORDER BY id DESC");
	$html .= '
		  <body>
				<main>
					<h1>LAPORAN SEMUA BARANG MASUK DAN BARANG KELUAR <br>TOKO MEGA TONY</h1>
					<h5>List Pembelian</h5>
					<table>
						<tr>
							<th>No.</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Stok Yang Dibeli</th>
							<th>Harga Pembelian</th>
						</tr>';
					$no = 1; 
      		while($d  = mysqli_fetch_array($dt)){
      		$html .= '
      			<tr>
      				<td>'. $no .'</td>
      				<td>'. datetimeFormat::TanggalIndo($d['tanggal']) .'</td>
      				<td>'. $d['nama_barang'] .'</td>
      				<td>'. $d['stok_yg_dibeli'] .'</td>
      				<td>Rp. '. number_format($d['harga_yg_dibeli'],0,",",".") .'</td>
      			</tr>
      		';
      		$total_pembelian += $d['harga_yg_dibeli'];
      		$no++;
      	}
$html .='
				    <tr>
							<th colspan="4">Total Pengeluaran</th>
							<th>Rp. '. number_format($total_pembelian,0,",",".") .'</th>
						</tr>
					</table>

					<h5>List Penjualan</h5>
					<table>
						<tr>
							<th>No.</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Jumlah Terjual</th>
							<th>Total Harga Terjual</th>
						</tr>';
					$no = 1; 
      		while($d2 = mysqli_fetch_array($dt2)){
      		$html .= '
      			<tr>
      				<td>'. $no .'</td>
      				<td>'. datetimeFormat::TanggalIndo($d2['tanggal']) .'</td>
      				<td>'. $d2['nama_barang'] .'</td>
      				<td>'. $d2['jum_yg_dibeli'] .'</td>
      				<td>Rp. '. number_format($d2['tot_yg_dibeli'],0,",",".") .'</td>
      			</tr>
      		';
      		$total_penjualan += $d2['tot_yg_dibeli'];
      		$no++;
      	}
      	$total_penghasilan = $total_penjualan - $total_pembelian;
$html .='
				    <tr>
							<th colspan="4">Total Pemasukan</th>
							<th>Rp. '. number_format($total_penjualan,0,",",".") .'</th>
						</tr>
						<tr>
							<th colspan="4">Total Penghasilan</th>
							<th>Rp. '. number_format($total_penghasilan,0,",",".") .'</th>
						</tr>
					</table>
				</main>
			</body>
			</html>';
	$mpdf->WriteHTML($html);
	$mpdf->Output('Daftar Pembelian.pdf', \Mpdf\Output\Destination::INLINE);

?>