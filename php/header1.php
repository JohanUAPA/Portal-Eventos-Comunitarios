<!-- header.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <style>
        /* Ajuste para el logo "Eventos Comunitarios" */
        .navbar-brand {
            font-weight: bold;
            color: #000; 
            font-size: 1.5rem; 
            margin-left: 20px; 
        }

        /* Ajuste para los enlaces de navegación */
        .navbar-nav .nav-link {
            color: #444; 
            font-size: 1.1rem;
            margin-right: 15px;
        }

        /* Efecto hover para los enlaces */
        .navbar-nav .nav-link:hover {
            color: #000; 
        }

        
        .navbar-nav .btn {
            margin-right: 10px;
        }

        
        .navbar-nav .btn-dark {
            margin-right: 20px; 
        }

       
        .navbar {
            padding: 10px 0; 
        }
    </style>
</head>
<body>
    <!-- navegación-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="../home.php">Eventos Comunitarios</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../user_event_list.php">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../contact.php">Contacto</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href="../login.php">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-dark" href="../register.php">Registrarse</a>
                </li>
            </ul>
        </div>
    </nav>

