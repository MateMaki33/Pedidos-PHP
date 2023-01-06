<?php
  require_once('DBconnectPDO.php');
  require_once('sesiones.php');
  comprobarSesion();

  //Cogemos los datos del formulario en el carrito

  $unidadesEliminadas=$_POST['eliminar'];
  $cod=$_POST['cod'];
  $noEliminado=false;

  //Se podrán eliminar unidades siempre que elijamos menos o igual que las que hay.
  //En el form ya está limitado de todas maneras con min y max.

  if($_SESSION['carrito'][$cod]>=$unidadesEliminadas && $_SESSION['carrito'][$cod]!=0 ) {

    $_SESSION['carrito'][$cod]-=$unidadesEliminadas;
    header('Location:carrito.php');

  }
  
  /*
  En caso de haber 0 unidades de un producto, este se elimina del array
  y mandamos por GET en URL 2 parametros boleanos que nos servirán para 
  crear un mensaje en carrito.php en caso de ser true.
  
  */
  
  if($_SESSION['carrito'][$cod]==0){
    $noEliminado=true;
    unset($_SESSION['carrito'][$cod]);
    header("Location:carrito.php?noEliminado=$noEliminado&codProd=$cod");
  }

?>