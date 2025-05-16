<?php
// Configuración de la conexión a la base de datos
$servidor = "localhost"; // Servidor de MySQL (por defecto es localhost)
$usuario = "root"; // Usuario de MySQL (por defecto es root en XAMPP)
$contraseña = "Sa230206"; // Contraseña de MySQL (por defecto está vacía en XAMPP)
$baseDatos = "sara"; // Cambia por el nombre de tu base de datos

// Crear la conexión
$conexion = new mysqli($servidor, $usuario, $contraseña, $baseDatos);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if (basename($_SERVER['PHP_SELF']) === 'conexion.php') {
    echo "Conexión exitosa.";
}
?>

