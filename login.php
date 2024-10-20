<?php 
include 'php/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMu2fSg2D1Evs1mSkzA9E0H2l9gWxkI6HImxQ8" crossorigin="anonymous">

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <!-- Formulario de Inicio de Sesión -->
    <div class="login-container">
        <img src="images/mi-logo.png" alt="Logo">

        <h2 class="mb-4">Eventos Comunitarios </h2>

        <!-- Mostrar mensaje de error general -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <form action="php/login_user.php" method="POST">
            <div class="mb-3">
                <input type="email" class="form-control <?php echo isset($_GET['email_error']) ? 'is-invalid' : ''; ?>" id="email" name="email" placeholder="Usuario" required>
                <?php if (isset($_GET['email_error'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $_GET['email_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control <?php echo isset($_GET['password_error']) ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder="Contraseña" required>
                <?php if (isset($_GET['password_error'])): ?>
                    <div class="invalid-feedback">
                        <?php echo $_GET['password_error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-custom w-100">Iniciar Sesión</button>
        </form>
        <div class="create-account">
            <a href="register.php">¿No tienes cuenta? <strong>Crea una nueva</strong></a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

        <?php
        include 'php/footer.php'; 
        ?>

</html>
