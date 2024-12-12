<?php
require_once("db.php");

if($conexion -> connect_error){
    die("Ocurrio un error en la conexion" . $conexion->connect_error);
}
$Id = $_GET['Id'];
$consulta = "SELECT id, task_name, created_at FROM tasks WHERE id = '".$Id."'";
$get = $conexion -> prepare($consulta);

if($get === false){
    die("Ocurrio un error al preparar la consulta" . $conexion->error);
}

$get -> execute();
$result = $get->get_result();

if($result -> num_rows > 0){
    $task = $result->fetch_assoc();
    $nombre_tarea = $task['task_name'];
}

echo '
    <form id="formEditTarea" onsubmit="event.preventDefault(); editarTask('.$Id.');">
        <div class="form">
            <label class="lblTittle" for="txtTarea">Editar Tarea:</label>
            <label class="lblText" >Titulo Anterior:</label>
            <input type="text" class="txtForm read" value="'.$nombre_tarea.'" readonly>
            <label class="lblText" for="txtTarea">Nuevo Titulo:</label>
            <input type="text" class="txtForm" id="txtTarea" name="txtTarea" required><br>
        </div>

        <button class ="btnNuevo" id="btnNuevo" > Guardar Cambios </button>    
    </form>        
    <button class="btnCancelar" onclick="cancelarEdicion()">Cancelar</button>
';
        