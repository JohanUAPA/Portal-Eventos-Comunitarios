<?php
session_start();
session_unset(); // Destruir todas las variables de sesión
session_destroy(); // Destruir la sesión

// Redirigir a la página de inicio de sesión
header("Location: ../login.php"); // Asegúrate de que la ruta sea correcta
exit();
?>
