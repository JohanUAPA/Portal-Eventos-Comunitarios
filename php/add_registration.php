<?php

include 'db_connection.php';

// Verifica si se ha recibido el ID del evento
if (isset($_GET['evento_id'])) {
    $evento_id = $_GET['evento_id'];
    $user_id = $_SESSION['user_id']; // Asegúrate de que el ID del usuario esté almacenado en la sesión

    // Inserta la inscripción en la base de datos
    $sql = "INSERT INTO inscripciones (usuario_id, evento_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $evento_id);

    if ($stmt->execute()) {
        // Redirige a user_event_list.php con un parámetro de éxito
        header("Location: user_event_list.php?registered=1");
        exit();
    } else {
        // Maneja el error en caso de fallo en la inserción
        echo "Error al inscribirse en el evento: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID de evento no válido.";
}

$conn->close();
?>
