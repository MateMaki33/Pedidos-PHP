<?php 
    require_once('DBconnectPDO.php');
    require_once('sesiones.php');
    comprobarSesion();
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Document</title>
</head>
<body>
    <?php 
       require('cabecera.php');
    ?>
    <div class="titulo">
        <h1>
            Carrito
        </h1>
        <table>
            <thead>
                <tr>
                  
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Peso</th>
                  <th>Unidades</th>
                  
                </tr>  
            </thead>

            <tbody>
                <?php
                 $productos=cargarProductosByCod(array_keys($_SESSION['carrito']));
                 
                  if ($_SESSION['carrito']!=null) { 
                    foreach($productos as $fila){
                        $cod=$fila['CodProd'];
                        $nombre=$fila['Nombre'];
                        $descripcion=$fila['Descripcion'];
                        $peso=$fila['Peso'];
                        $unidades=$_SESSION['carrito'][$cod];
                        
                        echo "<tr>
                              
                              <td>".$nombre.'</td>
                              <td>'.$descripcion.'</td>
                              <td>'.$peso.'</td>
                              <td>'.$unidades."</td>
                              <td>
                                <form action='eliminarProducto.php' method='post'>
                              <input type='number' name='eliminar' min='1' max='$unidades' value='1'>
                              <input type='submit' value='Eliminar'>
                              <input type='hidden' name='cod' value='$cod'></form></td>
                              </tr>";
                    }
                }
                 
                ?>
            </tbody>
        </table>
        <a href="procesarPedido.php">Realizar el pedido</a>
        <div class="error">
            <?php
            
            if (isset($_GET['noEliminado']) && $_GET['noEliminado']==true){
                if(isset($_GET['codProd']) && $_GET['noEliminado']==true){
                    $eliminado=productoPorCodigo($_GET['codProd']);
                    echo "<h5>Ultimo eliminado '$eliminado'</h5>";
                
                }
                
            }
            
            ?>
        </div>
        
    </div>
</body>

</html>