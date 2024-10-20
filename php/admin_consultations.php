<?php
// Conexión a la base de datos
include 'db_connection.php';

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';

// Consultar todas las consultas
$query = "SELECT id, nombre, email, mensaje, respondido, fecha FROM consultas";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Consultas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f0f2f5;
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
            max-width: 900px;
            margin: auto;
            margin-bottom: 50px;
        }

        /* Encabezado */
        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }
       
        /* Tabla */
        .table-container {
            margin-top: 30px;
            overflow-x: auto;
        }
        table {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            table-layout: auto;
        }
        thead {
            background-color: #343a40;
            color: white;
        }

        thead th {
            padding: 10px;
            font-size: 18px;
            text-align: center;
        }
        tbody td {
            padding: 15px;
            vertical-align: middle;
            text-align: center;
            font-size: 16px;
        }
        tbody tr:hover {
            background-color: #e9f5ff;
        }

        /* Botones */
        .btn {
            width: 160px; /* Tamaño uniforme */
            font-size: 16px;
            padding: 8px;
            margin: 5px;
            transition: all 0.3s ease;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
       .badge-respondido {
            width: 160px; /* Tamaño uniforme */
            font-size: 16px;
            padding: 8px;
            margin: 5px;
            transition: all 0.3s ease;
            background-color: #28a745;
            border: none;
        }

        /* Etiquetas de estado */
        .badge-success, .badge-respondido {
            padding: 8px;
            color: white;
            border-radius: 0.5rem;
        }
        .badge-success {
            background-color: #28a745;
        }
        .badge-respondido {
            background-color: #6c757d;
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
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consultas/Sugerencias</h1> <!-- Título agregado -->
        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Mensaje</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['mensaje']; ?></td>
                            <td><?php echo $row['fecha']; ?></td>
                            <td>
                                <!-- Botón para marcar como respondido -->
                                <?php if ($row['respondido'] == 0): ?>
                                    <form method="post" action="mark_as_responded.php" style="display: inline-block;">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-success">Marcar como Respondido</button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge badge-respondido">Respondido</span>
                                <?php endif; ?>

                                <!-- Botón para eliminar -->
                                <form method="post" action="delete_consulta.php" style="display: inline-block;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Footer -->
    <footer class="footer">
        <div>
            <p>© 2024 Eventos Comunitarios. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
