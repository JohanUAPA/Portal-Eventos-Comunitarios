<?php
include 'db_connection.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM consultas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin_consultations.php?success=deleted");
    } else {
        header("Location: admin_consultations.php?error=deleted");
    }
}
?>
