<?php 
include 'db_connection.php';
include 'user_header.php';
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

// Función para obtener la valoración promedio desde la tabla comentarios
function obtenerValoracionPromedio($conn, $evento_id) {
    $sql = "SELECT AVG(valoracion) AS valoracion_promedio FROM comentarios WHERE evento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $evento_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Devolver la valoración promedio, o 0 si no hay valoraciones
    return $row['valoracion_promedio'] ? round($row['valoracion_promedio'], 2) : 0;
}

// Manejar la inscripción en un evento
$mensaje = ""; // Inicializar mensaje
$mostrarModal = false; // Variable para controlar si se debe mostrar la ventana emergente

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento_id'])) {
    // Comprobar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario_id'])) {
        // Si no está autenticado, mostrar un mensaje y activar la ventana emergente
        $mensaje = "Por favor, inicie sesión para inscribirse en un evento.";
        $mostrarModal = true;
    } else {
        $usuario_id = $_SESSION['usuario_id'];
        $evento_id = $_POST['evento_id'];

        // Verificar si el usuario ya está inscrito en el evento
        $sqlCheck = "SELECT * FROM inscripciones WHERE usuario_id = ? AND evento_id = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("ii", $usuario_id, $evento_id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $mensaje = "Ya estás inscrito en este evento.";
        } else {
            // Insertar inscripción en la base de datos
            $sql = "INSERT INTO inscripciones (usuario_id, evento_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $usuario_id, $evento_id);

            if ($stmt->execute()) {
                // La inscripción fue exitosa
                $mensaje = "Te has inscrito en el evento.";
            } else {
                // Error al inscribirse
                $mensaje = "No se pudo inscribir en el evento. Intenta de nuevo.";
            }
        }
        $mostrarModal = true; 
    }
}

// Filtrar eventos por búsqueda de título y fecha exacta
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
$fecha = isset($_GET['fecha']) ? $_GET['fecha'] : '';

$sql = "SELECT * FROM eventos WHERE titulo LIKE ?";

// Agregar condición para la fecha si se selecciona
if (!empty($fecha)) {
    $sql .= " AND fecha = ?";
}

$sql .= " ORDER BY fecha DESC"; // Ordenar por fecha en orden descendente

$stmt = $conn->prepare($sql);
$busqueda_param = '%' . $busqueda . '%';

if (!empty($fecha)) {
    $stmt->bind_param("ss", $busqueda_param, $fecha); 
} else {
    $stmt->bind_param("s", $busqueda_param); 
}

$stmt->execute();
$result = $stmt->get_result();

// Consultar inscripciones del usuario
$usuario_id = $_SESSION['usuario_id'] ?? null; // Si no hay usuario, definir como null
$sqlInscripciones = "SELECT evento_id FROM inscripciones WHERE usuario_id = ?";
$stmtInscripciones = $conn->prepare($sqlInscripciones);
$stmtInscripciones->bind_param("i", $usuario_id);
$stmtInscripciones->execute();
$resultInscripciones = $stmtInscripciones->get_result();

// Almacenar los IDs de los eventos en los que el usuario ya está inscrito
$inscripciones = [];
while ($rowInscripcion = $resultInscripciones->fetch_assoc()) {
    $inscripciones[] = $rowInscripcion['evento_id'];
}

// Función para mostrar estrellas basadas en la valoración
function mostrarEstrellas($valoracion) {
    $estrellasCompletas = floor($valoracion);
    $estrellaMedia = ($valoracion - $estrellasCompletas) >= 0.5;
    $html = '';

    for ($i = 0; $i < $estrellasCompletas; $i++) {
        $html .= '<i class="fas fa-star text-warning"></i>'; // Estrella llena
    }

    if ($estrellaMedia) {
        $html .= '<i class="fas fa-star-half-alt text-warning"></i>'; // Estrella media
    }

    $estrellasVacias = 5 - $estrellasCompletas - ($estrellaMedia ? 1 : 0);
    for ($i = 0; $i < $estrellasVacias; $i++) {
        $html .= '<i class="far fa-star text-warning"></i>'; // Estrella vacía
    }

    return $html;
    
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        .card {
            margin: 15px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container mt-5">
        <h2>Eventos Disponibles</h2>
        
        <!-- Formulario de búsqueda por título y fecha -->
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar eventos por título..." value="<?php echo htmlspecialchars($busqueda, ENT_QUOTES, 'UTF-8'); ?>">
                <input type="date" name="fecha" class="form-control" value="<?php echo htmlspecialchars($fecha, ENT_QUOTES, 'UTF-8'); ?>">
                <button class="btn btn-success" type="submit">Buscar</button>
            </div>
        </form>

        <div class="row">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $evento_id = $row['id'];
                    $esta_inscrito = in_array($evento_id, $inscripciones); // Verificar inscripción

                    // Calcular la valoración promedio de la tabla 'comentarios'
                    $valoracion_promedio = obtenerValoracionPromedio($conn, $evento_id);

                    echo "<div class='col-md-4'>
                            <div class='card'>
                                <div class='card-header'>
                                    <h5 class='card-title'>" . htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8') . "</h5>
                                </div>
                                <div class='card-body'>
                                    <p class='card-text'><i class='fas fa-calendar-alt'></i> Fecha: " . htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-clock'></i> Hora: " . htmlspecialchars($row['hora'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'><i class='fas fa-map-marker-alt'></i> Ubicación: " . htmlspecialchars($row['ubicacion'], ENT_QUOTES, 'UTF-8') . "</p>
                                    <p class='card-text'>Valoración Promedio: " . number_format($valoracion_promedio, 2) . " ⭐</p>
                                    <a href='user_event_detail.php?id=" . $row['id'] . "' class='btn btn-info w-100 mb-2'>Ver detalles</a>"; // Botón de "Ver detalles"
                                    
                    // Mostrar botón según estado de inscripción
                    if ($esta_inscrito) {
                        echo "<span class='btn btn-secondary disabled w-100 mb-2'>Inscrito</span>"; 
                    } else {
                        echo "<form method='POST' action=''>
                                <input type='hidden' name='evento_id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-success w-100 mb-2'>Inscripción</button>
                                </form>";
                    }

                    echo "</div></div></div>";
                }
            } else {
                echo "<div class='col-12'><p class='text-center'>No hay eventos disponibles para la fecha seleccionada.</p></div>";
            }
            ?>
        </div>
    </div>

    <!-- Modal para mostrar mensajes -->
    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mensajeModalLabel">Información</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php echo $mensaje; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mostrar modal si hay un mensaje -->
    <?php if ($mostrarModal) : ?>
    <script>
        var mensajeModal = new bootstrap.Modal(document.getElementById('mensajeModal'), {});
        mensajeModal.show();
    </script>
    <?php endif; ?>
</body>
</html>

</body>
<footer class="footer">
        <div class="container">
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>
</html>