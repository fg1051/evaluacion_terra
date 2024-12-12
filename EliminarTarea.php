<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion: " . $conexion->connect_error);
}

$Id = $_GET["Id"];

$delete = $conexion -> prepare("DELETE FROM tasks where id = ?");

if($delete === false){
    die("Error al preparar consulta: " . $conexion->error);
}
$delete -> bind_param("s", $Id);

if($delete -> execute()){
   
    echo json_encode(['success' => true]);
}else{
    echo json_encode(['success' => false]);
}
