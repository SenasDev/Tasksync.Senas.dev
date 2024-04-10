<?php
include 'server/utilsdb.php';
session_start();

$link = conectdb(); // Establece la conexión al inicio
// Comprobar si el usuario NO está logueado
if (!isset($_SESSION['user_id'])) {
    // Usuario no logueado, redirigir a login.php
    header('Location: server/login.php');
    exit(); 
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda Start Page</title>
    <!-- estilos bootsrtap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <!-- estilos fullcalendar -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.css' rel='stylesheet' />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.css' rel='stylesheet' />

    <!-- estilos propios -->
    <link rel="stylesheet" href="styles/mainstyles.css">
    <link rel="stylesheet" href="styles/modalstyles.css">


</head>

<body>
    <header class="nav">
        <div class="leftnav">
        <?php
        if (isset($_SESSION['user_name'])) {
            echo "<button class='buttonprimary'>" . htmlspecialchars($_SESSION['user_name']) . "</h2> ";
            echo "<a href='logout.php'><button>Cerrar Sesión</button></a>";
          
        } else {
            echo "<a href='login.php'><button>Iniciar Sesión</button></a>";
            echo "<a href='register.php'><button>Registrarse</button></a>";
        }
        ?>
        </div>
        <div class="navbuttoncenter">
            
            <button id="agenda" class="buttonprimary">Agenda</button>
            <button class="buttonprimary">Proyectos</button>
        </div>
        <div class="rightnav">
            <button class="buttonadd">+</button>
            <button id="dark-mode-toggle"><i class="bi bi-moon-fill"></i></button>
        </div>
    </header>

    <div id="contenedorcalendario" style="height: 700px;">
        <div id="calendario"></div>
    </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="registroModal" tabindex="-1" role="dialog" aria-labelledby="modeloRegistroLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modeloRegistroLabel">Registro de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formRegistro">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- scripts propios -->
    
    
    <!-- scripts ajax, fullcalendar.. -->
    <!-- Opcional: jQuery y Popper.js primero, luego Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"  ></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/interaction/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/daygrid/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/timegrid/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/list/main.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/4.2.0/core/locales/es.js'></script>
    
    <script src="js/scriptsdiary.js"></script>
    <script src="js/scriptsnightmode.js"></script>
    <script src="js/login.js"></script>

</body>

</html>