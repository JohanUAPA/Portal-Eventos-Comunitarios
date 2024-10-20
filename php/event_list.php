<?php

include 'db_connection.php'; 

if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    // Redirigir a la página de acceso denegado
    header("Location: acceso_denegado.php");
    exit();
}
include 'admin_header.php';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Eventos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        h2 {
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
        table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .table thead {
            background-color: #343a40;
            color: white;
        }

        .table thead th {
         background-color: #343a40;
         color: white; 
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .table td a {
            color: #007bff;
            text-decoration: none;
        }
        .table td a:hover {
            text-decoration: underline;
        }
        .btn-warning, .btn-danger {
            font-weight: bold;
            color: black !important; 
            text-decoration: none !important; 
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
        
        /* Ajuste para pantallas pequeñas */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
            table {
                font-size: 0.9rem;
            }
        }
    </style>
    </style>
</head>
<body>
    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de Eventos</h2>
            <a href="add_event.php" class="btn btn-primary">Añadir Evento</a>
        </div>

        <!-- Mostrar mensaje de éxito -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success text-center">
                <?php echo $_GET['success']; ?>
            </div>
        <?php endif; ?>

        <!-- Tabla de eventos -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Ubicación</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Consultar eventos
                $sql = "SELECT * FROM eventos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td><a href='event_detail.php?id={$row['id']}'>{$row['titulo']}</a></td>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['fecha']}</td>
                            <td>{$row['hora']}</td>
                            <td>{$row['ubicacion']}</td>
                            <td>{$row['categoria']}</td>
                            <td>
                                <a href='edit_event.php?id={$row['id']}' class='btn btn-warning btn-sm'>Editar</a>
                                <a href='delete_event.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este evento?\");'>Eliminar</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No hay eventos disponibles.</td></tr>";
                }

                $conn->close();
                ?>
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
