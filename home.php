<?php 
include 'php/db_connection.php';
$usuario_autenticado = isset($_SESSION['usuario_id']);
include 'php/header.php';

// Iniciar sesión si no se ha iniciado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función para obtener la valoración promedio desde la tabla comentarios
function obtenerValoracionPromedio($conn, $evento_id) {
    $sql = "SELECT AVG(valoracion) AS valoracion_promedio FROM comentarios WHERE evento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['valoracion_promedio'] ? round($row['valoracion_promedio'], 2) : 0;
}

// Manejar la inscripción en un evento
$mensaje = ""; 
if (isset($_GET['evento_id'])) {
    if (!isset($_SESSION['usuario_id'])) {
        $mensaje = "Por favor, inicie sesión para inscribirse en un evento.";
    } else {
        $usuario_id = $_SESSION['usuario_id'];
        $evento_id = $_GET['evento_id'];

        $sql = "INSERT INTO inscripciones (usuario_id, evento_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $evento_id);
        
        if ($stmt->execute()) {
            $mensaje = "Te has inscrito en el evento.";
        } else {
            $mensaje = "No se pudo inscribir en el evento. Intenta de nuevo.";
        }
    }
}

// Filtrar eventos por búsqueda de título y fecha exacta
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

// Modificar la consulta para obtener los eventos más recientes
$sql = "SELECT * FROM eventos WHERE titulo LIKE ? ";
if (!empty($fecha)) {
    $sql .= "AND fecha = ? ";
}
$sql .= "ORDER BY fecha DESC LIMIT 6";  

$stmt = $conn->prepare($sql);
$busqueda_param = '%' . $busqueda . '%';

if (!empty($fecha)) {
    $stmt->bind_param("ss", $busqueda_param, $fecha); 
} else {
    $stmt->bind_param("s", $busqueda_param); 
}

$stmt->execute();
$result = $stmt->get_result();

$inscripciones = [];
if (isset($_SESSION['usuario_id'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $sqlInscripciones = "SELECT evento_id FROM inscripciones WHERE usuario_id = ?";
    $stmtInscripciones = $conn->prepare($sqlInscripciones);
    $stmtInscripciones->bind_param("i", $usuario_id);
    $stmtInscripciones->execute();
    $resultInscripciones = $stmtInscripciones->get_result();

    while ($rowInscripcion = $resultInscripciones->fetch_assoc()) {
        $inscripciones[] = $rowInscripcion['evento_id'];
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Comunitarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home_styles.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
</head>

<body>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Descubre Eventos Comunitarios Asombrosos</h1>
            <p>Conéctate, aprende y diviértete con eventos locales en tu área.</p>
        </div>
    </section>

    <div class="container mt-5">
        <h2 class="text-center">Eventos Destacados</h2>
        
        <!-- Mostrar el mensaje de inscripción si existe -->
        <?php if (!empty($mensaje) && isset($_GET['evento_id'])): ?>
            <script>
                window.onload = function() {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Inscripción exitosa!',
                        text: '<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>',
                        confirmButtonText: 'Cerrar'
                    });
                };
            </script>
        <?php endif; ?>

        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar eventos por título..." value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="date" name="fecha" class="form-control" value="<?php echo htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8'); ?>">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $evento_id = $row['id'];
                    $esta_inscrito = in_array($evento_id, $inscripciones);
                    $valoracion_promedio = obtenerValoracionPromedio($conn, $evento_id);

                    echo "<div class='col-md-4'>
                            <div class='card'>
                                <div class='card-header'>
                                    <h5 class='event-title'>" . htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8') . "</h5>
                                </div>
                                <div class='card-body'>
                                    <p class='event-info'><strong>Fecha:</strong> " . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='event-info'><strong>Hora:</strong> " . htmlspecialchars($row['hora'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='event-info'><strong>Ubicación:</strong> " . htmlspecialchars($row['ubicacion'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='event-info'><strong>Valoración Promedio:</strong> " . number_format($valoracion_promedio, 2) . " ⭐</p>
                                    <a href='php/event_detail.php?id=" . $row['id'] . "' class='btn btn-info'>Ver detalles</a>";

                    if ($esta_inscrito) {
                        echo "<span class='btn btn-secondary disabled'>Inscrito</span>";
                    } else {
                        if (!$usuario_autenticado) {
                            echo "<button class='btn btn-success' onclick='mostrarAlertaAutenticacion()'>Inscribirse</button>";
                        } else {
                            echo "<a href='?evento_id=" . $row['id'] . "' class='btn btn-success'>Inscribirse</a>";
                        }
                    }

                    echo "</div></div></div>";
                }
            } else {
                echo "<div class='col-12'><p class='text-center'>No hay eventos destacados para mostrar.</p></div>";
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function mostrarAlertaAutenticacion() {
            Swal.fire({
                icon: 'warning',
                title: 'Autenticación requerida',
                text: 'Por favor, inicie sesión para inscribirse en un evento.',
                showCancelButton: true,
                confirmButtonText: 'Iniciar Sesión',
                cancelButtonText: 'Cerrar',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                }
            });
        }
    </script>
</body>
</html>
