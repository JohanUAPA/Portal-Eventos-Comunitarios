<?php 
include 'php/contact_header.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }
        .contact-section {
            padding: 60px 0;
            text-align: center;
            background-color: #343a40;
            color: white;
        }
        .contact-section h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .contact-section p {
            font-size: 1.2rem; 
            margin: 0; 
        }
        .container {
            flex: 1;
        }
        .form-container {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
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

    <!-- Sección de Contacto -->
    <section class="contact-section">
        <div class="container">
            <h1>Contacto</h1>
            <p>¿Tienes alguna pregunta o sugerencia? Envíanos un mensaje.</p>
        </div>
    </section>

    <!-- Formulario de Contacto -->
    <div class="container mt-5">
        <div class="form-container">
            <form id="contactForm">
                <div class="form-group mb-3">
                    <label for="nombre" class="form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group mb-4">
                    <label for="mensaje" class="form-label">Mensaje:</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Enviar Mensaje</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="resultadoModal" tabindex="-1" aria-labelledby="resultadoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultadoModalLabel">Resultado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="mensajeResultado"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('contactForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita el envío normal del formulario

            // Obtiene los datos del formulario
            var formData = new FormData(this);

            // Envía los datos usando Fetch API
            fetch('php/contact_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // Espera la respuesta en formato JSON
            .then(data => {
                // Muestra el mensaje en el modal
                var mensajeDiv = document.getElementById('mensajeResultado');
                mensajeDiv.textContent = data.mensaje;

                // Muestra el modal
                var resultadoModal = new bootstrap.Modal(document.getElementById('resultadoModal'));
                resultadoModal.show();

                // Limpia el formulario
                this.reset();
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>

<?php
include 'php/footer.php';
?>
