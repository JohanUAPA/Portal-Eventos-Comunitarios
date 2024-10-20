<?php
include 'db_connection.php'; // Incluir la conexión

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Eliminar inscripción de la base de datos
    $sql = "DELETE FROM inscripciones WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir a admin_inscriptions.php con mensaje de éxito
        header("Location: admin_inscriptions.php?message=deleted");
        exit;
    } else {
        // Redirigir a admin_inscriptions.php con mensaje de error
        header("Location: admin_inscriptions.php?message=error");
        exit;
    }
}
?>
