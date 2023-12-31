<?php


require 'flight/Flight.php';


Flight::register('db', 'PDO', array('sqlsrv:Server=localhost;Database=Productos','sa','musica0102'));




//Metodos GET de cada tabla
Flight::route('GET /get/tipo', function () {
    $estado =1;
    $sentencia= Flight::db()->prepare("SELECT * FROM Tipo WHERE Estado = $estado");
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);

    
});
//GetEspecifico Tipo
Flight::route('GET /get/tipo/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM Tipo WHERE IDTipo=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
});


Flight::route('GET /get/productos', function () {
    $estado =1;
    $sentencia= Flight::db()->prepare("SELECT * FROM Productos WHERE Estado = $estado");
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
    
   
});

Flight::route('GET /get/producto/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM Productos WHERE IDProducto=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
});


Flight::route('GET /get/caracteristicas', function () {
    $estado =1;
    $sentencia= Flight::db()->prepare("SELECT * FROM Caracteristicas WHERE Estado = $estado");
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
    
   
});

Flight::route('GET /get/caracteristicas/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM Caracteristicas WHERE idCaracteristica=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
});
Flight::route('GET /get/caracteristicas/producto/@id', function ($id) {
    $sentencia= Flight::db()->prepare("SELECT * FROM Caracteristicas WHERE IDProducto=?");
    $sentencia->bindParam(1,$id);
    $sentencia->execute();
    $datos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    Flight::json($datos);
});

//Metodos post de cada tabla
Flight::route('POST /tipo', function () {
    $nombre=(Flight::request()->data->Nombre);
    $estado =1;
    $sql="INSERT INTO Tipo (Nombre,Estado) VALUES (?,?)";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$estado);
    $sentencia ->execute();
    Flight::json(flight::request()->data);
      
});


Flight::route('POST /productos', function () {
    $nombre=(Flight::request()->data->Nombre);
    $tipo=(Flight::request()->data->Tipo);
    $marca=(Flight::request()->data->Marca);
    $estado =1;

    $sql="INSERT INTO Productos (Nombre,Tipo,Marca,Estado) VALUES (?,?,?,?)";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$tipo);
    $sentencia->bindParam(3,$marca);
    $sentencia->bindParam(4,$estado);
    $sentencia ->execute();
    Flight::json(flight::request()->data);
      
});

Flight::route('POST /caracteristicas', function () {
    $idProducto=(Flight::request()->data->IDProducto);
    $caracteristica=(Flight::request()->data->Caracteristica);
    $estado =1;
    
    $sql="INSERT INTO Caracteristicas (IDProducto,Caracteristica,Estado) VALUES (?,?,?)";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$idProducto);
    $sentencia->bindParam(2,$caracteristica);
    $sentencia->bindParam(3,$estado);
  
    $sentencia ->execute();

    Flight::json(flight::request()->data);
      
});

//Metodos eliminar
Flight::route('PUT /delete/tipo', function () {
    $id=(Flight::request()->data->IDTipo);
    $nombre=(Flight::request()->data->Nombre);
    $estado = 0;
    $sql="UPDATE Tipo SET Estado=? WHERE IDTipo=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$estado);
    $sentencia->bindParam(2,$id);
    
    $sentencia ->execute();
    Flight::json(flight::request()->data);
    
      
});
Flight::route('PUT /delete/caracteristica', function () {
    $id=(Flight::request()->data->idCaracteristica);
    $estado = 0;
    $sql="UPDATE Caracteristicas SET Estado=? WHERE idCaracteristica=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$estado);
    $sentencia->bindParam(2,$id);
    
    $sentencia ->execute();
    Flight::json(flight::request()->data);
    
      
});

Flight::route('PUT /delete/producto', function () {
    $id=(Flight::request()->data->IDProducto);
    $estado = 0;
    $sql="UPDATE Productos SET Estado=? WHERE IDProducto=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$estado);
    $sentencia->bindParam(2,$id);
    $sentencia ->execute();


    $sqlCar="UPDATE Caracteristicas SET Estado=? WHERE IDProducto=?";
    $sentencia2=Flight::db()->prepare($sqlCar);
    $sentencia2->bindParam(1,$estado);
    $sentencia2->bindParam(2,$id);
    $sentencia2 ->execute();


    Flight::json(flight::request()->data);
    
      
});

//Metodos Actualizar registros

Flight::route('PUT /update/tipo', function () {
    $id=(Flight::request()->data->IDTipo);
    $nombre=(Flight::request()->data->Nombre);
    $sql="UPDATE Tipo SET Nombre=? WHERE IDTipo=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$id);
    $sentencia ->execute();
    Flight::json(flight::request()->data);
      
});

Flight::route('PUT /update/producto', function () {
    $id=(Flight::request()->data->IDProducto);
    $nombre=(Flight::request()->data->Nombre);
    $tipo=(Flight::request()->data->Tipo);
    $marca=(Flight::request()->data->Marca);
    $sql="UPDATE Productos SET Nombre=?,Tipo=?,Marca=? WHERE IDProducto=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$nombre);
    $sentencia->bindParam(2,$tipo);
    $sentencia->bindParam(3,$marca);
    $sentencia->bindParam(4,$id);

    $sentencia ->execute();
    Flight::json(flight::request()->data);
    
      
});


Flight::route('PUT /update/caracteristica', function () {
    $id=(Flight::request()->data->idCaracteristica);
    $caracteristica=(Flight::request()->data->Caracteristica);

    $sql="UPDATE Caracteristicas SET Caracteristica=? WHERE idCaracteristica=?";
    $sentencia=Flight::db()->prepare($sql);
    $sentencia->bindParam(1,$caracteristica);
    $sentencia->bindParam(2,$id);
   
    
    $sentencia ->execute();
   
    Flight::json(flight::request()->data);
    
      
});


Flight::before('json', function () {
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, content-Type, Accept');
});







Flight::start();

