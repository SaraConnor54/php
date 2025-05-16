<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'conexion.php';

// Variable para almacenar mensajes
$message = "";

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn_ingresar'])) {
        // Inicio de sesión
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        $query = "SELECT * FROM estudiantes WHERE usuario = ? AND contraseña = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $usuario, $contraseña);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $message = "Inicio de sesión exitoso. ¡Bienvenido!";
        } else {
            $message = "Credenciales incorrectas. Intenta de nuevo.";
        }
        $stmt->close();
    } elseif (isset($_POST['btn_registrar'])) {
        // Registro de usuario
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        $query = "INSERT INTO estudiantes (usuario, contraseña) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("ss", $usuario, $contraseña);

        if ($stmt->execute()) {
            $message = "Registro exitoso.";
        } else {
            $message = "Error al registrar: " . $conexion->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #E89E9EFF;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .container h1 {
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container input {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .container button {
            padding: 10px;
            background: #F5E0F0FF;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .container button:hover {
            background: #F5E0F0FF;
        }
        .message {
            margin: 10px 0;
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login y Registro</h1>
        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <!-- Formulario de login -->
        <form method="POST" action="">
            <h2>Iniciar Sesión</h2>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit" name="btn_ingresar">Ingresar</button>
        </form>
        <hr>
        <!-- Formulario de registro -->
        <form method="POST" action="">
            <h2>Registrarse</h2>
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <button type="submit" name="btn_registrar">Registrarse</button>
        </form>
    </div>
</body>
</html>

