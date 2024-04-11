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
  <title>Áttekintő naptár | <?=SITE_NAME; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            <h1 class="m-0">Áttekintő naptár</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
          <div class="col-md-12">
            <div class="alert alert-warning" role="alert" id="notif" style="display: none">
              Van <span id="notif_db">1</span> véglegesítésre váró foglalás!
              <button onclick="window.location.href='pending.php'" class="btn btn-sm btn-default" style="float: right; margin-top: -3px">Megnézem</button>
            </div>
          </div>
        </div>

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
                        <?php 
                            $date = date('Y-m-d');
                            $napok = array('vasárnap', 'hétfő', 'kedd', 'szerda', 'csütörtök', 'péntek', 'szombat');
                            for ($i=0; $i<31; $i++)
                            {
                                $sql = "SELECT * FROM foglalasok, szobak WHERE foglalasok.szoba_fkid = szobak.szoba_id AND erkezes<='$date' + interval $i day AND tavozas>'$date' + interval $i day ORDER BY szoba_id, erkezes";
                                $r = mysqli_query($con, $sql);
                                $db = mysqli_num_rows($r);
                                if ($db>0)
                                { $sz = 0; ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-5">
                                            <div class="card-header">
                                                <h5><strong><?=date('Y.m.d.', strtotime($date. '+ '.$i.' days')); ?>, <?=$napok[date('w', strtotime($date. '+ '.$i.' days'))]; ?></strong> – <?=$db; ?> lefoglalt szoba</h5>
                                            </div>
                                            <div class="card-body" id="tablazat">
                                                <div class="table table-responsive">
                                                    <table class="table table-sm table-hovered">
                                                    <tr><th>Szoba</th><th>Érkezés</th><th>Távozás</th><th>Vendég</th><th>Személyek</th></tr>
                                                    <?php 
                                                        while ($row = mysqli_fetch_assoc($r))
                                                        { ?>
                                                        <tr><td><?=$row['szoba_nev']; ?></td>
                                                        <td><?=date('Y.m.d.', strtotime($row['erkezes'])); ?></td>
                                                        <td><?=date('Y.m.d.', strtotime($row['tavozas'])); ?></td>
                                                        <td><?=$row['vendeg_nev']; ?></td>
                                                        <td><?php if ($row['felnottek']>0) echo $row['felnottek']." felnőtt"; if ($row['gyerekek']>0) echo ", ".$row['gyerekek']." gyerek"; ?></td>
                                                        </tr>
                                                   <?php $sz += intval($row['felnottek'])+intval($row['gyerekek']); }  ?>
                
                                                    </table>
                                            </div>
                                            </div>
                                            <div class="card-footer">
                                                <?=$sz; ?> fő az apartmanban.
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php } } ?>
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

<script>
setInterval(checkPending, 5000);
checkPending();

function checkPending()
{
  var url="check-pending.php";
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var res = this.responseText;
          if (res != "0")
          {
            document.getElementById("notif_db").innerHTML = res;
            document.getElementById("pendingcounter").innerHTML = res;
            document.getElementById("notif").style.display = "block";
          }
          else
          {
            document.getElementById("notif").style.display = "none";
            document.getElementById("pendingcounter").innerHTML = "";
          }
        } 
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

</script>