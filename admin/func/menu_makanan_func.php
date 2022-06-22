<?php 

	include '../config/connect.php';
	include '../config/auth.php';

	$action  = $_GET['action'];

	if ($action == "insert") {
		
		$nama_menu	= $_POST['nama_menu'];
		$harga 		= $_POST['harga'];
		$stok 		= $_POST['stok'];
		$kategori 	= $_POST['kategori'];
		// Ambil Data yang Dikirim dari Form
		$nama_file = $_FILES['file_name']['name'];
		$tmp_file  = $_FILES['file_name']['tmp_name'];

		$foto = rand().$nama_file;

		// Set path folder tempat menyimpan gambarnya
		$path = "../foto_menu/".$foto;

		if (move_uploaded_file($tmp_file, $path)) {
			$result = mysqli_query($mysqli, "INSERT INTO list_makanan (id_menu, nama_menu, harga, stok, kategori, foto) 
											 VALUES(null, '$nama_menu', '$harga', '$stok', '$kategori', '$foto')") or die(mysqli_error($mysqli));

			if ($result) {
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=success-in" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=failed-in" </script>';
			}
		}
		
	} elseif($action == "update") {

		$id_menu	= $_POST['id_menu'];
		$nama_menu	= $_POST['nama_menu'];
		$harga 		= $_POST['harga'];
		$stok 		= $_POST['stok'];
		$kategori 	= $_POST['kategori'];
		$file_name_sebelum = $_POST['file_name_sebelum'];
		// Ambil Data yang Dikirim dari Form
		$nama_file = $_FILES['file_name']['name'];
		$tmp_file  = $_FILES['file_name']['tmp_name'];

		$foto = rand().$nama_file;

		// Set path folder tempat menyimpan gambarnya
		$path = "../foto_menu/".$foto;

		if (move_uploaded_file($tmp_file, $path)) {
			$result = mysqli_query($mysqli, "UPDATE list_makanan
				  									SET 
				  									   id_menu		= '$id_menu',
				  									   nama_menu	= '$nama_menu',
				  									   harga 		= '$harga',
				  									   stok 		= '$stok',
				  									   kategori 	= '$kategori',
				  									   foto 		= '$foto'
				  									   WHERE id_menu = $id_menu
				  									") or die(mysqli_error($mysqli));

			if ($result) {
				$hapus_foto = unlink("../foto_menu/".$file_name_sebelum);
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=failed-ed" </script>';
			}
		} else {
			$result = mysqli_query($mysqli, "UPDATE list_makanan
				  									SET 
				  									   id_menu		= '$id_menu',
				  									   nama_menu	= '$nama_menu',
				  									   harga 		= '$harga',
				  									   stok 		= '$stok',
				  									   kategori 	= '$kategori',
				  									   foto 		= '$file_name_sebelum'
				  									   WHERE id_menu = $id_menu
				  									") or die(mysqli_error($mysqli));

			if ($result) {
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=failed-ed" </script>';
			}
		}

	} elseif($action == "delete") {

		$id_menu 	= $_GET['id_menu'];
		$foto 		= $_GET['foto'];

		$result = mysqli_query($mysqli, "DELETE FROM list_makanan WHERE id_menu = $id_menu") or die(mysqli_error($mysqli));

		if ($result) {
			$hapus_foto = unlink("../foto_menu/".$foto);
			echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=success-del" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../menu-makanan.php?desc=failed-del" </script>';
		}

	}

?>