<?php 
session_start();
require("../includes/header.php");
if (isset($_SESSION['adminuser']))
{

    function foglaltNap($id, $ev, $ho, $nap)
  {
    global $con;

    $ret = 0;

    $datum = date('Y-m-d', strtotime($ev."-".str_pad($ho, 2, '0', STR_PAD_LEFT)."-".str_pad($nap, 2, '0', STR_PAD_LEFT)));
    $r = mysqli_query($con, "SELECT * FROM foglalasok WHERE szoba_fkid = $id AND erkezes<='$datum' AND tavozas>'$datum'");
    if (mysqli_num_rows($r)>0)
    {
      $row = mysqli_fetch_assoc($r);
      if ($row['veglegesitve']==null)
        $ret = -1;
      else 
        $ret = 1;
    }
    return $ret;
  }



$id = $_GET['id'];

if (isset($_GET['ev']) && isset($_GET['ho']))
{
    $date = strtotime(date('Y-m-d', strtotime($_GET['ev']."-".$_GET['ho']."-01")));
}
else
    $date = null;

    $honapnevek = array('', 'január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december');
    if ($date == null) $date = strtotime(date('Y-m-01'));

    $_SESSION['pagepos'][$id] = $date;

    $utolsonap = date('t', $date);
    $elsonaphanyadik = date('w', $date);
    if ($elsonaphanyadik == 0) $elsonaphanyadik = 7;
    $szovegesdatum = date('Y', $date).". ".$honapnevek[intval(date('m', $date))];
    $ev = date('Y', $date);
    $ho = date('m', $date);

    $elozo_ev = $ev;
    $elozo_ho = $ho-1; if ($elozo_ho == 0) { $elozo_ev--; $elozo_ho = 12;}

    $kovetkezo_ev = $ev;
    $kovetkezo_ho = $ho+1; if ($kovetkezo_ho>12) { $kovetkezo_ev++; $kovetkezo_ho = 1; }
    
    echo '<div class="row mb-2"><div class="col-2 text-left"><button class="btn btn-default" onclick="Pager('.$id.', '.$elozo_ev.', '.$elozo_ho.')". ><</button></div><div class="col-8 text-center"><strong>'.$szovegesdatum.'</strong></div><div class="col-2 text-right"><button class="btn btn-default" onclick="Pager('.$id.', '.$kovetkezo_ev.', '.$kovetkezo_ho.')">></button></div></div>';

    echo '<table class="table table-bordered text-center">';
    echo '<tr><th>H</th><th>K</th><th>SZ</th><th>CS</th><th>P</th><th>SZ</th><th>V</th></tr><tr>';

    $aktualisnap = 0;
    $aktualispoz = 1;
    while ($aktualisnap != $utolsonap)
    {
      if ($aktualisnap == 0 && $aktualispoz != $elsonaphanyadik)
      {
        echo '<td></td>';
        $aktualispoz++;
      }
      else
      {
        $aktualisnap++;
        $status = foglaltNap($id, $ev, $ho, $aktualisnap);
        if ($status == 1) // végleges
        echo '<td style="background: #19ff007a">'.$aktualisnap.'</td>';
        else if ($status == -1) // még nem végleges
        echo '<td style="background: #ff9b0094">'.$aktualisnap.'</td>';
        else
        echo '<td>'.$aktualisnap.'</td>';
        $aktualispoz++;
        if ($aktualispoz>7) 
        {
          echo '</tr><tr>';
          $aktualispoz = 1;
      }
    }
  }
  while ($aktualispoz != 7)
  {
    echo '<td></td>'; $aktualispoz++;
  }
  echo '</tr></table>';

}
?>