<?php
include 'db_connection.php';
include 'user_header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Consulta para obtener los datos del usuario
$sql = "SELECT nombre, email FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Actualizar los datos del usuario en la base de datos
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql_update = "UPDATE usuarios SET nombre = ?, email = ?, contrasena = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssi", $nombre, $email, $password_hash, $user_id);
    } else {
        // Si no se proporciona nueva contraseña, no actualizarla
        $sql_update = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ssi", $nombre, $email, $user_id);
    }

    if ($stmt_update->execute()) {
        // Actualizar los datos en la sesión o volver a cargar los datos actualizados
        $_SESSION['user_name'] = $nombre;
        header("Location: perfil.php");
        exit();
    } else {
        echo "Error al actualizar los datos.";
    }
}



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card {
            max-width: 500px;
            margin: 100px auto;
            padding: 20px;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
        
    
    .dropdown-toggle {
    font-weight: bold;
    color: #343a40;
}
    </style>
    
    <div class="container">
        <div class="card text-center">
            <div class="card-body">
                <h1 class="card-title">Perfil de Usuario</h1>
                <form method="POST" id="profileForm">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?php echo htmlspecialchars($user['nombre'], ENT_QUOTES, 'UTF-8'); ?>" disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>" disabled required>
                    </div>
                    <div class="mb-3" id="passwordGroup" style="display:none;">
                        <label for="password" class="form-label">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Dejar en blanco si no desea cambiarla">
                    </div>

                    <!-- Botones -->
                    <div id="buttonsContainer">
                        <button type="button" class="btn btn-primary" id="editProfileBtn">Editar Perfil</button>
                    </div>

                    <div id="editButtons" style="display:none;">
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        <button type="button" class="btn btn-danger" id="cancelEditBtn">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad para habilitar/deshabilitar edición
        const editProfileBtn = document.getElementById('editProfileBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const nombreInput = document.getElementById('nombre');
        const emailInput = document.getElementById('email');
        const passwordGroup = document.getElementById('passwordGroup');
        const editButtons = document.getElementById('editButtons');
        const buttonsContainer = document.getElementById('buttonsContainer');

        // Al hacer clic en Editar
        editProfileBtn.addEventListener('click', () => {
            nombreInput.disabled = false;
            emailInput.disabled = false;
            passwordGroup.style.display = 'block';  // Mostrar el campo de contraseña
            editButtons.style.display = 'block';  // Mostrar botones de Guardar y Cancelar
            buttonsContainer.style.display = 'none';  // Ocultar el botón de Editar
        });

        // Al hacer clic en Cancelar
        cancelEditBtn.addEventListener('click', () => {
            nombreInput.disabled = true;
            emailInput.disabled = true;
            passwordGroup.style.display = 'none';  // Ocultar el campo de contraseña
            editButtons.style.display = 'none';  // Ocultar botones de Guardar y Cancelar
            buttonsContainer.style.display = 'block';  // Mostrar el botón de Editar
        });
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
