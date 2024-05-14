<?php
include 'server/utilsdb.php';
 // Incluye el archivo insertevent.php

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
        <div class="lefttnav">

            <a href="index.php">
                <div class=logo></div>
            </a>

            <button class="buttonadd" id="buttonPlus">+</button>
        </div>

        <div class="rightnav">

            <?php
        if (isset($_SESSION['user_name'])) {
            echo "<a href='server/user.php'><button class='buttonprimary'>" . htmlspecialchars($_SESSION['user_name']) . "</button></a>";
            echo "<a href='server/logout.php'><button class='buttonexit'>Exit</button></a>";
            
        } else {
            echo "<a href='server/login.php'><button>Iniciar Sesión</button></a>";
            echo "<a href='server/register.php'><button>Registrarse</button></a>";
        }
        ?>
            <button id="dark-mode-toggle" class="buttonnight"><i class="bi bi-moon-fill"></i></button>
        </div>
    </header>

    <div class="calendarContainer">
        <div id="calendario"></div>
    </div>


    <!-- Modal Eventos -->

    <div id="addEventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Añadir Evento</h2>
            <form id="addEventForm" method="post" action="">
                <div class="form-group">
                    <label for="label">Label:</label>
                    <select id="label" name="label" class="form-control">
                        <option value="trabajo">Trabajo</option>
                        <option value="ocio">Ocio</option>
                        <option value="deporte">Deporte</option>
                        <option value="otro">Otro</option>
                    </select>
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
                <div id="responseAdd" class='message'></div>
                <!-- Agrega un campo oculto para almacenar el ID de usuario -->
                <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id']; ?>">
                <button type="submit" name="action" value="insert" class="btn btn-primary">Añadir Evento</button>

            </form>
        </div>
    </div>
    <!-- Modal Modificar Eventos -->

    <!-- Modal de Detalles de Evento para Editar -->
    <div id="editEventModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close closeEdit">&times;</span>
            <h2>Detalles de Evento</h2>
            <form id="editEventForm" method="post" action="">
                <div class="form-group">
                    <label for="editLabel">Label:</label>
                    <select id="editLabel" name="label" class="form-control">
                        <option value="trabajo">Trabajo</option>
                        <option value="ocio">Ocio</option>
                        <option value="deporte">Deporte</option>
                        <option value="otro">Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editTitle">Título:</label>
                    <input type="text" id="editTitle" name="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editDescription">Descripción:</label>
                    <textarea id="editDescription" name="description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="editTime">Hora:</label>
                    <input type="time" id="editTime" name="time" class="form-control">
                </div>
                <div class="form-group">
                    <label for="editDate">Fecha:</label>
                    <input type="date" id="editDate" name="date" class="form-control">
                </div>
                <div id="responseEdit" class='message'>sdfhsdfh</div>
                <input type="hidden" id="userId" name="userId" value="<?php echo $_SESSION['user_id']; ?>">
                <input type="hidden" id="taskId" name="taskId">
                <button type="submit" name="action" value="update" class="btn btn-primary">Guardar Cambios</button>
                <button type="submit" name="action" value="delete" class="btn btn-danger">Eliminar Evento</button>

            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <p>© 2024 TaskSync - Todos los derechos reservados</p>
            <ul class="footer-links">
                <li><a href="server/privacypolicy.php">Política de Privacidad</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </div>
    </footer>


    <!-- scripts propios -->


    <!-- scripts ajax, fullcalendar.. -->
    <!-- Opcional: jQuery y Popper.js primero, luego Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
    <script src="js/events.js"></script>




</body>

</html>