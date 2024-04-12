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
  <title>Foglalások | <?=SITE_NAME; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

  <style>
    @media screen and (min-width: 960px)
    {
      #moco {position: fixed!important; right: 30px!important; width: 40%!important}
    }
  </style>
</head>
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
            <h1 class="m-0">Foglalások</h1>
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
          <?php $r = mysqli_query($con, "SELECT * FROM szobak ORDER BY szoba_id");
                while ($row = mysqli_fetch_assoc($r))
                { ?>
                <div class="row">
                <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <h4><?=$row['szoba_nev']; ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="row">
                    <div class="col-md-4" id="naptar_<?=$row['szoba_id']; ?>">
                    </div>
                    <div class="col-md-8" id="foglalas_<?=$row['szoba_id']; ?>">
                    </div>
                    </div>
                  </div>

                  <div class="card-footer">
                    <button onclick="Booking(<?=$row['szoba_id']; ?>, '<?=$row['szoba_nev']; ?>')" class="btn btn-primary">Foglalás rögzítése</button>
                  </div>
                </div>
                </div>
                </div>
            <!-- /.row -->
                <?php } ?>
          
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

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content" id="moco">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Új foglalás</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <input type="hidden" id="modal_szoba_id">
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
        <h5 id="modal_szoba"></h5>
        </div>
        <div class="form-group">
          <label>Érkezés</label>
          <input type="date" id="modal_erkezes" class="form-control">
        </div>
        <div class="form-group">
          <label>Távozás</label>
          <input type="date" id="modal_tavozas" class="form-control">
        </div>
        <div class="form-group">
          <label>Vendég neve</label>
          <input type="text" id="modal_nev" class="form-control">
        </div>
        <div class="form-group">
          <label>Vendég e-mail cím</label>
          <input type="email" id="modal_email" class="form-control">
        </div>
        <div class="form-group">
          <label>Vendég telefonszám</label>
          <input type="text" id="modal_telefon" class="form-control">
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>Felnőttek</label>
              <input type="number" value=1 id="modal_felnottek" class="form-control">
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <label>Gyerekek</label>
              <input type="number" value=0 id="modal_gyerekek" class="form-control">
            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="$('#myModal').modal('close');" data-dismiss="modal">Mégse</button>
        <button type="button" class="btn btn-danger" onclick="SaveModal()">Mentés</button>
      </div>

    </div>
  </div>
</div>

</body>
</html>

<script>

  <?php $r = mysqli_query($con, "SELECT szoba_id FROM szobak");
        while ($row = mysqli_fetch_assoc($r))
        {
          ?>
Loader("generate-calendar.php?id=<?=$row['szoba_id']; ?>", "naptar_<?=$row['szoba_id']; ?>");
Loader("generate-booking-list.php?id=<?=$row['szoba_id']; ?>&ev=<?=date('Y'); ?>&ho=<?=date('m'); ?>", "foglalas_<?=$row['szoba_id']; ?>");
        <?php } ?>

function Pager(id, y, m)
{
  Loader("generate-calendar.php?id="+id+"&ev="+y+"&ho="+m, "naptar_"+id);
  Loader("generate-booking-list.php?id="+id+"&ev="+y+"&ho="+m, "foglalas_"+id);
}

function Booking(id, nev)
{
  document.getElementById('modal_szoba').innerHTML = nev;
  document.getElementById('modal_szoba_id').value = id;
  $('#myModal').modal('show');
}

function Accept(booking_id, room_id)
{
    var url="booking-ajax.php?accept="+booking_id+"&room_id="+room_id;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var res = this.responseText;
          var t = res.split(',');
          Pager(t[0], t[1], t[2]);
        } 
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

function Delete(booking_id, room_id)
{
  var url="booking-ajax.php?delete="+booking_id+"&room_id="+room_id;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
          var res = this.responseText;
          var t = res.split(',');
          Pager(t[0], t[1], t[2]);
        } 
    };
    xhttp.open("GET", url, true);
    xhttp.send();
}

function SaveModal()
{
  var szoba_fkid = document.getElementById('modal_szoba_id').value;
  var erkezes = document.getElementById('modal_erkezes').value;
  var tavozas = document.getElementById('modal_tavozas').value;
  var vendeg_nev = document.getElementById('modal_nev').value;
  var vendeg_email = document.getElementById('modal_email').value;
  var vendeg_telefon = document.getElementById('modal_telefon').value.replace('+', '%2B');
  var felnottek = document.getElementById('modal_felnottek').value;
  var gyerekek = document.getElementById('modal_gyerekek').value;

  if (erkezes == "" || tavozas == "" || vendeg_nev == "" || felnottek == "" || gyerekek == "")
  {
    alert ("Kérem, töltse ki a kötelező mezőket!");
  }
  else if (erkezes>=tavozas)
  {
    alert ("Az érkezésnek előbb kell történnie, mint a távozásnak és ezek nem eshetnek egy napra.");
  }
  else
  {
    var url="booking-ajax.php?booking&szoba_fkid="+szoba_fkid+"&erkezes="+erkezes+"&tavozas="+tavozas+"&vendeg_nev="+vendeg_nev+"&vendeg_email="+vendeg_email+"&vendeg_telefon="+vendeg_telefon+"&felnottek="+felnottek+"&gyerekek="+gyerekek;
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
            var res = this.responseText;
            if (res == "ERROR") alert ("A megadott időszakban ez a szoba nem foglalható.");
            else
            {
              $('#myModal').modal('hide');

              document.getElementById('modal_szoba_id').value = "";
              document.getElementById('modal_erkezes').value = "";
              document.getElementById('modal_tavozas').value = "";
              document.getElementById('modal_nev').value = "";
              document.getElementById('modal_email').value = "";
              document.getElementById('modal_telefon').value = "";
              document.getElementById('modal_felnottek').value = 1;
              document.getElementById('modal_gyerekek').value = 0;

              var t = res.split(',');
              Pager(t[0], t[1], t[2]);
            }
          } 
      };
      xhttp.open("GET", url, true);
      xhttp.send();
  }
}

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
