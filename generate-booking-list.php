<?php 
session_start();
require("../includes/header.php");

if (isset($_SESSION['adminuser']))
{
    $ev = $_GET['ev'];
    $ho = $_GET['ho'];
    $id = $_GET['id'];
    $db = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS db FROM foglalasok WHERE szoba_fkid = $id AND ((YEAR(erkezes) = $ev AND MONTH(erkezes) = $ho) OR (YEAR(tavozas) = $ev AND MONTH(tavozas) = $ho)) ORDER BY erkezes"))['db'];

    if ($db == 0)
    {
        echo '<p class="text-center">Erre a hónapra még nincs foglalás.</p>';
    }
    else
    { ?>
    <div class="table table-responsive">
    <table class="table table-sm table-hovered">
        <tr><th>Foglalva</th><th>Érkezés</th><th>Távozás</th><th>Vendég</th><th>Elérhetőség</th><th>Személyek</th><th>Forrás</th><th></th></tr>
        <?php 
        $r = mysqli_query($con, "SELECT * FROM foglalasok WHERE szoba_fkid = $id AND ((YEAR(erkezes) = $ev AND MONTH(erkezes) = $ho) OR (YEAR(tavozas) = $ev AND MONTH(tavozas) = $ho)) ORDER BY erkezes");
        while ($row = mysqli_fetch_assoc($r))
        {
            ?>
            <tr>
            <td><?=date('Y.m.d.<\b\r>H:i:s', strtotime($row['timestamp'])); ?></td>
            <td><?=date('Y.m.d.', strtotime($row['erkezes'])); ?></td>
            <td><?=date('Y.m.d.', strtotime($row['tavozas'])); ?></td>
            <td><?=$row['vendeg_nev']; ?></td>
            <td><?=$row['vendeg_telefon']; ?><br><a href="mailto:<?=$row['vendeg_email']; ?>"><?=$row['vendeg_email']; ?></a></td>
            <td><?php if ($row['felnottek']>0) echo $row['felnottek']." felnőtt"; if ($row['gyerekek']>0) echo ", ".$row['gyerekek']." gyerek"; ?></td>
            <td><?=$row['rogzitve']; ?></td>
            <td><?php if ($row['veglegesitve']==null) { ?>
                <button class="btn btn-sm btn-success" title="Véglegesítés" onclick="Accept(<?=$row['foglalas_id']; ?>, <?=$row['szoba_fkid']; ?>)"><i class="fa fa-check"></i></button>
            <?php } ?>
                <button class="btn btn-sm btn-danger" title="Törlés" onclick="if (confirm('Biztosan törli a foglalást? Ez a művelet nem vonható vissza.')) Delete(<?=$row['foglalas_id']; ?>, <?=$row['szoba_fkid']; ?>)"><i class="fas fa-times"></i></button>
            </tr>
        <?php } ?>
    </table>
            </div>
    <?php } } ?>