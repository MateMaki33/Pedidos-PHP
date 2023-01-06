<?php

//Conexion a BD con PDO

function conexionBD(){

  try{

    $base= new PDO('mysql:host=localhost; dbname=pedidostienda', 'root', '' ); //(host y nombre bd, usuario, contraseña)-> 3parametros
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //genera un objeto error que lanza excepcion
    $base->exec("SET CHARACTER SET utf8");
    return $base;

  }catch(PDOException $e){
      die('Error: ' . $e->getMessage(). '<br>');
  }
}

//Comprueba si el usuario y la contraseña son correctos. Si no, devuelve el formulario y si es correcto
//redirige a categorias php.

  function comprobarUsuario($codigo,$contraseña){

      $base= conexionBD();
    
      $consulta='SELECT * FROM restaurantes WHERE Correo = :usuario AND Clave = :password';
      $resultado=$base->prepare($consulta);

      $usuario=htmlentities(addslashes($codigo));
      $password=htmlentities(addslashes($contraseña));

      $resultado->bindParam(':usuario',$usuario);
      $resultado->bindParam(':password',$password);

      $resultado->execute();
      $numero_registros=$resultado->rowCount();
      
      if ($numero_registros !=0) {
      
        $fila=$resultado->fetch(PDO::FETCH_ASSOC);
        $codRes=$fila['CodRes'];
        $correo=$fila['Correo'];
        $usu=array(
          'codRes'=>$codRes,
          'correo'=>$correo,
        );

        return $usu;
    
        
      }else {
        $usu=false;
        return $usu;
      
      }
   

  }

 //Devuelve array con los nombres de las categorias

  function cargarCategoriasGeneral(){

    $base=conexionBD();
    $consulta='SELECT Nombre FROM categorias';
    $resultado=$base->query($consulta);
    return $resultado;
  }

  //Devuelve una categoria como objeto, con 3 propiedades 

  function cargarCategoria($categoria){

    $base=conexionBD();
    $consulta="SELECT * FROM categorias WHERE Nombre= :categoria";
    $resultado=$base->prepare($consulta);
    $categ=htmlentities(addslashes($categoria));
    $resultado->bindparam(':categoria',$categ);
    $resultado->execute();

    if ($resultado!=0) {

      $fila=$resultado->fetch(PDO::FETCH_ASSOC);
      $nombre=$fila['Nombre'];
      $codCat=$fila['CodCat'];
      $descr=$fila['Descripcion'];
      $cat=array(
        'Nombre'=>$nombre,
        'CodCat'=>$codCat,
        'Descripcion'=>$descr,
      );
      return $cat;
    }else{
      $cat=false;
      return $cat;
    }
    

  }
//Devuelve array de arrays, donde cada array es un producto y sus atributos 

  function cargarProductosCategoria($categoria){
    $base=conexionBD();
    $consulta="SELECT * FROM productos WHERE Categoria= :categoria";
    $resultado=$base->prepare($consulta);
    $codCategoria=cargarCategoria($categoria);
    $codCat=$codCategoria['CodCat'];
    $resultado->bindparam(':categoria',$codCat);
    $resultado->execute();
    

    if ($resultado!=0) {
      $productos=array();

      while($fila=$resultado->fetch() ){
      
        $codProd=$fila['CodProd'];
        $descr=$fila['Descripcion'];
        $nombre=$fila['Nombre'];
        $peso=$fila['Peso'];
        $stock=$fila['Stock'];
        $categ=$fila['Categoria'];
        $cat= array(
          'CodProd'=>$codProd,
          'Nombre'=>$nombre,
          'Descripcion'=>$descr,
          'Peso'=>$peso,
          'Stock'=>$stock,
          'Categoria'=>$categ,
        );

        array_push($productos, $cat);
        
      }

      return $productos;
    }else{
      $productos=false;
      return $productos;
    }

  }

//Devuelve productos dado un array de codigos de producto. Se utilizará para el carrito

  function cargarProductosByCod($arrayCodigos){

    $base=conexionBD();
    $textoIn=implode(",",$arrayCodigos);
    if ($textoIn!=""){
    $consulta="SELECT * FROM productos WHERE CodProd in ($textoIn)";
    $resultado=$base->query($consulta);
  
    if(!$resultado){
      return FALSE;
    }
    return $resultado;


    }else echo "<h2>No hay productos en su carrito</h2>";
    

  }
  
  //Devuelve el nombre del producto cuyo codigo se pasa por parámetro.
  function productoPorCodigo($codigo){
    $base=conexionBD();
    
    $consulta="SELECT Nombre FROM productos WHERE CodProd=$codigo";
    $resultado=$base->query($consulta);
    if ($resultado!=0) {
      $nombre;
      while($fila=$resultado->fetch() ){
        $nombre=$fila['Nombre'];
        return $nombre;
      }
      
    }else return FALSE;
    
  }

  //insertamos el pedido realizado en la tabla de la base de datos

  function insertarPedido($carrito, $codRes){
    $base=conexionBD();
    $base->beginTransaction();
    $hora=date("Y-m-d H:i:s", time());
     
    $sql="INSERT INTO pedidos (Fecha, Enviado, Restaurante) values ('$hora',0, $codRes)";

    $resul=$base->query($sql);

    if(!$resul){
      return FALSE;
    }

    $pedido=$base->lastInsertId();

    foreach($carrito as $codProd=>$unidades){
      $sql="INSERT INTO pedidosproductos (Pedido, Producto, Unidades) VALUES ($pedido,$codProd,$unidades)";
      echo $sql;
      $resul=$base->query($sql);
      if (!$resul) {
        $base->rollback();
        return FALSE;
      }
      $sql="UPDATE productos SET Stock= Stock - $unidades WHERE CodProd=$codProd";
      $resul=$base->query($sql);
      if (!$resul) {
        $base->rollback();
        return FALSE;
      }

    }

    $base->commit();
    return $pedido;


  }



  ?>
