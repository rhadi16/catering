<?php 

	include '../../admin/config/connect.php';
	include '../../admin/config/auth.php';

	$action  = $_GET['action'];

	if ($action == "insert") {
		
		$id_barang 	   = $_POST['id_barang'];
		$jum_yg_dibeli = $_POST['jum_yg_dibeli'];
		$id_pelanggan  = $_POST['id_pelanggan'];
		$tanggal = date('Y-m-d');

		$jum_data = count($id_barang);

		for ($i=0; $i < $jum_data; $i++) {
			$stok_list_brg[$i] = explode("||", $id_barang[$i]);

			$id_brg[$i]    = $stok_list_brg[$i][0];
			$stok_awal[$i] = $stok_list_brg[$i][1];
			$harga[$i] 	   = $stok_list_brg[$i][2];

			$dt1 = mysqli_query($mysqli, "SELECT * FROM list_barang WHERE id_barang = $id_brg[$i]");
        	$d1  = mysqli_fetch_array($dt1);

        	$diskon[$i] = $harga[$i] * $d1['diskon']/100;

			$tot_yg_dibeli[$i] = ($harga[$i] - $diskon[$i]) * $jum_yg_dibeli[$i];
			$sisa_stok[$i]	   = $stok_awal[$i] - $jum_yg_dibeli[$i];

			$result = mysqli_query($mysqli, "INSERT INTO list_pesanan (id, id_barang, jum_yg_dibeli, tanggal, id_pelanggan) 
											 VALUES(null, '$id_brg[$i]', '$jum_yg_dibeli[$i]', '$tanggal', '$id_pelanggan')") or die(mysqli_error($mysqli));
			$result1= mysqli_query($mysqli, "UPDATE list_barang SET stok = '$sisa_stok[$i]' WHERE id_barang = '$id_brg[$i]'") 
											or die(mysqli_error($mysqli));
		}

		if ($result && $result1) {
			echo '<script language="javascript"> window.location.href = "../pesan.php?desc=success-in" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../pesan.php?desc=failed-in" </script>';
		}
	} elseif ($action == "insert-pes") {
		$id_menu 	   = $_POST['id_menu'];
		$jum_yg_dibeli = 1;
		$id_pelanggan  = $_POST['id_pelanggan'];
		$tanggal = date('Y-m-d');

		$dt = mysqli_query($mysqli, "SELECT * FROM penjualan WHERE id_menu = $id_menu AND id_pelanggan = $id_pelanggan");
        $d  = mysqli_fetch_array($dt);

		$dt1 = mysqli_query($mysqli, "SELECT * FROM list_makanan WHERE id_menu = $id_menu");
        $d1  = mysqli_fetch_array($dt1);

        $sisa_stok	= $d1['stok'] - $jum_yg_dibeli;
        $up_pesanan = $d['jum_yg_dibeli']+1;
        $tot_harga	= $d1['harga'] * $up_pesanan;

        if (isset($d)) {
        	$result = mysqli_query($mysqli, "UPDATE penjualan SET jum_yg_dibeli = '$up_pesanan', tot_harga = '$tot_harga' WHERE id_menu = '$id_menu' AND id_pelanggan = '$id_pelanggan'") or die(mysqli_error($mysqli));
			$result1= mysqli_query($mysqli, "UPDATE list_makanan SET stok = '$sisa_stok' WHERE id_menu = '$id_menu'") 
										or die(mysqli_error($mysqli));
        } else {
			$result = mysqli_query($mysqli, "INSERT INTO penjualan (id, id_menu, jum_yg_dibeli, tot_harga, tanggal, id_admin, id_pelanggan, status) 
											 VALUES(null, '$id_menu', '$jum_yg_dibeli', '$tot_harga', '$tanggal', null, '$id_pelanggan', 'proses')") or die(mysqli_error($mysqli));
			$result1= mysqli_query($mysqli, "UPDATE list_makanan SET stok = '$sisa_stok' WHERE id_menu = '$id_menu'") 
											or die(mysqli_error($mysqli));
        }

		if ($result && $result1) {
			echo '<script language="javascript"> window.location.href = "../pesan.php?desc=success-in" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../pesan.php?desc=failed-in" </script>';
		}
	} elseif($action == "update") {

		$id 		   = $_POST['id'];
		$id_menu 	   = $_POST['id_menu'];
		$jum_yg_dibeli = $_POST['jum_yg_dibeli'];
		$jum_yg_dibeli_lama = $_POST['jum_yg_dibeli_lama'];

		$dt = mysqli_query($mysqli, "SELECT * FROM penjualan WHERE id_menu = $id_menu AND id_pelanggan = $id");
        $d  = mysqli_fetch_array($dt);

		$dt1 = mysqli_query($mysqli, "SELECT * FROM list_makanan WHERE id_menu = $id_menu");
        $d1  = mysqli_fetch_array($dt1);

        $re = $d1['stok'] + $jum_yg_dibeli_lama;
        $re1 = $re - $jum_yg_dibeli;

        $tot_harga = $jum_yg_dibeli * $d1['harga'];

        if ($d1['stok'] < $jum_yg_dibeli) {
        	echo '<script language="javascript"> window.location.href = "../daftar-pesan.php?desc=failed-ed2" </script>';
        } else {
			$result = mysqli_query($mysqli, "UPDATE penjualan
			  									SET 
			  									   jum_yg_dibeli = '$jum_yg_dibeli',
			  									   tot_harga = '$tot_harga'
			  									   WHERE id = $id
			  									") or die(mysqli_error($mysqli));

			$result1 = mysqli_query($mysqli, "UPDATE list_makanan
			  									SET 
			  									   stok = '$re1'
			  									   WHERE id_menu = '$id_menu'
			  									") or die(mysqli_error($mysqli));

			if ($result) {
				echo '<script language="javascript"> window.location.href = "../daftar-pesan.php?desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../daftar-pesan.php?desc=failed-ed" </script>';
			}
        }
        

	} elseif($action == "delete") {

		$id 	 = $_GET['id'];
		$id_menu = $_GET['id_menu'];

        $dt = mysqli_query($mysqli, "SELECT * FROM list_makanan WHERE id_menu = $id_menu");
        $d  = mysqli_fetch_array($dt);

        $dt1 = mysqli_query($mysqli, "SELECT * FROM penjualan WHERE id = $id");
        $d1  = mysqli_fetch_array($dt1);

        $stok = $d['stok'] + $d1['jum_yg_dibeli'];

		$result  = mysqli_query($mysqli, "DELETE FROM penjualan WHERE id = $id") or die(mysqli_error($mysqli));
		$result1 = mysqli_query($mysqli, "UPDATE list_makanan SET stok = '$stok' WHERE id_menu = '$id_menu'") or die(mysqli_error($mysqli));

		if ($result && $result1) {
			echo '<script language="javascript"> window.location.href = "../daftar-pesan.php?desc=success-del" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../daftar-pesan.php?desc=failed-del" </script>';
		}

	}

?>