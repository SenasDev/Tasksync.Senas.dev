<?php
include 'utilsdb.php';

function getUserById()
{
    session_start(); // Iniciar la sesión si no está iniciada

    // Verificar si existe un usuario en la sesión
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id']; // Obtener el ID de usuario de la sesión

        // Conectar a la base de datos
        $link = conectdb();

        // Preparar la consulta SQL para obtener las tareas del usuario usando consultas preparadas
        $stmt = $link->prepare("SELECT TaskID AS ID, Label, Title, Description, Time AS startTime, Day AS start FROM task WHERE UserID = ?");
        $stmt->bind_param("i", $userId); // 'i' indica que la variable es de tipo entero

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultTasks = $stmt->get_result();

        // Almacenar las tareas en un array
        $tasksData = array();
        if ($resultTasks->num_rows > 0) {
            while ($row = $resultTasks->fetch_assoc()) {
                // Ajustar el formato de la fecha y la hora para que coincida con el esperado por FullCalendar
                $row['start'] = $row['start'] . 'T' . $row['startTime'];
                unset($row['startTime']); // Eliminar el campo de hora si no es necesario

                $tasksData[] = $row;
            }
        }

        // Liberar el resultado y cerrar la declaración
        $stmt->free_result();
        $stmt->close();

        // Devolver los datos en formato JSON
        return $tasksData;
    } else {
        return null; // No hay usuario en la sesión
    }
}

// Obtener datos del usuario de la sesión
$tasksData = getUserById();

// Imprimir los datos del usuario y las tareas en formato JSON en la pantalla
echo json_encode($tasksData, JSON_PRETTY_PRINT);
?>






