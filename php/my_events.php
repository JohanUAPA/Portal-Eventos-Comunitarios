<?php 
include 'db_connection.php';
include 'user_header.php';
// Iniciar sesión si no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../user_panel.php"); 
    exit();
}

// Obtener ID del usuario
$usuario_id = $_SESSION['usuario_id'];
// Consultar los detalles del usuario

$sql_user = "SELECT * FROM usuarios WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $usuario_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// Verificar si se encontró el usuario
if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc(); 
} else {
    // Si no se encuentra el usuario, redirigir o manejar el error
    header("Location: ../user_panel.php");
    exit();
}

// Consultar los detalles del usuario
$sql_user = "SELECT * FROM usuarios WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $usuario_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

// Verificar si se encontró el usuario
if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc(); // Obtener información del usuario
} else {
    // Si no se encuentra el usuario, redirigir o manejar el error
    header("Location: ../user_panel.php");
    exit();
}



// Consultar los eventos a los que el usuario está inscrito, ordenando por fecha de evento
$sql = "SELECT e.* FROM eventos e 
        INNER JOIN inscripciones i ON e.id = i.evento_id 
        WHERE i.usuario_id = ? 
        ORDER BY e.fecha DESC"; // Ordenar por fecha de evento en orden descendente
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Eventos Inscritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <style>
   body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            margin: auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #343a40;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
        .card {
            margin: 10px;
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .card-body {
            padding: 20px;
        }
        .btn-danger {
            margin-top: 10px;
        }
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            }
    </style>
   
</head>
<body>
    <div class="container mt-5">
        <h2>Mis Eventos Inscritos</h2>
        <div class="card-container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='card'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8') . "</h5>
                            <p class='card-text'>" . htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><strong>Fecha:</strong> " . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><strong>Ubicación:</strong> " . htmlspecialchars($row['ubicacion'], ENT_QUOTES, 'UTF-8') . "</p>
                            <p class='card-text'><strong>Categoría:</strong> " . htmlspecialchars($row['categoria'], ENT_QUOTES, 'UTF-8') . "</p>
                            <form action='cancel_subscription.php' method='POST'>
                                <input type='hidden' name='evento_id' value='" . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . "'>
                                <button type='submit' class='btn btn-danger w-100'>Cancelar Inscripción</button>
                            </form>
                        </div>
                    </div>";
                }
            } else {
                echo "<p class='text-center'>No estás inscrito en ningún evento.</p>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer class="footer">
        <div class="container">
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>
</html>

<?php

$conn->close();
?>
