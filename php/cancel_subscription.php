<?php 
include 'db_connection.php';

// Iniciar sesión si no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: user_panel.php"); // Redirigir al panel de usuario si no está autenticado
    exit();
}

// Obtener ID del usuario
$usuario_id = $_SESSION['usuario_id'];

// Verificar si se ha recibido el ID del evento
if (isset($_POST['evento_id']) && is_numeric($_POST['evento_id'])) {
    $evento_id = (int)$_POST['evento_id'];

    // Eliminar inscripción
    $sql = "DELETE FROM inscripciones WHERE usuario_id = ? AND evento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $usuario_id, $evento_id);

    if ($stmt->execute()) {
        // Redirigir de vuelta a la página de eventos inscritos con un mensaje de éxito
        header("Location: my_events.php?msg=Inscripción cancelada con éxito.");
    } else {
        // Redirigir de vuelta a la página de eventos inscritos con un mensaje de error
        header("Location: my_events.php?msg=Error al cancelar la inscripción.");
    }
} else {
    header("Location: my_events.php"); // Redirigir si no se recibe un ID válido
}

$stmt->close();
$conn->close();
?>