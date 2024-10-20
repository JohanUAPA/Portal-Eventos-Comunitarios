<?php
// Incluir el archivo de conexión
include 'db_connection.php'; // Ajustar la ruta

// Obtener el ID del evento
$id = $_GET['id'];

// Eliminar el evento de la base de datos
$sql = "DELETE FROM eventos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirigir a la lista de eventos con un mensaje de éxito
    header("Location: event_list.php?success=Evento eliminado correctamente");
} else {
    header("Location: event_list.php?error=Error al eliminar el evento: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
