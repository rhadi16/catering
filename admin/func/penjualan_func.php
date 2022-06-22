<?php 

	include '../config/connect.php';
	include '../config/auth.php';

	$action  = $_GET['action'];

	if($action == "delete") {

        $id = $data['id'];
        
        $result  = mysqli_query($mysqli, "DELETE FROM penjualan WHERE id = $id") or die(mysqli_error($mysqli));

		if ($result) {
			echo '<script language="javascript"> window.location.href = "../penjualan.php?desc=success-del" </script>';
		} else {
			echo '<script language="javascript"> window.location.href = "../penjualan.php?desc=failed-del" </script>';
		}

	}

?>