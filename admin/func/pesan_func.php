<?php 

	include '../../admin/config/connect.php';
	include '../../admin/config/auth.php';

	$action  = $_GET['action'];

	if ($action == "insert") {
		
		$id 		= $_POST['id'];
		$id_admin	= $_POST['id_admin'];
		$status 	= $_POST['status'];

		$result = mysqli_query($mysqli, "UPDATE penjualan
	  									SET 
	  									   id_admin = '$id_admin',
	  									   status = '$status'
	  									   WHERE id = $id
	  									") or die(mysqli_error($mysqli));

		if ($result) {
			echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=success-in" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=failed-in" </script>';
		}
	} elseif($action == "update") {

		$id 		   		= $_POST['id'];
		$id_menu 	   		= $_POST['id_menu'];
		$jum_yg_dibeli 		= $_POST['jum_yg_dibeli'];
		$jum_yg_dibeli_lama = $_POST['jum_yg_dibeli_lama'];
		$id_pelanggan 	   	= $_POST['id_pelanggan'];

		$dt1 = mysqli_query($mysqli, "SELECT * FROM list_makanan WHERE id_menu = $id_menu");
        $d1  = mysqli_fetch_array($dt1);

        $re = $d1['stok'] + $jum_yg_dibeli_lama;
        $re1 = $re - $jum_yg_dibeli;

        $tot_harga = $jum_yg_dibeli * $d1['harga'];

        if ($d1['stok'] < $jum_yg_dibeli) {
        	echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=failed-ed2" </script>';
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
				echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=failed-ed" </script>';
			}
        }
	} elseif($action == "delete") {

		$id 	   		= $_GET['id'];
		$id_menu 		= $_GET['id_menu'];
		$id_pelanggan	= $_GET['id_pelanggan'];

        $dt = mysqli_query($mysqli, "SELECT * FROM list_makanan WHERE id_menu = $id_menu");
        $d  = mysqli_fetch_array($dt);

        $dt1 = mysqli_query($mysqli, "SELECT * FROM penjualan WHERE id = $id");
        $d1  = mysqli_fetch_array($dt1);

        $stok = $d['stok'] + $d1['jum_yg_dibeli'];

		$result  = mysqli_query($mysqli, "DELETE FROM penjualan WHERE id = $id") or die(mysqli_error($mysqli));
		$result1 = mysqli_query($mysqli, "UPDATE list_makanan SET stok = '$stok' WHERE id_menu = '$id_menu'") or die(mysqli_error($mysqli));

		if ($result && $result1) {
			echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=success-del" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../detail-pesanan.php?id_pel='.$id_pelanggan.'&desc=failed-del" </script>';
		}

	}

?>