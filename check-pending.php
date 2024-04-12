<?php 
session_start();
require("../includes/header.php");
if (isset($_SESSION['adminuser']))
{
    $r = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS db FROM foglalasok WHERE veglegesitve IS NULL"))['db'];
    echo $r;
} ?>