<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal de Eventos Comunitarios para la gestión de eventos locales">
    <title>Portal de Eventos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-5HbGqWzZn4HvRuygznw9jxJLg2z8P0HYX2l+neRtUf4ZdOqltPzXzfi38JpJZ9an" crossorigin="anonymous">

    <!-- Font Awesome -->
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

        /* Ajustes de botones en la barra de navegación */
        .navbar-nav .btn {
            margin-right: 10px;
        }

        .navbar-nav .btn-dark {
            margin-right: 20px; 
        }

        /* Ajuste de padding en la barra de navegación */
        .navbar {
            padding: 10px 0; 
        }

        /* Mejora del diseño responsive */
        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <!--  Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="home.php">Eventos Comunitarios</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_event_list.php">Eventos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="php/about.php">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contacto</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href="login.php">Iniciar sesión</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-dark" href="register.php">Registrarse</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-mrcA2aFDKjrQQwyTMFxEOQuBuNW+a3fJ8hc5fqs5LLl88NxFA7eg8U2hBszNDR" crossorigin="anonymous"></script>
</body>
</html>
