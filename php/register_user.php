<?php
// Incluir el archivo de conexión
include 'db_connection.php';

// Obtener datos del formulario y sanitizarlos
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// Variables de error
$error = false;
$nombre_error = '';
$email_error = '';
$password_error = '';

// Verificar que el nombre no esté vacío
if (empty($nombre)) {
    $nombre_error = "El nombre es obligatorio.";
    $error = true;
}

// Verificar si el correo electrónico tiene un formato válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $email_error = "Formato de correo electrónico inválido.";
    $error = true;
}

// Verificar si el correo electrónico ya está registrado (sentencia preparada)
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $email_error = "El correo electrónico ya está registrado.";
    $error = true;
}

// Verificar que la contraseña tenga al menos 6 caracteres
if (strlen($password) < 6) {
    $password_error = "La contraseña debe tener al menos 6 caracteres.";
    $error = true;
}

// Si hay errores, redirigir de nuevo al registro con mensajes de error
if ($error) {
    $query = http_build_query(array(
        'nombre_error' => $nombre_error,
        'email_error' => $email_error,
        'password_error' => $password_error,
        'error' => 'Error en el registro. Verifica los campos.',
    ));
    header("Location: ../register.php?$query");
    exit();
}

// Si no hay errores, insertar el nuevo usuario con una sentencia preparada
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nombre, $email, $password_hash);

if ($stmt->execute()) {
    // Registro exitoso, redirigir al inicio de sesión
    header("Location: ../login.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexión
$conn->close();
?>
