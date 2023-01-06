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
    <title>Lista de Categorias</title>
</head>
<body>
    <?php include('cabecera.php')?>

    <div class="contenedor">
            
        <div class="central">
            <div class="login">
                <div class="titulo">
                    Categorias
                </div>

                <?php 
                  $categorias=cargarCategoriasGeneral();
                  if($categorias===FALSE){
                    echo '<p>Error al conectar a BD</p>';
                  }else{
                    echo '<ul>';
                  foreach($categorias as $fila){
                    $url='productos.php?categoria='.$fila['Nombre'];
                    echo "<li><a href='$url'>".$fila['Nombre'].'</li>'.'<br>';
                  }
                  echo '</ul>';
                  }
                ?>

            </div>   
        </div>
    </div>
    
</body>
</html>