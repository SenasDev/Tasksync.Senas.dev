<?php
session_start();
include 'utilsdb.php';

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
        echo "Contraseña incorrecta.";
      }
    } else {
      echo "Usuario no encontrado.";
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
            <h2>Iniciar Sesión</h2>
            <form method="post" action="login.php">
                <div class="form-group">
                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label><br>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Iniciar Sesión">
                </div>
            </form>
        </div>
    </div>
</body>

</html>