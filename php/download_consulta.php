<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM consultas WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $filename = "consulta_{$row['id']}.txt";
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=$filename");

        echo "ID: " . $row['id'] . "\n";
        echo "Nombre: " . $row['nombre'] . "\n";
        echo "Email: " . $row['email'] . "\n";
        echo "Mensaje: " . $row['mensaje'] . "\n";
        echo "Fecha: " . $row['fecha'] . "\n";
        echo "Respondido: " . ($row['respondido'] ? 'Sí' : 'No') . "\n";
    }
}
?>
