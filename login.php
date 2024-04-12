<?php
  session_start();
  require("../includes/config.php");
  require("../includes/header.php");

  if (isset($_GET['quit']))
  {
    unset($_SESSION['adminuser']);
  }

  if(isset($_POST['submit']))
  {
    $r = mysqli_query($con, "SELECT * FROM ".DB_PREFIX."users WHERE username='".$_POST['username']."' AND password='".md5($_POST['password'])."'");
    if (mysqli_num_rows($r)>0)
    {
      $row = mysqli_fetch_assoc($r);
      mysqli_query($con, "UPDATE ".DB_PREFIX."users SET last_login ='".date('Y-m-d H:i:s')."' WHERE user_id = ".$row['user_id']);
      $_SESSION['adminuser'] = $row;
      unset($_SESSION['adminuser']['password']);
    }
  }

  if (isset($_SESSION['adminuser']))
  {
    header("Location: index.php");
  }




?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bejelentkezés | <?=SITE_NAME; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/raktar.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <?php /* <img src="<?=SITE_LOGO; ?>" class="logo150" */ ?>
    <b><?=SITE_NAME; ?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Jelentkezz be a folytatáshoz!</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input name="username" required type="text" onchange="document.getElementById('unsuccessful_login').classList.add('hide'); console.log('chng')" class="form-control" placeholder="Felhasználónév" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input name="password" type="password" onchange="document.getElementById('unsuccessful_login').classList.add('hide');" class="form-control" placeholder="Jelszó">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="icheck-primary">
              <input name="remember" type="checkbox" id="remember">
              <label for="remember">
                Emlékezz rám
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Bejelentkezés</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1 mt-5">
        <a href="elfelejtett-jelszo.php">Elfelejtettem a jelszavam. 😒</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
