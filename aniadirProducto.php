<?php

/* 
Tras comprobar sesión, obtenemos los datos POST al pulsar comprar en productos.php
Si en el array que se crea al hacer login, existe el código recibido,
se suman las unidades marcadas. Si no existe, lo crea y le asigna el valor $unidades
*/
    require_once('sesiones.php');
    comprobarSesion();
    $codigo=$_POST['codProd'];
    $unidades=(int)$_POST['unidades'];
    $stock=(int)$_POST['stock'];
    $noStock=false;

    if (isset($_SESSION['carrito'][$codigo]) && $unidades<=$stock){
        $_SESSION['carrito'][$codigo]+=$unidades;
        

//Si se pasa de stock, redirige a productos

    }else if (isset($_SESSION['carrito'][$codigo]) && $unidades>$stock) {
        $noStock=true;
        header('Location:productos.php?noStock='.$noStock);

//Si no existe se crea 
    } else {
        $_SESSION['carrito'][$codigo]=$unidades;
    }
    
    header('Location:carrito.php'); //Redirige a carrito.php

?>