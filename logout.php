<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

//AL redirigir a esta pagina cerramos la sesion. Podemos poner un enlace a esta pagina que diga "Cerrar sesion" por ejemplo

  session_start();
  session_destroy();
  header("Location:formulario.php");
  
?>

    
</body>
</html>