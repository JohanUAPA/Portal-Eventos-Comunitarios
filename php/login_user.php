<?php
session_start(); // Iniciar la sesión
include 'db_connection.php';

// Obtener datos del formulario
$email = $_POST['email'];
$password = $_POST['password'];

// Variables de error
$error = false;
$email_error = '';
$password_error = '';

// Verificar si el correo electrónico está registrado
$sql = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Obtener los datos del usuario
    $row = $result->fetch_assoc();
    
    // Verificar la contraseña
    if (password_verify($password, $row['contrasena'])) {
        // Credenciales correctas, iniciar sesión
        $_SESSION['user_id'] = $row['id']; // Almacenar el ID del usuario en la sesión
        $_SESSION['usuario_nombre'] = $row['nombre'];
        $_SESSION['usuario_rol'] = $row['rol']; 
        $_SESSION['usuario_id'] = $row['id']; 

        // Redirigir según el rol del usuario
        if ($_SESSION['usuario_rol'] === 'admin') {
            header("Location: admin_panel.php"); 
        } else {
            header("Location: user_panel.php"); 
        }
        exit(); // Asegúrate de salir después de redirigir
    } else {
        // Contraseña incorrecta
        $password_error = "Contraseña incorrecta.";
        $error = true;
    }
} else {
    // El correo no está registrado
    $email_error = "El correo electrónico no está registrado.";
    $error = true;
}

// Si hay errores, redirigir de nuevo al login con mensajes de error
if ($error) {
    $query = http_build_query(array(
        'email_error' => $email_error,
        'password_error' => $password_error,
        'error' => 'Error en el inicio de sesión. Verifica tus credenciales.',
    ));
    header("Location: ../login.php?$query");
    exit();
}

// Cerrar conexión
$conn->close();
?>
