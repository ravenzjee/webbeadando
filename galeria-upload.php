<?php
  session_start();
  require("../includes/header.php");
  if (!isset($_SESSION['adminuser'])) die();

  $extUpload = strtolower( substr( strrchr($_FILES['feltoltes']['name'], '.') ,1) );
        if($_FILES['feltoltes']['error'] > 0) { echo 'Error during uploading, try again'; }
        $dir = "upload/";
        $newname=pathinfo($_FILES['feltoltes']['name'], PATHINFO_FILENAME)."-".date('YmdHis');//két ugyan olyan nevű file ne kerüljön feltöltésre
        $nnname = $newname.".".$extUpload;
        $name = $dir.$nnname;
        $result = move_uploaded_file($_FILES['feltoltes']['tmp_name'], $name);
        $filename = $nnname;
        if($result){                   
            $sql = "INSERT INTO galeria (kepurl, kepcim) VALUES ($name, '{$_POST[kepcim]}')";
            $q = mysqli_query($con, $sql);
        }
    header("Location: galeria.php");

?>