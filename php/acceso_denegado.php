<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> <!-- Responsivo -->
    <title>Acceso Denegado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> <!-- Bootstrap CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Color de fondo */
        }
        .container {
            margin-top: 100px; /* Espacio superior */
        }
        .alert {
            color: red; /* Color del texto */
        }
    </style>
</head>
<body>
    <div class="container text-center">
        <div class="alert alert-danger">
            <h1>Acceso Denegado</h1>
            <p>No tienes permiso para acceder a esta página.</p>
            <a href="../login.php" class="btn btn-primary">Volver a iniciar sesión</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> <!-- Popper.js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> <!-- Bootstrap JS -->
</body>
</html>
