<?php
include 'utilsdb.php';

$message = "";

// Inicio del registro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  
    // Conectar a la base de datos (reemplaza con tu función conectdb())
    $link = conectdb();
  
    // Verificar si el nombre de usuario ya existe
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = sendquery($link, $query);
    if (mysqli_num_rows($result) > 0) {
      $message = "E-mail registrado, introduce otro e-mail";
    } else {
      // Hashear la contraseña
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password_hash')";
      sendquery($link, $query);
      $message = "Registro con éxito. Redirigiendo...";
  
      // Redirigir a login.php después de 2 segundos
      echo "<script>setTimeout(() => { window.location.href = 'login.php'; }, 2000);</script>";
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
    <title>Registrarse</title>

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
        <div class="modal-content">
            <h2>Registrarse</h2>
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="email">E-mail:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="name">Nombre:</label><br>
                    <input type="name" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" value="Registrarse">Registrarse</button>
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
            </ul>
        </div>
    </footer>

    <script src="../js/scriptsnightmode.js"></script>
</body>

</html>