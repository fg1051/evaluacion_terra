<?php
require_once("db.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Document</title>
</head>
<body>
    <button id="btnAgregar" class="btnAgregar">Nueva Tarea</button>

    <div id="divNuevaTarea"></div>

    <ul id="listaTareas">
    </ul>
    <div id="divEditarTarea"></div>
</body>
<script>
    document.getElementById('btnAgregar').addEventListener('click', function(){
        fetch('add.php')
            .then(response => response.text())
            .then(data =>{
                document.getElementById('divNuevaTarea').innerHTML = data;
            });
    });
    function agregarTask(){
        const formData = new FormData(document.getElementById('formNuevaTarea'));
        
        fetch('NuevaTarea.php',{
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data =>{
            if(data.success){

                fetch('GetTarea.php?Id='+data["id"])
                    .then(response => response.json())
                    .then(data => {
                        nuevoElementoLista(data["task_name"], data["id"]);
                    })
                    .catch(error =>{
                        console.log("Error al mostrar registro creado", error);
                    });
            }else{
                console.log("error al crear");
            }
        });
        document.getElementById('divNuevaTarea').innerHTML = '';

    };

    function nuevoElementoLista(texto, id){
        const lista = document.getElementById('listaTareas');
        const li = document.createElement('li');
        li.innerHTML = texto + " | <a href='#' onclick='EditarTarea("+id+")'>Editar</a>" + " | <a href='#' onclick='EliminarTarea("+id+")' class='linkEliminar'>Eliminar</a>";
        li.id = "task-"+id+"";
        lista.appendChild(li);
    }
    function obtenerTareas(){
        fetch('GetTareas.php')
            .then(response => response.json())
            .then(data => {
                console.log(data);
                const lista = document.getElementById('listaTareas');

                data.forEach(tarea =>{
                    nuevoElementoLista(tarea["task_name"], tarea["id"]);
                });
            })
            .catch(error => {
                console.log("Error al obtener tareas", error);
            });
    }
    function EditarTarea(id){
        fetch('edit.php?Id='+id)
            .then(response => response.text())
            .then(data =>{
                document.getElementById('divEditarTarea').innerHTML = data;
            });
    }
    function editarTask(Id){
        const formData = new FormData(document.getElementById('formEditTarea'));
        
        fetch('EditarTarea.php?Id='+Id,{
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data =>{
            console.log("actualizado");
            if(data.success){

                fetch('GetTarea.php?Id='+data["id"])
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById("task-"+data["id"]).innerHTML = data["task_name"] + " | <a href='#' onclick='EditarTarea("+Id+")'>Editar</a> | <a href='#' onclick='EliminarTarea("+Id+")' class='linkEliminar'>Eliminar</a>";
                     
                    })
                    .catch(error =>{
                        console.log("Error al mostrar registro actualizado", error);
                    });
            }else{
                console.log("error al actualizar");
            }
        });
        document.getElementById('divEditarTarea').innerHTML = '';

    }
    function cancelarEdicion(){
        document.getElementById('divEditarTarea').innerHTML = '';
    }
    function EliminarTarea(id){
        const confirmation = confirm('¿Estás seguro de que deseas eliminar este elemento?');

        if (confirmation) {
            fetch('EliminarTarea.php?Id='+id)
                .then(response => response.json())
                .then(data =>{
                    if(data.success){
                        var task = document.getElementById("task-"+id);
                        task.remove();
                        document.getElementById('divEditarTarea').innerHTML = '';
                    }
                })
        } else {
        console.log('Eliminación cancelada');
        }
    }
    window.onload = obtenerTareas;
</script>
</html>