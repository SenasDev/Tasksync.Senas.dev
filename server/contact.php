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
            $message = "Contraseña incorrecta."; 
        }
    } else {
        $message = "Usuario no encontrado.";
    }
  
    mysqli_close($link);
  }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/mainstyles.css">
        <link rel="stylesheet" href="../styles/modalstyles.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <title>Contacto</title>
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
            <!-- Formulario d contacto  -->
            <div class="modal" id="contactModal">
                <div class="modal-content">
                    <h2>Contacto</h2>
                    <form action="https://formspree.io/f/xwkgzzdy" method="POST">
                        <div class="form-group">
                            <label for="name">Nombre:</label><br>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" placeholder="Email Address" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Mensaje:</label><br>
                            <textarea id="message" name="message" rows="4" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
            </div>
        </div>
        </main>
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