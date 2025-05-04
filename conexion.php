<?php
$host = "localhost"; // tu localhost
$user = "root"; // Tu usuario de MySQL
$password = "Sa230206"; // Tu contraseña de MySQL
$dbname = "sara"; // Nombre de tu base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "Conexión exitosa!";
?>
