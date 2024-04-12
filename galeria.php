<?php
  session_start();
  require("../includes/header.php");
  if (!isset($_SESSION['adminuser'])) header("Location: login.php");

?>

<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Galéria | <?=SITE_NAME; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  
  <style>
    .foglalt { background: green!important; }
  </style>
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php require("navbar.php"); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Rólunk</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
</video>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" >
                        <div class="row">
                            <?php 
                                $r=mysqli_query($con,"select * from galeria");
                                while($row=mysqli_fetch_assoc($r)){ ?>
                                    <div class="col-md-3">
                                        <img src="<?=$row["kepurl"];?>" class="img-thumbnail">
                                        <p style="text-align:center"><?=$row["kepcim"];?></p>
                                    </div>
                                <?php }
                            ?> 
                        </div>
                    </div>
                </div>

            </div>
          </div>
          
      </div>
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <form action="galeria-upload.php" method="POST" enctype="multipart/form-data">
                                    <input type="file" name="feltoltes" accept="image/*" class="form-control">
                                    <input type="submit" name="submit" value="Feltöltés">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
          </div>
          
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <?php require("footer.php"); ?>


</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/pages/dashboard3.js"></script>


</body>
</html>

