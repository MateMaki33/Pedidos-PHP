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
          
       $categoria=cargarCategoria($_GET['categoria']);//$categoria tiene propiedades CodCat y Descripcion 
       $producto=cargarProductosCategoria($_GET['categoria']);//array de arrays con los productos
       
    ?>
    <div class="titulo">
        <h1>
            <?php echo $categoria['Nombre']; ?>
        </h1>

        <table>
            <thead>
                <tr>
                  <th>Codigo</th>
                  <th>Nombre</th>
                  <th>Descripcion</th>
                  <th>Peso</th>
                  <th>Stock</th>
                  
                </tr>  
            </thead>

            <tbody>
                <?php
                
                   foreach($producto as $fila){
                    echo "<tr>
                          <td>".$fila['CodProd'].'</td>
                          <td>'.$fila['Nombre'].'</td>
                          <td>'.$fila['Descripcion'].'</td>
                          <td>'.$fila['Peso'].'</td>
                          <td>'.$fila['Stock']."</td>
                          <td>
                            <form action='aniadirProducto.php' method='post'>
                          <input type='number' name='unidades' min='1' value='1'>
                          <input type='submit' value='Comprar'>
                          <input type='hidden' name='stock' value=".$fila['Stock'].">
                          <input type='hidden' name='codProd' value=".$fila['CodProd']."></form></td>
                          </tr>";
                   }
                   
                ?>
            </tbody>
        </table>
        <div class="error">
            <?php
            
            if (isset($_GET['noStock']) && $_GET['noStock']==true){
                echo "<h3>No hay stock suficiente</h3>";
            }
            
            ?>
        </div>
    </div>
</body>
</html>