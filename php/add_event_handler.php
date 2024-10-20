<?php
include 'db_connection.php';

// Manejar la inserción de eventos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha']; // Obtener fecha
    $hora = $_POST['hora']; // Obtener hora
    $ubicacion = $_POST['ubicacion'];
    $categoria = $_POST['categoria'];

    // Consulta para insertar el evento con fecha y hora separadas
    $sql = "INSERT INTO eventos (titulo, descripcion, fecha, hora, ubicacion, categoria) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $titulo, $descripcion, $fecha, $hora, $ubicacion, $categoria);

    if ($stmt->execute()) {
        header("Location: event_list.php"); // Redirigir después de añadir
        exit();
    } else {
        // Mostrar error en caso de fallo
        header("Location: add_event.php?error=No se pudo añadir el evento.");
        exit();
    }
}

$conn->close();
?>
