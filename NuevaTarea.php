<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion: " . $conexion->connect_error);
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $tarea = $_POST['txtTarea'];

    $insert = $conexion -> prepare("INSERT INTO tasks (task_name) VALUES(?)");
    if($insert === false){
        die("Error al preparar consulta: " . $conexion->error);
    }

    $insert -> bind_param("s", $tarea);
    if($insert -> execute()){
        echo json_encode(['success' => true]);
    }else{
        echo json_encode(['success' => false]);
    }

    $insert -> close();
    $conexion -> close();
}