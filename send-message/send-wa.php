<?php 

	if (isset($_POST['submit'])) {
		$message = $_POST['message'];
		$nowa = $_POST['nowa'];

		header("location:https://api.whatsapp.com/send?phone=$nowa&text=$message");
	} else {
		echo "<script>window.location=history.go(-1);</script>";
	}
?>