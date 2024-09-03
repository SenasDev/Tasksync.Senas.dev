<?php
session_start();
include 'utilsdb.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir si no está autenticado
    exit();
}

// Inicialización de variables
$userData = ['email' => '', 'name' => ''];
$message = ''; // Para almacenar mensajes personalizados

// Conexión a la base de datos
$link = conectdb();

// Función para cargar los datos del usuario
function loadUserData($link, $user_id) {
    $stmt = $link->prepare("SELECT email, name FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_name'] = $row['name']; // Actualizar la sesión con el nombre nuevo
        return $row; // Retorna los datos del usuario
    }
    $stmt->close();
    return null;
}

// Cargar datos del usuario para mostrar en el formulario
$user_id = $_SESSION['user_id'];
$userData = loadUserData($link, $user_id);

// Actualizar los datos del usuario si se recibe un POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : null;
    $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
    $updates = [];
    $password_updated = false;

    if ($password && $password === $confirm_password) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "password = '$password_hash'";
        $password_updated = true;
    } elseif ($password !== null) {
        $message = "Las contraseñas no coinciden.";
    }

    if ($name && $name !== $userData['name']) {
        $updates[] = "name = '$name'";
    }

    if (!empty($updates) && empty($message)) {
        $sql = "UPDATE users SET " . implode(", ", $updates) . " WHERE id = $user_id";
        if ($link->query($sql) === TRUE) {
            $message = $password_updated ? "La contraseña se ha guardado correctamente." : "Datos actualizados correctamente.";
            // Recargar datos después de la actualización
            $userData = loadUserData($link, $user_id);
        } else {
            $message = "Error al actualizar los datos: " . $link->error;
        }
    } else {
        // Recargar datos si hubo error para no perder la última información
        $userData = loadUserData($link, $user_id);
    }
}

mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/mainstyles.css">
        <link rel="stylesheet" href="../styles/modalstyles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <title>Editar Perfil</title>
    </head>
    
    <body>
        <header class="nav">
            <a href="../index.php">
                <div class=logo></div>
            </a>
            <div class="rightnav">
            <?php
            if (isset($_SESSION['user_name'])) {
                echo "<a href='../index.php'><button class='buttonprimary'>" . htmlspecialchars($_SESSION['user_name']) . "</button></a>";
                echo "<a href='logout.php'><button class='buttonexit'>Cerrar Sesion</button></a>";
            } else {
                echo "<a href='login.php'><button>Iniciar Sesión</button></a>";
                echo "<a href='register.php'><button>Registrarse</button></a>";
            }
            ?>
                <button id="dark-mode-toggle" class="buttonnight"><i class="bi bi-moon-fill"></i></button>
            </div>
        </header>
        <main>
            <!-- Modal para editar los datos del usuario -->
            <div class="modal">
                <div class="modal-content">
                    <h2>Editar datos</h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="email">Email (no editable):</label><br>
                            <input type="email" id="email" name="email"value="<?php echo htmlspecialchars($userData['email']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre:</label><br>
                            <input type="text" id="name" name="name"value="<?php echo htmlspecialchars($userData['name']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="password">Nueva Contraseña (opcional):</label><br>
                            <input type="password" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar Nueva Contraseña (opcional):</label><br>
                            <input type="password" id="confirm_password" name="confirm_password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar datos</button>
                            <a href="logout.php"><button class='buttonexit'>Cerrar Sesión</button></a>
                        </div>
                        <h3 class="message"><?php echo $message; ?></h3>
                    </form>
                </div>
            </div>
        <main>
        <footer class="footer">
            <div class="footer-content">
                <p>© 2024 TaskSync - Todos los derechos reservados</p>
                <ul class="footer-links">
                    <li><a href="privacypolicy.php">Política de Privacidad</a></li>
                    <li><a href="contact.php">Contacto</a></li>
                </ul>
            </div>
        </footer>
        <script src="../js/scriptsnightmode.js"></script>
    </body>
</html>