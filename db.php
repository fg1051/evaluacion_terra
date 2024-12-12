<?php
$serv = "localhost";
$database = "terra";
$username ="root";
$pass = "";

$conexion = mysqli_connect($serv, $username, $pass, $database);

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

