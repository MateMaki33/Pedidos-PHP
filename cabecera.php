<!-- Header que mostraremos en todas -->

<header id="cabecera">
   <h2> Usuario: <?php echo $_SESSION['usuario']['correo'];?></h2>
   <div id="menu">
     <a href="categorias.php">Home</a>
     <a href="carrito.php">Carrito</a>
     <a href="logout.php">Cerrar Sesión</a>
   </div>
    
</header>