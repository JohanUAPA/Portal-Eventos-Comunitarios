<?php
include 'php/db_connection.php';
include 'php/header.php';


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

    // Devolver la valoración promedio, o 0 si no hay valoraciones
    return $row['valoracion_promedio'] ? round($row['valoracion_promedio'], 2) : 0;
}

// Manejar la inscripción en un evento
$mensaje = ""; 
$mostrarModal = false; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['evento_id'])) {
    if (!isset($_SESSION['usuario_id'])) {
        $mensaje = "Por favor, inicie sesión para inscribirse en un evento.";
        $mostrarModal = true;
    } else {
        $usuario_id = $_SESSION['usuario_id'];
        $evento_id = $_POST['evento_id'];

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
    $stmt->bind_param("ss", $busqueda_param, $fecha); // Filtrar por título y fecha exacta
} else {
    $stmt->bind_param("s", $busqueda_param); // Filtrar solo por título si no hay fecha
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <style>
        .card {
            margin: 15px;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .boton-separado {
            margin-bottom: 10px;
            width: 100%;
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
                    $esta_inscrito = in_array($evento_id, $inscripciones); 

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
                                    <a href='php/event_detail.php?id=" . $row['id'] . "' class='btn btn-info boton-separado'>Ver detalles</a>";
                                    
                    // Mostrar botón según estado de inscripción
                    if ($esta_inscrito) {
                        echo "<span class='btn btn-secondary boton-separado disabled'>Inscrito</span>"; // Botón "Inscrito"
                        
                    } else {
                        echo "<form method='POST' action=''>
                                <input type='hidden' name='evento_id' value='" . $row['id'] . "'>
                                <button type='submit' class='btn btn-success boton-separado'>Inscribirse</button>
                              </form>"; // Botón "Inscribirse"
                    }

                    echo "</div></div></div>";
                }
            } else {
                echo "<div class='alert alert-info'>No se encontraron eventos.</div>";
            }
            ?>
        </div>
    </div>

    <!-- SweetAlert2 Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if ($mostrarModal): ?>
            Swal.fire({
                title: 'Autenticación requerida',
                text: '<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Iniciar Sesión',
                cancelButtonText: 'Cerrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'login.php';
                }
            });
            <?php endif; ?>
        });
    </script>

    <!-- Bootstrap Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
<footer class="footer">
        <div class="">
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>
</html>
