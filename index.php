<?php
  session_start();
  require("../includes/header.php");
  if (!isset($_SESSION['adminuser'])) header("Location: login.php");

?>