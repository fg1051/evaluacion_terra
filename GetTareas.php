<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion" . $conexion->connect_error);
}

$consulta = "SELECT id, task_name, created_at FROM tasks";
$get = $conexion -> prepare($consulta);

if($get === false){
    die("Ocurrio un error al preparar la consulta" . $conexion->error);
}

$get -> execute();
$result = $get->get_result();
$tasks = [];
if($result -> num_rows > 0){
    while($row = $result -> fetch_assoc()){
        $tasks[] = $row;
    }
}

echo json_encode($tasks);

$get -> close();
$conexion ->close();