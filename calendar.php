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