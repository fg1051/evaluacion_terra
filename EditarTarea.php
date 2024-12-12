<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion: " . $conexion->connect_error);
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tarea = $_POST['txtTarea'];
    $id = $_GET['Id'];

    $update = $conexion -> prepare("UPDATE tasks set task_name = ? where id = '".$id."'");
    if($update === false){
        die("Error al preparar consulta: " . $conexion->error);
    }

    $update -> bind_param("s", $tarea);
    if($update -> execute()){

        echo json_encode(['success' => true, 'id' => $id]);
    }else{
        echo json_encode(['success' => false]);
    }

    $update -> close();
    $conexion -> close();
}