
<?php 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
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
    <title>Eventos Comunitarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <style>
        .navbar-brand {
            font-weight: bold;
            color: #343a40; /* Color más oscuro */
        }
        .navbar-nav .nav-link {
            text-align: center;
            font-size: 1.1rem; /* Tamaño de fuente más grande */
            margin-left: 20px;
            margin-right: 20px;
        }
        .navbar-nav .nav-link:hover {
            color: #0056b3; /* Color de hover más oscuro */
        }
        .dropdown-toggle {
            font-weight: bold;
            color: #343a40; /* Hacer el nombre del usuario más oscuro */
        }
        .dropdown-toggle:hover {
            color: #0056b3; /* Cambiar el color cuando se pase el mouse */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_panel.php">Panel de usuario</a>
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
                        <a class="nav-link" href="my_events.php">Mis Eventos</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" 
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
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
