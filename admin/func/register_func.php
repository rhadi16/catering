<?php  
  include '../config/connect.php';
  include '../config/auth.php';
 
	$action  = $_GET['action'];

	if($action == "delete")
	{ 
	  $email = $_GET['email'];

	  $result = mysqli_query($mysqli, "DELETE FROM utenti WHERE email = '$email'") or die(mysqli_error($mysqli));
	  
	  if($result){ 
	      echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=success-del" </script>';
	  }else{
	      echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
	  }
	}
?>