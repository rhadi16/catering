<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submit'])) {
	$efrom = $_POST['efrom'];
	$name = $_POST['name'];
	$eto = $_POST['eto'];

	$message = "<table>
								<tr>
									<td><b>Nama</b></td>
									<td><b> : </b></td>
									<td><b>".$name."</b></td>
								</tr>
								<tr>
									<td><b>Email Dari</b></td>
									<td><b> : </b></td>
									<td><b>".$efrom."</b></td>
								</tr>
							</table><br>".$_POST['message'];

	$mail = new PHPMailer(true);

	$mail->SMTPDebug = 2;
	$mail->isSMTP();
	$mail->Host       = 'smtp.gmail.com';
	$mail->SMTPAuth   = true;
	$mail->Username   = 'jicoba1234@gmail.com';
	$mail->Password   = 'pclfuwtodgqochqp';
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	$mail->Port       = 465; 
	//Recipients
	$mail->setFrom($efrom, $name);
	$mail->addAddress($eto);

	$mail->isHTML(true);
	$mail->Subject = 'Email Dari Users';
	$mail->Body    = $message;
	$send = $mail->send();

}
header("location:../index.php?desc=success-send");

?>