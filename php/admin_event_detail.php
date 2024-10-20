<?php
include 'db_connection.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';
// Verificar si la sesión está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables para mensajes de error y éxito
$error_message = "";
$success_message = "";

// Comprobar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el usuario está autenticado
    if (!isset($_SESSION['user_id'])) {
        $error_message = "Error: Usuario no autenticado.";
    } else {
        $evento_id = isset($_POST['evento_id']) ? (int)$_POST['evento_id'] : null;
        $usuario_id = $_SESSION['user_id']; // Asegúrate de que el ID del usuario esté en la sesión
        $comentario = isset($_POST['comentario']) ? trim($_POST['comentario']) : ''; 
        $valoracion = isset($_POST['calificacion']) ? (int)$_POST['calificacion'] : null; // Obtener la calificación enviada desde el formulario

        // Verificar si el evento_id y la valoración son válidos
        if ($evento_id && $valoracion) {
            // Insertar el comentario
            $sql = "INSERT INTO comentarios (evento_id, usuario_id, comentario, valoracion, fecha_comentario) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iisi", $evento_id, $usuario_id, $comentario, $valoracion);

            if ($stmt->execute()) {
                $success_message = "Comentario agregado correctamente.";
            } else {
                $error_message = "Error al agregar el comentario: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $error_message = "La calificación es obligatoria.";
        }
    }
}

// Verificar si se ha recibido el ID del evento
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID de evento no válido.";
    exit();
}

$evento_id = (int)$_GET['id'];

// Consultar detalles del evento
$sql = "SELECT * FROM eventos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $evento_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $evento = $result->fetch_assoc();
} else {
    echo "Evento no encontrado.";
    exit();
}

// Consultar comentarios del evento
$sql_comentarios = "SELECT c.*, u.nombre FROM comentarios c JOIN usuarios u ON c.usuario_id = u.id WHERE c.evento_id = ?";
$stmt_comentarios = $conn->prepare($sql_comentarios);
$stmt_comentarios->bind_param("i", $evento_id);
$stmt_comentarios->execute();
$result_comentarios = $stmt_comentarios->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($evento['titulo'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2, h3, h4 {
            text-align: center;
            color: #343a40;
        }
        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 25px;
            color: #FFD700;
            cursor: pointer;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            color: #ddd;
        }
        .star-rating input:checked ~ label {
            color: #FFD700;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #FFD700;
        }
        .card {
            margin-top: 20px;
        }
        .comentarios-list {
            margin-top: 20px;
        }
        .comentario {
            margin-bottom: 15px;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo htmlspecialchars($evento['titulo'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <div class="card p-4">
            <p><strong>Descripción:</strong> <?php echo htmlspecialchars($evento['descripcion'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Fecha:</strong> <?php echo htmlspecialchars($evento['fecha'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Hora:</strong> <?php echo htmlspecialchars($evento['hora'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion'], ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Categoría:</strong> <?php echo htmlspecialchars($evento['categoria'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <h3>Comentarios</h3>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php elseif ($success_message): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form action="event_detail.php?id=<?php echo $evento_id; ?>" method="POST">
            <input type="hidden" name="evento_id" value="<?php echo htmlspecialchars($evento['id'], ENT_QUOTES, 'UTF-8'); ?>">

            <div class="mb-3">
                <label for="calificacion" class="form-label">Calificación:</label><br>
                <span class="star-rating">
                    <input type="radio" name="calificacion" value="5" id="star5" required>
                    <label for="star5" class="star">&#9733;</label>
                    <input type="radio" name="calificacion" value="4" id="star4">
                    <label for="star4" class="star">&#9733;</label>
                    <input type="radio" name="calificacion" value="3" id="star3">
                    <label for="star3" class="star">&#9733;</label>
                    <input type="radio" name="calificacion" value="2" id="star2">
                    <label for="star2" class="star">&#9733;</label>
                    <input type="radio" name="calificacion" value="1" id="star1">
                    <label for="star1" class="star">&#9733;</label>
                </span>
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Deja tu comentario (opcional)</label>
                <textarea class="form-control" id="comentario" name="comentario"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
        </form>

        <h4>Comentarios Anteriores:</h4>
        <ul class="list-group comentarios-list">
            <?php while ($comentario = $result_comentarios->fetch_assoc()): ?>
                <li class="list-group-item comentario">
                    <strong><?php echo htmlspecialchars($comentario['nombre'], ENT_QUOTES, 'UTF-8'); ?>:</strong>
                    <p><?php echo htmlspecialchars($comentario['comentario'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p>Calificación: <?php echo str_repeat('★', $comentario['valoracion']); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$stmt_comentarios->close();
$conn->close();
include 'footer.php';
?>
