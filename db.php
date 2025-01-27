<?php
// Datos de conexión a la base de datos
$host = 'localhost'; // Cambia esto si es necesario
$user = 'root'; // Tu usuario de MySQL
$pass = 'Root_pass1'; // Tu contraseña de MySQL
$db = 'acortador_db'; // Tu base de datos

// Conexión a la base de datos
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>
