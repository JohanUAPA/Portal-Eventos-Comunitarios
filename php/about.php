<?php
include 'header1.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Comunitarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background-color: #1a1a1a;
            color: white;
            text-align: center;
            padding: 100px 0;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #f8f9fa;
            color: black;
            border-radius: 0;

        }
    </style>
</head>
<body>

    

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1>Descubre Eventos Comunitarios Asombrosos</h1>
            <p>Conéctate, aprende y diviértete con eventos locales en tu área.</p>
            <a href="../user_event_list.php" class="btn btn-custom btn-lg">Explorar Eventos Destacados</a>
        </div>
    </section>

    <!-- Eventos Destacados -->
    <section class="text-center my-5">
        <div class="container">
            <h2>Eventos</h2>
    
            <p>Bienvenido al Portal de Eventos Comunitarios, una plataforma diseñada para facilitar la participación y el descubrimiento 
                de eventos que enriquecen la vida en comunidad. Nos enfocamos en conectar a las personas con actividades locales que 
                promueven la cultura, el deporte, la educación y el bienestar social.</p>

            <p>Ya seas un entusiasta de los eventos o alguien que busca nuevas experiencias, nuestro portal te permite explorar una amplia variedad de
                actividades según tus intereses. Podrás inscribirte fácilmente en eventos de todo tipo, desde talleres y exposiciones, hasta 
                eventos deportivos y festivales comunitarios. Además, tendrás la oportunidad de dejar tus comentarios y valoraciones para ayudar 
                a otros a descubrir los mejores eventos.</p>  

            <p>Nuestro objetivo es fortalecer los lazos comunitarios, ofreciendo a los usuarios una experiencia intuitiva y accesible. 
                Queremos que seas parte activa de tu entorno, contribuyendo con tu participación a la creación de una comunidad más dinámica 
                y conectada.</p>  
        
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php
include 'footer.php';
?>