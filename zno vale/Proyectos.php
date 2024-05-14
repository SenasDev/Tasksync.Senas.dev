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
            echo "<button class='buttonprimary'>" . htmlspecialchars($_SESSION['user_name']);
            echo "<a href='server/logout.php'><button class='buttonexit'>Exit</button></a>";
          
        } else {
            echo "<a href='server/login.php'><button>Iniciar Sesión</button></a>";
            echo "<a href='server/register.php'><button>Registrarse</button></a>";
        }
        ?>
        </div>
        <div class="navbuttoncenter">

            <a href="index.php"><button id="agenda" class="buttonsecondary">Agenda</button></a>
            <a href="proyectos.php"><button class="buttonsecondary"style="filter: contrast(160%)">Proyectos</button></a>
        </div>
        <div class="rightnav">
            <button class="buttonadd" onclick="openModal()">+</button>

            <button id="dark-mode-toggle" class="buttonnight"><i class="bi bi-moon-fill"></i></button>
        </div>
    </header>

   
    <main>

    <main>
    <section class="proyectos">
    <div class="tarjeta-proyecto">
  <h2>Título del proyecto</h2>
  <p>Descripción breve del proyecto.</p>
  <div class="tarjeta-proyecto">
  <h2>Título del proyecto</h2>
  <p>Descripción breve del proyecto.</p>
</div>
</div>
      </section>
  </main>

    <!-- Modal Eventos -->

    <div id="addEventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Añadir Proyecto</h2>
            <form id="addEventForm">
                <div class="form-group">
                    <label for="label">Label:</label>
                    <input type="text" id="label" name="label" class="form-control">
                </div>
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input type="text" id="title" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Descripción:</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="time">Hora:</label>
                    <input type="time" id="time" name="time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date" class="form-control">
                </div>
                <!-- Agrega un campo oculto para almacenar el ID de usuario -->
                <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id']; ?>">
                <button type="submit" class="btn btn-primary">Añadir Evento</button>
            </form>
        </div>
    </div>
    
    </main>





    <!-- scripts propios -->

    <script src="js/scriptsnightmode.js"></script>
    <script src="js/scriptevent.js"></script>
    


</body>

</html>