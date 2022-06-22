<?php 

	include '../config/connect.php';
	include '../config/auth.php';

	$action  = $_GET['action'];

	if ($action == "admin") {
		
		$id_nama = $_POST['id_nama'];

		$result = mysqli_query($mysqli, "INSERT INTO admin (id, id_nama) 
										 VALUES(null, '$id_nama')") or die(mysqli_error($mysqli));

		if ($result) {
			echo '<script language="javascript"> window.location.href = "../index.php?desc=success-adm" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../index.php?desc=failed-adm" </script>';
		}
	} elseif($action == "update") {

		$id 			   = $_POST['id'];
		$nama 	 		   = $_POST['nama'];
		$jabatan 		   = $_POST['jabatan'];
		$email 	 		   = $_POST['email'];
		$hp 			   = $_POST['hp'];
		$file_name_sebelum = $_POST['file_name_sebelum'];
		// Ambil Data yang Dikirim dari Form
		$nama_file = $_FILES['file_name']['name'];
		$tmp_file  = $_FILES['file_name']['tmp_name'];

		$foto = rand().$nama_file;

		// Set path folder tempat menyimpan gambarnya
		$path = "../foto/".$foto;

		if (move_uploaded_file($tmp_file, $path)) {
			$result = mysqli_query($mysqli, "UPDATE pegawai
				  									SET 
				  									   id      = '$id',
				  									   nama    = '$nama',
				  									   jabatan = '$jabatan',
				  									   email   = '$email',
				  									   hp      = '$hp',
				  									   foto    = '$foto'
				  									   WHERE id = $id
				  									") or die(mysqli_error($mysqli));

			if ($result) {
				$hapus_foto = unlink("../foto/".$file_name_sebelum);
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=failed-ed" </script>';
			}
		} else {
			$result = mysqli_query($mysqli, "UPDATE pegawai
				  									SET 
				  									   id      = '$id',
				  									   nama    = '$nama',
				  									   jabatan = '$jabatan',
				  									   email   = '$email',
				  									   hp      = '$hp',
				  									   foto    = '$file_name_sebelum'
				  									   WHERE id = $id
				  									") or die(mysqli_error($mysqli));

			if ($result) {
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=success-ed" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=failed-ed" </script>';
			}
		}

	} elseif($action == "delete") {

		$id   = $_GET['id'];
		$foto = $_GET['foto'];

		$result = mysqli_query($mysqli, "DELETE FROM pegawai WHERE id = $id") or die(mysqli_error($mysqli));
		$hapus_foto = unlink("../foto/".$foto);

		if ($result) {
			echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=success-del" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=failed-del" </script>';
		}

	}

?>