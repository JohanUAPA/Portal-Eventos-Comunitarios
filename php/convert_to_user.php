<?php
include 'db_connection.php'; // Incluir la conexión

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Actualizar el rol del administrador a "usuario"
    $sql = "UPDATE usuarios SET rol = 'usuario' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir a admin_admins.php con mensaje de éxito
        header("Location: admin_admins.php?message=converted");
        exit;
    } else {
        // Redirigir a admin_admins.php con mensaje de error
        header("Location: admin_admins.php?message=error");
        exit;
    }
}
?>
