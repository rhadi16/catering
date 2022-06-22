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
//check the cookie and set the session user 
include("admin/config/auth.php");
include("admin/config/connect.php");

//if session is set means that the user is already logged in, so doesnt show the login page to an user already logged


if (isset($_SESSION['user'])) {
//When user logged try to access to login page...
//header("location:content.php"); //decomment this line for redirect to content page 
$konf_login="Anda Telah Melakukan Login. Silahkan ke Halaman <a href=admin/index.php>Admin</a> ";//or stay in this page and show a message
}

// *********************************
// * CHECK IF USER/PW MATCH        *
// *********************************

//if login form is submitted 
if (isset($_POST["login"])) {

$_POST["email"]=trim($_POST["email"]);

do {
//if not valid email "end cicle" and show again the login form
if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)===false or !preg_match('/@.+\./', $_POST["email"])) {$message="Invalid Email";break;}

//******************** ADD A DELAY FOR AVOID BRUTAL FORCE ATTACKS 
//otherwise read from database how many login attemps in the last 10 minutes from the same IP address
$sql = $db->prepare("SELECT data FROM log_accessi WHERE ip='".$_SERVER['REMOTE_ADDR']."' and accesso=0 and data>date_sub(now(), interval 1 minute) ORDER BY data DESC");
$sql->execute();
$attempts=$sql->rowCount();
$last=$sql->fetchColumn();
  
$last=strtotime($last);
$delay=min(max(($attempts-4),0)*2,30); //after 3rd wrong try, add a delay of (# attempts * 2) as seconds (maximum 30 seconds each try)
  
//if there are many tries in few second, show a messagge and "end cicle" so doesnt check the email/pw this time
if ($attempts>3) {$message="Terlalu Banyak Percobaan, Silahkan Menunggu Beberapa Saat";break;}
//***************************************************************

if ($_POST["oten"] == "pelanggan") {
  $sql = $db->prepare("SELECT * FROM pelanggan WHERE email=?");
  $sql->bindParam(1, $_POST["email"]);
  $sql->execute();
  $rows = $sql->fetch(PDO::FETCH_ASSOC);  

  $oten = "pelanggan";
} elseif ($_POST["oten"] == "admin") {
  $sql = $db->prepare("SELECT * FROM utenti WHERE email=?");
  $sql->bindParam(1, $_POST["email"]);
  $sql->execute();
  $rows = $sql->fetch(PDO::FETCH_ASSOC);  

  $oten = "admin";
}

//check if password type is match with password in the database
//using php function password_hash in the register.php and password_verify here
//I add the constant PEPPER has salt (see check.php) the system already set a secure salt with the function password_hash
//(if u remove PEPPER or change it remember to do that in the register.php too)

$checked = password_verify($_POST['password'].PEPPER, $rows["password"]);
if ($checked) { //if email/pw are right:
    $message='password correct<br>enjoy content <a href=index.php>here</a>';
  $_SESSION['user'] = $rows["id"];
  $_SESSION['utenti'] = $oten;
  
  //...and if remember me checked send the cookie
  if ($_POST["remember"]=="true") {
  
  //create a random selector and auth code in the token database
    //function aZ is in the check.php file
   $selector = aZ();
   $authenticator = bin2hex(random_ver(33));
     $res=$db->prepare("INSERT INTO auth_tokens (selector,hashedvalidator,userid,expires,ip) VALUES (?,?,?,FROM_UNIXTIME(".(time() + 864000*7)."),?)");
     $res->execute(array($selector,password_hash($authenticator, PASSWORD_DEFAULT, ['cost' => 12]),$rows['id'],$_SERVER['REMOTE_ADDR']));     
//set the cookie
setcookie(
        'remember',
         $selector.':'.base64_encode($authenticator),
         time() + 864000*7 //the cookie will be valid for 7 days, or till log-out
    );
}

//redirect to page with content only for members
if ($oten == "admin") {
  echo '<script language="javascript"> window.location.href = "admin/index.php" </script>';
} else {
  echo '<script language="javascript"> window.location.href = "pelanggan/index.php" </script>';
  echo '<script language="javascript"> alert("gagal") </script>';
}

//if email/pw are wrong 
} else {
    $message=($attempts>1)?"Banyak Percobaan ($attempts)":"Anda Salah Memasukkan Email/Password";
}

echo '<script language="javascript"> console.log("arger") </script>';
//save the access log
$sql = $db->prepare("INSERT INTO log_accessi (ip,mail_immessa,accesso) VALUES (? ,? ,?)");
$sql->bindParam(1, $_SERVER['REMOTE_ADDR']);
$sql->bindParam(2, $_POST["email"]);
$sql->bindParam(3, $checked);
$sql->execute();

}while(0);

}

// *********************************
// * HTML FOR LOGIN FORM           *
// *********************************

?>

<?php 
  $qry    = "SELECT * FROM list_makanan";
      
  $orderby = ""; 

  $view   = "index.php";

  $column = [
              'value'  => ['nama_menu', 'harga'],
              'label'  => ['Nama Menu', 'Harga Menu'],
              'type'   => ['text', 'double']
            ];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Signika&family=Varela+Round&display=swap" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Catering Abah Ayi</title>
  </head>

  <body>

    <div class="navbar-fixed">
      <nav class="indigo darken-4">
        <div class="container">
          <div class="nav-wrapper">
            <a href="#!" class="brand-logo">Catering Abah Ayi</a>
            <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down">
              <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="registrasi.php">Registrasi</a></li>
              <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#login">Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <ul class="sidenav" id="mobile-demo">
      <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="registrasi.php">Registrasi</a></li>
      <li><a class="waves-effect waves-light btn modal-trigger blue darken-3" href="#login">Login</a></li>
    </ul>

    <!-- Modal Structure -->
    <div class="container">
      <div id="login" class="modal container">
        <?php if (isset($konf_login)) { ?>
        <div class="modal-content">
          <h4>Login Admin</h4>
          <p><?php echo $konf_login; ?></p>
        </div>
        <div class="modal-footer">
          <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
        </div>
        <?php } ?>
        <?php if (empty($_SESSION["user"])) { ?>
        <form method="post" action="">
          <div class="modal-content">
            <h4>Login Admin</h4>
            <p style="color: #C00; text-align: center;"><b><?php if(isset($message)){ echo $message; } ?></b></p>
              <div class="row">
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_box</i>
                  <input id="icon_prefix" type="email" class="validate" name="email" required>
                  <label for="icon_prefix">Email</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">lock</i>
                  <input id="icon_telephone" type="password" name="password" class="validate" required>
                  <label for="icon_telephone">Password</label>
                </div>
                <div class="input-field col s12">
                  <i class="material-icons prefix">account_box</i>
                  <select name="oten" required>
                    <option value="admin">Admin</option>
                    <option value="pelanggan">Pelanggan</option>
                  </select>
                  <label>Login Sebagai</label>
                </div>
                <label class="remember">
                  <input type="checkbox" name="remember" value="true"/>
                  <span>Remember Me</span>
                </label>
              </div>
          </div>
          <div class="modal-footer">
            <button class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</button>
            <input type="hidden" name="login" value="login">
            <button type="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">input</i>Login</button>
          </div>
        </form>
        <?php } ?>
      </div>
    </div>

    <div class="page-header">
      <div class="page-header-bg"></div>
      <div class="container">
        <div class="row content-header white-text">
          <div class="col s12 m12 l8">
            <h2>Selamat Datang</h2>
            <h5>Di Catering Abah Ayi merupakan wirausaha yang melayani pemesanan berbagai macam masakan baik untuk pesta maupun untuk penunjang kebutuhan suatu instansi.</h5>
          </div>
          <div class="col s12 m12 l4">
            <div class="card-panel">
              <div class="row">
                <div class="col s6">
                  <i class="bi bi-shop"></i>
                </div>
                <div class="col s6">
                  <i class="bi bi-handbag"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="account container">
      <div class="container">
        <a class="modal-trigger blue darken-3 tooltipped" data-position="bottom" data-tooltip="Whatsapp" href="#send-wa"><i class="bi bi-whatsapp"></i></a>
        <a class="blue darken-3 tooltipped" data-position="bottom" data-tooltip="Facebook"><i class="bi bi-facebook"></i></a>
        <a class="blue darken-3 tooltipped" data-position="bottom" data-tooltip="Instagram"><i class="bi bi-instagram"></i></a>
        <a class="modal-trigger blue darken-3 tooltipped" data-position="bottom" data-tooltip="Email"href="#send-email"><i class="bi bi-envelope"></i></a>
      </div>
    </div>
    <div class="container">
      <!-- Modal Structure -->
      <div id="send-wa" class="modal">
        <form method="post" action="send-message/send-wa.php" target="_blank">
          <div class="modal-content">
            <h4>Send WhatsApp</h4>
            <div class="row">
              <div class="input-field col s12">
                <i class="material-icons prefix">chat_bubble</i>
                <textarea id="text-wa" class="materialize-textarea" name="message"></textarea>
                <label for="text-wa">Masukkan Pesan</label>
              </div>
              <?php 
                $fix_wa = "6285255554789";
              ?>
              <input type="hidden" name="nowa" value="<?php echo $fix_wa; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
            <input type="hidden" name="login" value="login">
            <button type="submit" name="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">send</i>Kirim</button>
          </div>
        </form>
      </div>

      <!-- Modal Structure -->
      <div id="send-email" class="modal">
        <form method="post" action="send-message/send-email.php">
          <div class="modal-content">
            <h4>Send Email</h4>
            <div class="row">
              <div class="input-field col s12">
                <input id="your_email" type="email" class="validate" required name="efrom">
                <label for="your_email">Masukkan Email Anda</label>
              </div>
              <div class="input-field col s12">
                <input id="your_name" type="text" class="validate" required name="name">
                <label for="your_name">Masukkan Nama Anda</label>
              </div>
              <div class="input-field col s12">
                <textarea id="text-email" class="materialize-textarea" name="message" required></textarea>
                <label for="text-email">Masukkan Pesan</label>
              </div>
              <input type="hidden" name="eto" value="<?php echo $adm['email']; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <a class="waves-effect waves-light btn modal-close red darken-4"><i class="material-icons left">close</i>Tutup</a>
            <button type="submit" name="submit" class="waves-effect waves-light btn light-green accent-4"><i class="material-icons left">send</i>Kirim</button>
          </div>
        </form>
      </div>
    </div>

    <div class="container">
      <div class="container pencarian-barang">
        <div class="card">
          <?php include('paginasi/pencarian.php'); ?>
        </div>
      </div>
    </div>

    <section id="list-barang">
      <div class="container">
        <div class="row">
          <?php 
            include('paginasi/main-paginasi.php');

            while($data = mysqli_fetch_array($dt)){
          ?>
          <div class="col s6 m3 l2">
            <div class="card-panel">
              <div class="img-brg" style="background-image: url('admin/foto_menu/<?php echo $data['foto']; ?>');"></div>
              <table>
                <tbody>
                  <tr>
                    <th class="center-align"><?php echo $data['nama_menu']; ?></th>
                  </tr>
                  <tr>
                    <th class="center-align">
                      Rp. <?php echo number_format($data['harga'],0,",","."); ?> 
                    </th>
                  </tr>
                  <tr>
                    <?php 
                      if ($data['stok'] == 0) {
                        echo '<th class="center-align red-text">Sold Out</th>';
                       } else {
                        echo '<th class="center-align green-text">Ready '.$data['stok'].'</th>';
                       }
                    ?>
                  </tr>
                  <tr>
                    <th class="center-align">
                      <?php echo $data['kategori']; ?>
                    </th>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <?php } ?>
        </div>

        <?php include('paginasi/btn-paginasi.php'); ?>
      </div>
    </section>

    <div class="footer indigo darken-4">
      <div class="container">
        <div class="row">
          <div class="col s12">
            <h5 class="white-text">OFFICE</h5>
            <ul>
              <li class="white-text">Catering Abah Ayi</li>
              <li class="white-text">Jl. Perintis Kemerdekaan IV No. 30</li>
              <li class="white-text">Kec. Tamalanrea, kota makassar</li>
            </ul>
          </div>
        </div>
        <?php
          error_reporting(0);
          $desc = $_GET['desc']; 
          if ($desc == "success-send") {
        ?>
          <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
        <?php } elseif ($desc == "success-reg") { ?>
          <div class="desc-in" data-flashdata="<?php echo $desc; ?>"></div>
        <?php } ?>
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="admin/asset/sweetalert/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
  </body>
</html>