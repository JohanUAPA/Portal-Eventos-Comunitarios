<?php
session_start();
include 'db_connection.php';

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Comprobar si se ha recibido el ID del evento
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de evento no válido.";
    exit();
}

$evento_id = (int)$_GET['id'];
$usuario_id = $_SESSION['user_id'];

// Insertar la inscripción en la base de datos
$sql = "INSERT INTO inscripciones (evento_id, usuario_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $evento_id, $usuario_id);

if ($stmt->execute()) {
    header("Location: event_list.php?success=Inscripción realizada correctamente.");
} else {
    echo "Error al inscribirse: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
