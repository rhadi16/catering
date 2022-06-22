<?php 

	include '../config/connect.php';
	include '../config/auth.php';

	$action  = $_GET['action'];

	if ($action == "insert") {
		
		$nama 	 = $_POST['nama'];
		$jabatan = $_POST['jabatan'];
		$email 	 = $_POST['email'];
		$hp 	 = $_POST['hp'];
		// Ambil Data yang Dikirim dari Form
		$nama_file = $_FILES['file_name']['name'];
		$tmp_file  = $_FILES['file_name']['tmp_name'];

		$foto = rand().$nama_file;

		// Set path folder tempat menyimpan gambarnya
		$path = "../foto/".$foto;

		if (move_uploaded_file($tmp_file, $path)) {
			$result = mysqli_query($mysqli, "INSERT INTO pegawai (id, nama, jabatan, email, hp, foto) 
											 VALUES(null, '$nama', '$jabatan', '$email', '$hp', '$foto')") or die(mysqli_error($mysqli));

			if ($result) {
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=success-in" </script>';
			} else {
				echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=failed-in" </script>';
			}
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

		$email_lama = $_POST['email_lama'];

		$dt1 = mysqli_query($mysqli, "SELECT * FROM utenti WHERE email = '$email_lama'");
        $d1  = mysqli_fetch_array($dt1);

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

			$result1= mysqli_query($mysqli, "UPDATE utenti SET email = '$email' WHERE email = '$email_lama'") 
											or die(mysqli_error($mysqli));

			if ($result && $result1) {
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

			$result1= mysqli_query($mysqli, "UPDATE utenti SET email = '$email' WHERE email = '$email_lama'") 
											or die(mysqli_error($mysqli));

			if ($result && $result1) {
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