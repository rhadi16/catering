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

    <div class="container registrasi">
      <div class="card-panel">
        <form method="post" action="func_regis.php">
          <h4>Registrasi Pelanggan</h4>
            <div class="row">
              <div class="input-field col s12">
                <input id="email" type="email" class="validate" name="email" required>
                <label for="email">Email</label>
              </div>
              <div class="input-field col s12">
                <input id="nama" type="text" class="validate" name="nama" required>
                <label for="nama">Nama Pelanggan</label>
              </div>
              <div class="input-field col s12">
                <input id="alamat" type="text" class="validate" name="alamat" required>
                <label for="alamat">Alamat Pemilik/Toko</label>
              </div>
              <div class="input-field col s12">
                <input id="no_wa" type="text" class="validate" name="no_wa" required>
                <label for="no_wa">Nomor HP Pelanggan</label>
              </div>
              <div class="input-field col s12">
                <input id="tgl_lahir" type="date" class="validate" name="tgl_lahir" required>
                <label for="tgl_lahir">Tanggal Lahir</label>
              </div>
              <div class="input-field col s12">
                <input id="password" type="password" name="password" class="validate" required>
                <label for="password">Password</label>
              </div>
            </div>
          <div class="right-align">
            <a class="waves-effect waves-light btn red darken-3" href="index.php">Kembali</a>
            <input type="hidden" name="register" value="register">
            <button type="submit" class="waves-effect waves-light btn light-green accent-4">Registrasi</button>
          </div>
        </form>      
      </div>
    </div>

    <!--JavaScript at end of body for optimized loading-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src="admin/asset/sweetalert/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
  </body>
</html>