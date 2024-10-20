<?php
include 'db_connection.php'; 

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';

$sql = "SELECT inscripciones.*, eventos.titulo, eventos.fecha AS fecha_evento, usuarios.nombre 
        FROM inscripciones 
        JOIN eventos ON inscripciones.evento_id = eventos.id 
        JOIN usuarios ON inscripciones.usuario_id = usuarios.id";
$result = $conn->query($sql);

// Verificar si se ha enviado el formulario de búsqueda
$search_event = '';
$search_date = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_event = $_POST['search_event'] ?? '';
    $search_date = $_POST['search_date'] ?? '';

    // Consultar inscripciones filtradas por evento y/o fecha
    $sql = "SELECT inscripciones.*, eventos.titulo, eventos.fecha AS fecha_evento, usuarios.nombre 
            FROM inscripciones 
            JOIN eventos ON inscripciones.evento_id = eventos.id 
            JOIN usuarios ON inscripciones.usuario_id = usuarios.id WHERE 1=1";
    
    if (!empty($search_event)) {
        $sql .= " AND eventos.titulo LIKE ?";
        $search_event = "%$search_event%"; // Agregar comodines para la búsqueda
    }
    if (!empty($search_date)) {
        $sql .= " AND DATE(eventos.fecha) = ?";
    }

    $stmt = $conn->prepare($sql);

    if (!empty($search_event) && !empty($search_date)) {
        $stmt->bind_param("ss", $search_event, $search_date);
    } elseif (!empty($search_event)) {
        $stmt->bind_param("s", $search_event);
    } elseif (!empty($search_date)) {
        $stmt->bind_param("s", $search_date);
    }

    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Inscripciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex-grow: 1;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: auto;
            margin-bottom: 50px; /* Asegura espacio antes del footer */
        }
        h2 {
            font-weight: bold;
            color: #343a40;
        }
        label {
            font-weight: bold;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        /* Footer */
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Administrar Inscripciones</h2>

        <!-- Mensajes de confirmación -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                Inscripción eliminada con éxito.
            </div>
        <?php endif; ?>

        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col">
                    <label for="search_event">Buscar por Evento</label>
                    <input type="text" class="form-control" id="search_event" name="search_event" value="<?php echo htmlspecialchars($search_event); ?>">
                </div>
                <div class="col">
                    <label for="search_date">Buscar por Fecha del Evento</label>
                    <input type="date" class="form-control" id="search_date" name="search_date" value="<?php echo htmlspecialchars($search_date); ?>">
                </div>
                <div class="col mt-4">
                    <button type="submit" class="btn btn-primary mt-4">Buscar</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Evento</th>
                    <th>Usuario</th>
                    <th>Fecha del Evento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { ?>
                    <?php while ($inscripcion = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($inscripcion['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($inscripcion['fecha_evento']); ?></td>
                            <td>
                                <!-- Formulario para eliminar inscripción -->
                                <form action="delete_inscription.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $inscripcion['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4" class="text-center">No se encontraron inscripciones.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div>
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
