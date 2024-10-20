
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Evento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5; /* Fondo suave */
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
            max-width: 600px; /* Ancho máximo */
            margin-top: 50px; /* Espacio superior */
        }
        h2 {
            font-weight: bold;
            color: #343a40;
        }
        .form-control {
            border-radius: 8px; /* Bordes suaves */
            background-color: #f8f9fa; /* Fondo ligeramente gris */
            border: 1px solid #ced4da;
            padding: 10px;
        }
        .form-label {
            font-weight: bold;
            color: #495057;
        }
        button.btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
        }
        button.btn-primary:hover {
            background-color: #0056b3;
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

        /* Estilos para el header */
        .navbar-brand {
            font-weight: bold;
            color: #343a40;
        }
        .navbar-nav .nav-link {
            text-align: center;
            font-size: 1.1rem;
            margin-left: 20px;
            margin-right: 20px;
            color: #343a40;
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

        /* Ajuste para pantallas pequeñas */
        @media (max-width: 576px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin_dashboard.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav me-auto mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="admin_dashboard.php">Dashboard</a>
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
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container">
        <h2 class="text-center mb-4">Añadir Evento</h2>

        <!-- Mostrar mensaje de error general -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Formulario para añadir evento -->
        <form action="add_event_handler.php" method="POST">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="mb-3">
                <label for="hora" class="form-label">Hora</label>
                <input type="time" class="form-control" id="hora" name="hora" required>
            </div>
            <div class="mb-3">
                <label for="ubicacion" class="form-label">Ubicación</label>
                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Añadir Evento</button>
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
