<?php
// Incluir el archivo de conexión
include 'db_connection.php'; 

// Obtener datos del formulario
$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];
$ubicacion = $_POST['ubicacion'];
$categoria = $_POST['categoria'];

// Comprobar si todos los campos están llenos
if (empty($titulo) || empty($descripcion) || empty($fecha) || empty($ubicacion) || empty($categoria)) {
    header("Location: edit_event.php?id=$id&error=Todos los campos son obligatorios");
    exit();
}

// Actualizar el evento en la base de datos
$sql = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha = ?, ubicacion = ?, categoria = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi", $titulo, $descripcion, $fecha, $ubicacion, $categoria, $id);

if ($stmt->execute()) {
    // Redirigir a la lista de eventos con un mensaje de éxito
    header("Location: event_list.php?success=Evento actualizado correctamente");
} else {
    header("Location: edit_event.php?id=$id&error=Error al actualizar el evento: " . $conn->error);
}

$stmt->close();
$conn->close();
?>
