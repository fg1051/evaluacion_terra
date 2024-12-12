<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion" . $conexion->connect_error);
}
$Id = $_GET['Id'];
$consulta = "SELECT task_name, created_at FROM tasks WHERE id = '".$Id."'";
$get = $conexion -> prepare($consulta);

if($get === false){
    die("Ocurrio un error al preparar la consulta" . $conexion->error);
}

$get -> execute();
$result = $get->get_result();

if($result -> num_rows > 0){
    $task = $result->fetch_assoc();
}

echo json_encode($task);

$get -> close();
$conexion ->close();