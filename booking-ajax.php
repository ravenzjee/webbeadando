<?php 
session_start();
require("../includes/header.php");
if (isset($_SESSION['adminuser']))
{
    if (isset($_GET['accept']) && isset($_GET['room_id']))
    {
        $foglalas_id = $_GET['accept'];
        $szoba_fkid = $_GET['room_id'];
        $r = mysqli_query($con, "UPDATE foglalasok SET veglegesitve = '".date('Y-m-d H:i:s')."' WHERE foglalas_id = $foglalas_id");
        echo $szoba_fkid.",".date('Y', $_SESSION['pagepos'][$szoba_fkid]).",".date('m', $_SESSION['pagepos'][$szoba_fkid]);
    }
    else
    if (isset($_GET['delete']) && isset($_GET['room_id']))
    {
        $foglalas_id = $_GET['delete'];
        $szoba_fkid = $_GET['room_id'];
        $r = mysqli_query($con, "DELETE FROM foglalasok WHERE foglalas_id = $foglalas_id");
        echo $szoba_fkid.",".date('Y', $_SESSION['pagepos'][$szoba_fkid]).",".date('m', $_SESSION['pagepos'][$szoba_fkid]);
    }
    else if (isset($_GET['booking']))
    {
        // Megnézzük, hogy adott időszakban a szoba szabad-e

        $erkezes = $_GET['erkezes'];
        $tavozas = $_GET['tavozas'];
        $szoba_fkid = $_GET['szoba_fkid'];
        $vendeg_nev = $_GET['vendeg_nev'];
        $vendeg_email = $_GET['vendeg_email'];
        $vendeg_telefon = $_GET['vendeg_telefon'];
        $felnottek = $_GET['felnottek'];
        $gyerekek = $_GET['gyerekek'];

        if (!isset($_GET['owner'])) $owner = 'ügyintéző'; else $owner = $_GET['owner'];

        $sql = "SELECT COUNT(*) AS db FROM foglalasok WHERE szoba_fkid = $szoba_fkid AND 
            (
                ('$erkezes' <= erkezes AND '$tavozas' >= erkezes AND '$tavozas' <= tavozas) OR
                ('$erkezes' >= erkezes AND '$erkezes' < tavozas AND '$tavozas' >= tavozas) OR
                ('$erkezes' >= erkezes AND '$tavozas' <= tavozas) OR
                ('$erkezes' <= erkezes AND '$tavozas' >= tavozas) OR
                ('$erkezes' = erkezes AND '$tavozas' = tavozas)
            )";


        $db = mysqli_fetch_assoc(mysqli_query($con, $sql))['db'];
        if ($db > 0) echo "ERROR";
        else
        {
            if ($owner == 'ügyintéző')
            {
                $sql = "INSERT INTO foglalasok (rogzitve, erkezes, tavozas, vendeg_nev, vendeg_telefon, vendeg_email, szoba_fkid, felnottek, gyerekek, veglegesitve) 
                        VALUES ('$owner', '$erkezes', '$tavozas', '$vendeg_nev', '$vendeg_telefon', '$vendeg_email', $szoba_fkid, $felnottek, $gyerekek, '".date('Y-m-d H:i:s')."')";
            }
            else
            {
                $sql = "INSERT INTO foglalasok (rogzitve, erkezes, tavozas, vendeg_nev, vendeg_telefon, vendeg_email, szoba_fkid, felnottek, gyerekek) 
                        VALUES ('$owner', '$erkezes', '$tavozas', '$vendeg_nev', '$vendeg_telefon', '$vendeg_email', $szoba_fkid, $felnottek, $gyerekek)";
            }

            mysqli_query($con, $sql);
            echo $szoba_fkid.",".date('Y', $_SESSION['pagepos'][$szoba_fkid]).",".date('m', $_SESSION['pagepos'][$szoba_fkid]);                
        }
    }
} ?>