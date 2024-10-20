<?php
// Incluir el archivo de conexión
include 'db_connection.php'; 

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';


$id = $_GET['id'];


$sql = "SELECT * FROM eventos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Evento no encontrado.");
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
            max-width: 700px;
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
        textarea, input[type="text"], input[type="date"], input[type="time"] {
            border-radius: 5px;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        /* Footer más pequeño */
        .footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0; /* Reducir tamaño del footer */
            position: relative;
            bottom: 0;
            width: 100%;
        }
        /* Header */
        .navbar-brand {
            font-weight: bold;
            color: #343a40;
        }
        .navbar-nav .nav-link {
            font-size: 1.1rem;
            margin-left: 20px;
            color: #343a40;
        }
        .navbar-nav .nav-link:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Evento</h2>

        <form action="edit_event_handler.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $event['titulo']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required><?php echo $event['descripcion']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $event['fecha']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" value="<?php echo $event['hora']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $event['ubicacion']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $event['categoria']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Evento</button>
            <a href="event_list.php" class="btn btn-secondary">Cancelar</a>
        </form>
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
