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
    <div class="modalpoliticaprivacidad" id="politica-privacidad-modal">
        <div class="modal-content" id="privacyPolicy">
            <h1>Política de Privacidad</h1>
            <h2>Información que recopilamos</h2>
            <p>En TaskSync, recopilamos información personal y no personal que nos proporcionas directamente cuando
                utilizas nuestros servicios. Esto puede incluir datos que nos ofreces al crear una cuenta, compartir
                información de contacto, o usar nuestras funcionalidades.</p>

            <h2>Uso de la información</h2>
            <p>Utilizamos la información recopilada para proporcionar, mantener y mejorar nuestros servicios, así como
                para desarrollar nuevos servicios y ofrecer protección a TaskSync y nuestros usuarios.</p>

            <h2>Compartiendo tu información</h2>
            <p>No vendemos tu información personal a terceros. Podemos compartir información con nuestros socios de
                confianza para permitir la creación de funcionalidades mejoradas, análisis estadísticos y otros
                servicios similares.</p>

            <h2>Tus derechos y opciones</h2>
            <p>Tienes derecho a acceder, corregir o eliminar tus datos personales que tenemos. Además, puedes oponerte
                al procesamiento de tus datos personales, solicitar la limitación del procesamiento y solicitar la
                portabilidad de tus datos.</p>

            <h2>Cambios a esta política</h2>
            <p>Podemos actualizar nuestra política de privacidad ocasionalmente. Te notificaremos sobre cualquier cambio
                publicando la nueva política de privacidad en esta página.</p>

            <h2>Contacto</h2>
            <p>Si tienes preguntas sobre esta política de privacidad, puedes contactarnos usando la información
                proporcionada en nuestro sitio web.</p>
        </div>
    </div>
    
    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 TaskSync - Todos los derechos reservados</p>
            <ul class="footer-links">
                <li><a href="privacypolicy.php">Política de Privacidad</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>
    </footer>

    <script src="../js/scriptsnightmode.js"></script>
</body>

</html>