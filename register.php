<?php 
include 'php/header.php'; // El header se mantiene tal como lo tienes
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
            margin: auto;
        }
        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }
        .btn-custom {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
        }
        .btn-custom:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
        }
        .forgot-password, .create-account {
            margin-top: 15px;
        }
        footer {
            margin-top: auto;
            padding: 20px 0;
            text-align: center;
            background-color: #f1f1f1;
            width: 100%;
        }
    </style>
</head>
<body>

    <!-- Formulario de Registro -->
    <div class="login-container">
        <!-- Logo -->
        <img src="images/mi-logo.png" alt="Logo">

        <h2 class="mb-4">Registro de Usuario</h2>

        <!-- Mostrar mensaje de error general -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <form action="php/register_user.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control <?php echo isset($_GET['nombre_error']) ? 'is-invalid' : ''; ?>" id="nombre" name="nombre" placeholder="Nombre" required>
                <!-- Mostrar error debajo del campo de nombre -->
                <?php if (isset($_GET['nombre_error'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $_GET['nombre_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control <?php echo isset($_GET['email_error']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Correo Electrónico" required>
                <!-- Mostrar error debajo del campo de correo -->
                <?php if (isset($_GET['email_error'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $_GET['email_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control <?php echo isset($_GET['password_error']) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Contraseña" required>
                <!-- Mostrar error debajo del campo de contraseña -->
                <?php if (isset($_GET['password_error'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $_GET['password_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-custom w-100">Registrarse</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <?php
    include 'php/footer.php'; 
    ?>

</body>
</html>
