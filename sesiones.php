<?php 
  function comprobarSesion(){

    require_once('DBconnectPDO.php');
    session_start();
    if (!isset($_SESSION['usuario'])) {
        header('Location:login.php');
    }

  }
    
?>