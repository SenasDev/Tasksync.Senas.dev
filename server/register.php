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
      $message = "El nombre de usuario ya existe.";
    } else {
      // Hashear la contraseña
      $password_hash = password_hash($password, PASSWORD_DEFAULT);
      $query = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password_hash')";
      sendquery($link, $query);
      $message = "Usuario registrado con éxito. Redirigiendo a Iniciar Sesión...";
  
      // Redirigir a login.php después de 2 segundos
      echo "<script>setTimeout(() => { window.location.href = 'login.php'; }, 2000);</script>";
    }
  
    mysqli_close($link);
  }

  ?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../styles/mainstyles.css">

    <title>Iniciar Sesión</title>
    
</head>
<div class="navbarTop">
    <?php


    if (isset($_SESSION['user_name'])) {
        echo "<a href='../logout.php'><button>Cerrar Sesión</button></a>";
    } else {
        echo "<a href='login.php'><button>Iniciar Sesión</button></a>";
        echo "<a href='register.php'><button>Registrarse</button></a>";
    }
    ?>
</div>

<body>
    <div class="main-content">
        <div class="card">
            <h2>Registrarse</h2>
            <form method="post" action="register.php">
                <div class="form-group">
                    <label for="email">Email:</label><br>
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
                    <input type="submit" value="Registrarse">
                </div>
            </form>
        </div>
    </div>
</body>

</html>