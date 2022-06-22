<?php
/*
 *
 * LOGIN 3R: A secure PHP Login Script with Register, Remember, and Reset function
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author jotaroita
 * @link https://github.com/jotaroita/secure-login-php7-remember-register-resetpw
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * INSTALL:
 * 1. upload all file in a folder in your server
 * 2. edit check.php and config variables
 * 3. execute query for set tables in your database see setup.sql file
 * 4. run the script www.yoursite.com/login3r/
 *
*/
session_start();
include("../config/auth.php");

//if form sent
if (isset($_POST["register"])) {
$_POST["email"]=trim($_POST["email"]);

do {
//check if email is valid, if the 2 password match and if PW is atleast 8 char long, usefull if js is disable on user browser
if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)===false or !preg_match('/@.+\./', $_POST["email"])) {$error="Invalid Email";break;}
if (strlen($_POST["password"])<8) {echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=short-pass" </script>';break;}

//check if email already registerd in DB
$sql = $db->prepare("SELECT * FROM utenti WHERE email=?");
$sql->bindParam(1, $_POST["email"]);
$sql->execute();
$exists=$sql->rowCount();

if ($exists) {echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=email-ready" </script>';break;}

// save new user in the DB, here i used the PEPPER constant defined in the check.php as additional salt
// Hash a new password for storing in the database.
// The function automatically generates a cryptographically safe salt.
//(if u remove PEPPER or change it remember to do that in the login.php too)
$hash = password_hash($_POST['password'].PEPPER, PASSWORD_DEFAULT, ['cost' => 12]);

try {
$sql = $db->prepare("INSERT INTO utenti (email,password) VALUES (? ,?)");
$sql->bindParam(1, $_POST["email"]);
$sql->bindParam(2, $hash);
$sql->execute();
} catch (PDOException $e) {
$error="Error during ";break;
}

$registered=1;
echo '<script language="javascript"> window.location.href = "../pegawai.php?desc=succes-regis" </script>';

} while(0);

}
//disattivare submit dopo il primo click poi riattivarlo oppure valutare ajax
?>