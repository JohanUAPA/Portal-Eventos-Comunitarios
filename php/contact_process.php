<?php 
include 'db_connection.php';
header('Content-Type: application/json'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    $sql = "INSERT INTO consultas (nombre, email, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $mensaje);

    $response = [];
    if ($stmt->execute()) {
        $response['exito'] = true;
        $response['mensaje'] = "Mensaje enviado correctamente. ¡Gracias por contactarnos!";
    } else {
        $response['exito'] = false;
        $response['mensaje'] = "Error al enviar el mensaje. Por favor, inténtalo de nuevo.";
    }

    $stmt->close();
    $conn->close();
    
    echo json_encode($response); // Devuelve la respuesta en formato JSON
    exit();
} else {
    echo json_encode(['exito' => false, 'mensaje' => "No se recibió ninguna solicitud POST."]);
    exit();
}
