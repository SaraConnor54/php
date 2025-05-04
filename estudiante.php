<?php

// Función para obtener todos los estudiantes
function getAllEstudiantes($conn) {
    $sql = "SELECT * FROM estudiantes";  // Consulta para obtener todos los estudiantes
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  // Devuelve los resultados como un array asociativo
}

// Función para obtener un estudiante por ID
function getEstudianteById($conn, $id) {
    $sql = "SELECT * FROM estudiantes WHERE idestudiantes = :id";  // Consulta para obtener un estudiante por su ID
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);  // Devuelve un solo estudiante
}

// Función para insertar un nuevo estudiante
function insertEstudiante($conn, $usuario, $contraseña) {
    $sql = "INSERT INTO estudiantes (usuario, contraseña) VALUES (:usuario, :contraseña)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contraseña', $contraseña);
    return $stmt->execute();  // Ejecuta la consulta de inserción
}

// Función para actualizar los datos de un estudiante
function updateEstudiante($conn, $id, $usuario, $contraseña) {
    $sql = "UPDATE estudiantes SET usuario = :usuario, contraseña = :contraseña WHERE idestudiantes = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':contraseña', $contraseña);
    return $stmt->execute();  // Ejecuta la consulta de actualización
}

// Función para eliminar un estudiante
function deleteEstudiante($conn, $id) {
    $sql = "DELETE FROM estudiantes WHERE idestudiantes = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();  // Ejecuta la consulta de eliminación
}

?>


