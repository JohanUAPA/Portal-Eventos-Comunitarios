<?php
include 'db_connection.php'; // Incluir la conexión

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Actualizar el rol del usuario a 'admin'
    $sql = "UPDATE usuarios SET rol = 'admin' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirigir a admin_users.php con mensaje de éxito
        header("Location: admin_users.php?message=converted");
        exit;
    } else {
        // Redirigir a admin_users.php con mensaje de error
        header("Location: admin_users.php?message=error");
        exit;
    }
}
?>
