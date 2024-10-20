<?php
// Conexión a MySQL
$servername = "localhost";
$username = "root";
$password = "";
$database = "portal_evento";

// Crear la conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) === TRUE) {
    echo "Base de datos 'portal_evento' creada correctamente.<br>";
} else {
    echo "Error al crear la base de datos: " . $conn->error;
}

// Seleccionar la base de datos
$conn->select_db($database);

// Crear la tabla 'usuarios'
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'usuarios' creada correctamente.<br>";
} else {
    echo "Error al crear la tabla 'usuarios': " . $conn->error;
}

// Crear la tabla 'eventos'
$sql = "CREATE TABLE IF NOT EXISTS eventos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    fecha DATE NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    valoracion_promedio FLOAT DEFAULT 0,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'eventos' creada correctamente.<br>";
} else {
    echo "Error al crear la tabla 'eventos': " . $conn->error;
}

// Crear la tabla 'comentarios'
$sql = "CREATE TABLE IF NOT EXISTS comentarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id INT(6) UNSIGNED NOT NULL,
    usuario_id INT(6) UNSIGNED NOT NULL,
    comentario TEXT NOT NULL,
    valoracion INT(1) NOT NULL,
    fecha_comentario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'comentarios' creada correctamente.<br>";
} else {
    echo "Error al crear la tabla 'comentarios': " . $conn->error;
}

// Crear la tabla 'inscripciones'
$sql = "CREATE TABLE IF NOT EXISTS inscripciones (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    evento_id INT(6) UNSIGNED NOT NULL,
    usuario_id INT(6) UNSIGNED NOT NULL,
    fecha_inscripcion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";
if ($conn->query($sql) === TRUE) {
    echo "Tabla 'inscripciones' creada correctamente.<br>";
} else {
    echo "Error al crear la tabla 'inscripciones': " . $conn->error;
}

// Cerrar conexión
$conn->close();
?>
