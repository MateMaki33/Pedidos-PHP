<?php
 require_once 'DBconnectPDO.php';
 

 if ($_SERVER["REQUEST_METHOD"]=="POST") {

    $usu=comprobarUsuario($_POST['usuario'],$_POST['password']);
    if ($usu){
        session_start();
        $_SESSION["usuario"]=$usu;
        $_SESSION["carrito"]=[];
        header('Location: categorias.php');
        return;
    }
 }


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>LOGIN</title>
</head>
<body>
    
    <div class="contenedor">
            
        <div class="central">
            <div class="login">
                <div class="titulo">
                    Bienvenido
                    <p>
                      <?php 
                        
                         if (!isset($usu)) {
                         echo "Inserta credenciales";
                        }else if($usu==false){
                            echo "Intenta de nuevo";
                        }     
                      ?>
                    </p>
                </div>
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>  method="post" id="loginform">

                    <input type="text" name="usuario" placeholder="Usuario" required>
                        
                    <input type="password" placeholder="Contraseña" name="password" required>
                        
                    <button type="submit" title="Ingresar" name="Ingresar">Login</button>
                </form>
            </div>   
        </div>
    </div>
</body>
</html>