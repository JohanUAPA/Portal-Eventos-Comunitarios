<?php 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir al inicio de sesión si no está autenticado
    exit();
} 

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Consultar datos del usuario
$sql = "SELECT nombre FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Eventos Comunitarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #343a40;
        }
        .navbar-nav .nav-link {
            text-align: center;
            font-size: 1.1rem;
            margin-left: 20px;
            margin-right: 20px;
        }
        .navbar-nav .nav-link:hover {
            color: #0056b3;
        }
        .dropdown-toggle {
            font-weight: bold;
            color: #343a40;
        }
        .dropdown-toggle:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_panel.php"> Panel de Administración</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav me-auto mx-auto">
                <li class="nav-item">
                        <a class="nav-link" href="../home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_panel.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_users.php">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_admins.php">Administradores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_events.php">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="event_list.php">Agregar Evento</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_inscriptions.php">Inscripciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin_consultations.php">Consultas/Sugerencias</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" 
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="admin_perfil.php">Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>
