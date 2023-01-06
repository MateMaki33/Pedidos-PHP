<?php 
  require ('sesiones.php');
  require_once ('DBconnectPDO.php');
  comprobarSesion();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">

    <title>Pedidos</title>
</head>
<body>
    <?php 
    require('cabecera.php');
    $resul=insertarPedido($_SESSION['carrito'],$_SESSION['usuario']['codRes']);

    if ($resul===FALSE) {
        echo '<div class="titulo">
                  No se ha podido realizar el pedido
              </div><br>';
    }else {
        echo '<div class="titulo">
                  Todo ha salido correctamente
              </div><br>';
        $compra=$_SESSION['carrito'];
        $_SESSION['carrito']=[];
        
    }
    
    ?>
</body>
</html>