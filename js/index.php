<?php
include 'utilsdb.php';
session_start();

$link = conectdb(); // Establece la conexión al inicio
// Comprobar si el usuario NO está logueado
if (!isset($_SESSION['user_id'])) {
    // Usuario no logueado, redirigir a login.php
    header('Location: login.php');
    exit(); 
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>TaskSync</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/mainstyles.css">


</head>

<body>

    <div class="navbarTop">
        <!-- Código para la barra de navegación -->
        <?php
        if (isset($_SESSION['user_name'])) {
            echo "<h2>Hola, " . htmlspecialchars($_SESSION['user_name']) . "</h2> ";
          
        } else {
            echo "<a href='login.php'><button>Iniciar Sesión</button></a>";
            echo "<a href='register.php'><button>Registrarse</button></a>";
        }
        ?>
    </div>

    <div class="main-content">
        
       
    </div>


</body>


</html>