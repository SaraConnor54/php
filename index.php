<?php

require 'conexion.php'; // Archivo de conexión

// Obtener el método HTTP
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';

// Obtener el ID desde la URL (si está presente)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id) {
            // Obtener un estudiante por ID
            $sql = "SELECT * FROM estudiantes WHERE idestudiantes = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        echo json_encode($result->fetch_assoc());
                    } else {
                        http_response_code(404);
                        echo json_encode(['error' => 'Estudiante no encontrado']);
                    }
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al ejecutar consulta', 'mysql_error' => $stmt->error]);
                }

                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al preparar la consulta', 'mysql_error' => $conn->error]);
            }
        } else {
            // Obtener todos los estudiantes
            $sql = "SELECT * FROM estudiantes";
            $result = $conn->query($sql);

            if ($result) {
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                echo json_encode($data);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al obtener datos']);
            }
        }
        break;

    case 'POST':
        // Insertar un nuevo estudiante
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['usuario']) && isset($data['contraseña'])) {
            $sql = "INSERT INTO estudiantes (usuario, contraseña) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ss", $data['usuario'], $data['contraseña']);

                if ($stmt->execute()) {
                    http_response_code(201);
                    echo json_encode(['message' => 'Estudiante creado exitosamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al insertar estudiante', 'mysql_error' => $stmt->error]);
                }

                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al preparar la consulta', 'mysql_error' => $conn->error]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Datos incompletos']);
        }
        break;

    case 'PUT':
        // Actualizar estudiante
        if ($id) {
            $data = json_decode(file_get_contents("php://input"), true);

            if (isset($data['usuario']) && isset($data['contraseña'])) {
                $sql = "UPDATE estudiantes SET usuario = ?, contraseña = ? WHERE idestudiantes = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    $stmt->bind_param("ssi", $data['usuario'], $data['contraseña'], $id);

                    if ($stmt->execute()) {
                        echo json_encode(['message' => 'Estudiante actualizado exitosamente']);
                    } else {
                        http_response_code(500);
                        echo json_encode(['error' => 'Error al actualizar estudiante', 'mysql_error' => $stmt->error]);
                    }

                    $stmt->close();
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al preparar la consulta', 'mysql_error' => $conn->error]);
                }
            } else {
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;

    case 'DELETE':
        // Eliminar estudiante
        if ($id) {
            $sql = "DELETE FROM estudiantes WHERE idestudiantes = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $id);

                if ($stmt->execute()) {
                    echo json_encode(['message' => 'Estudiante eliminado exitosamente']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al eliminar estudiante', 'mysql_error' => $stmt->error]);
                }

                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Error al preparar la consulta', 'mysql_error' => $conn->error]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID no proporcionado']);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

?>

