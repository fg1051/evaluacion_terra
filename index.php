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
    $('#btnAgregar').click(function() {
        $.get('add.php', function(data) {
            $('#divNuevaTarea').html(data);
        });
    });
    function agregarTask(){
        var formData = new FormData($('#formNuevaTarea').get(0));
        
        $.ajax({
            url: 'NuevaTarea.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.success) {
                    $.getJSON('GetTarea.php?Id=' + data.id, function(data) {
                        nuevoElementoLista(data.task_name, data.id);
                        $('#divNuevaTarea').html('');
                    })
                    .fail(function(error) {
                        console.log('Error al mostrar registro creado', error);
                    });
                } else {
                    console.log('Error al crear');
                }
            }
        });
    };

    function nuevoElementoLista(texto, id) {
    const lista = $('#listaTareas'); 
    const li = $('<li></li>'); 
    li.html(texto + " | <a href='#' onclick='EditarTarea("+id+")'>Editar</a>" + " | <a href='#' onclick='EliminarTarea("+id+")' class='linkEliminar'>Eliminar</a>");
    li.attr('id', 'task-' + id); 
    lista.append(li); 
    }
    function obtenerTareas() {
        $.getJSON('GetTareas.php', function(data) {
            console.log(data);
            data.forEach(function(tarea) {
                nuevoElementoLista(tarea.task_name, tarea.id);
            });
        })
        .fail(function(error) {
            console.log('Error al obtener tareas', error);
        });
    }
    function EditarTarea(id) {
        $.get('edit.php?Id=' + id, function(data) {
            $('#divEditarTarea').html(data);
        });
    }
    function editarTask(Id){
        const formData = new FormData($('#formEditTarea')[0]);
        
        $.ajax({
            url: 'EditarTarea.php?Id=' + Id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                data = JSON.parse(data);
                if (data.success) {
                    $.getJSON('GetTarea.php?Id=' + data.id, function(data) {
                        $('#task-' + data.id).html(data.task_name + " | <a href='#' onclick='EditarTarea(" + Id + ")'>Editar</a> | <a href='#' onclick='EliminarTarea(" + Id + ")' class='linkEliminar'>Eliminar</a>");
                        $('#divEditarTarea').html('');
                    })
                    .fail(function(error) {
                        console.log('Error al mostrar registro actualizado', error);
                    });
                } else {
                    console.log('Error al actualizar');
                }
            }
        });

    }
    function cancelarEdicion() {
        $('#divEditarTarea').html('');
    }
    function EliminarTarea(id) {
        const confirmation = confirm('¿Estás seguro de que deseas eliminar este elemento?');

        if (confirmation) {
            $.getJSON('EliminarTarea.php?Id=' + id, function(data) {
                if (data.success) {
                    $('#task-' + id).remove();
                    $('#divEditarTarea').html('');
                }
            });
        } else {
            console.log('Eliminación cancelada');
        }
    }
    window.onload = obtenerTareas;
</script>
</html>