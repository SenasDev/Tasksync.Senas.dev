<?php
session_start();
include 'utilsdb.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
  
    $link = conectdb();
  
    // Buscar el usuario por email
    $stmt = $link->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
  
    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar la contraseña
        if (password_verify($password, $row['password'])) {
            // Iniciar sesión
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_id'] = $row['id'];
  
            // Redirigir a la página principal
            header("Location: ../index.php");
            exit();
        } else {
            $message = "Contraseña incorrecta."; // Almacenar mensaje de error
        }
    } else {
        $message = "Usuario no encontrado."; // Almacenar mensaje de error
    }
  
    mysqli_close($link);
  }
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../styles/mainstyles.css">
    <link rel="stylesheet" href="../styles/modalstyles.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <title>Iniciar Sesión</title>

</head>
<header class="nav">
    <div class=logo></div>
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

<body>
    <div class="modal" id="loginregister">
        <!-- Contenido del modal -->
        <div class="modal-content">
            <!-- Contenido del formulario -->
            <h2>Iniciar Sesión</h2>
            <!-- Formulario de inicio de sesión -->
            <form method="post" action="login.php">
                <!-- Campos del formulario -->
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
                <h3 class="message"><?php echo $message; ?></h3>

            </form>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 TaskSync - Todos los derechos reservados</p>
            <ul class="footer-links">
                <li><a href="privacypolicy.php">Política de Privacidad</a></li>
                <li><a href="faq.php">FAQ</a></li>
                <li><a href="contact.php">FAQ</a></li>
            </ul>
        </div>
    </footer>

    <script src="../js/scriptsnightmode.js"></script>
</body>

</html>