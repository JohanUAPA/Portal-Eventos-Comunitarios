<?php
// Incluir el archivo de conexión
include 'db_connection.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}

include 'admin_header.php';
// Verificar si hay un mensaje en la URL
$message = '';
if (isset($_GET['message'])) {
    if ($_GET['message'] == 'converted') {
        $message = 'El usuario ha sido convertido en administrador.';
    } elseif ($_GET['message'] == 'deleted') {
        $message = 'El usuario ha sido eliminado.';
    } elseif ($_GET['message'] == 'error') {
        $message = 'Ocurrió un error. Inténtalo de nuevo.';
    }
}

// Consultar usuarios con rol de "usuario"
$sql = "SELECT * FROM usuarios WHERE rol = 'usuario'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("No se encontraron usuarios.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
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

    <!-- Mostrar mensajes -->
    <?php if ($message): ?>
        <div class="alert alert-info text-center">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Contenido principal -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Administrar Usuarios</h2>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $user['nombre']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <!-- Formulario para convertir en admin -->
                            <form action="convert_to_admin.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-warning btn-sm">Convertir en Admin</button>
                            </form>

                            <!-- Formulario para eliminar usuario -->
                            <form action="delete_user.php" method="POST" style="display:inline-block;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
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
