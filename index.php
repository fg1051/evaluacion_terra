<?php
require_once("db.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    <button id="btnAgregar" class="btnAgregar">Nueva Tarea</button>

    <div id="divNuevaTarea"></div>

    <ul id="listaTareas">
    </ul>
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
                console.log("exito al crear");
            }else{
                console.log("error al crear");
            }
        });
        document.getElementById('divNuevaTarea').innerHTML = '';

    };
    
</script>
</html>