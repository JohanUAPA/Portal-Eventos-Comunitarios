<?php
// Incluir el archivo de conexión a la base de datos
include 'db_connection.php';

// Datos del nuevo usuario administrador
$nombre = 'Admin';
$email = 'admin@gmail.com';
$password = 'Admin123'; 
$rol = 'administrador';

// Encriptar la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Preparar la consulta SQL
$sql = "INSERT INTO usuarios (nombre, email, contrasena, rol) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $email, $hashed_password, $rol);

// Ejecutar la consulta e informar el resultado
if ($stmt->execute()) {
    echo "Usuario administrador creado exitosamente.";
} else {
    echo "Error al crear el usuario: " . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
