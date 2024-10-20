<?php
include 'db_connection.php';

// Verificar si la sesión está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo "Error: Usuario no autenticado.";
    exit();
}

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evento_id = isset($_POST['evento_id']) ? (int)$_POST['evento_id'] : null;
    $usuario_id = $_SESSION['user_id']; // Asegúrate de que el ID del usuario esté en la sesión
    $comentario = isset($_POST['comentario']) && !empty(trim($_POST['comentario'])) ? trim($_POST['comentario']) : null;
    $valoracion = isset($_POST['calificacion']) ? (int)$_POST['calificacion'] : null; 

    // Verificar si el evento_id y la valoración son válidos
    if ($evento_id && $valoracion) {
 
        $sql = "INSERT INTO comentarios (evento_id, usuario_id, comentario, valoracion, fecha_comentario) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iisi", $evento_id, $usuario_id, $comentario, $valoracion);

        if ($stmt->execute()) {
            // Redirigir con mensaje de éxito
            header("Location: event_detail.php?id=" . $evento_id . "&success=Comentario agregado correctamente.");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: La calificación es obligatoria.";
    }
}
$conn->close();
?>
