<?php
include 'utilsdb.php';

function getUserById()
{
    session_start(); // Iniciar la sesión si no está iniciada

    // Verificar si existe un usuario en la sesión
    if (isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];

        // Conectar a la base de datos
        $link = conectdb();

        // Preparar la consulta SQL para obtener las tareas del usuario usando consultas preparadas
        $stmt = $link->prepare("SELECT TaskID AS ID, Label, Title, Description, Time AS startTime, Day AS start FROM task WHERE UserID = ?");
        $stmt->bind_param("i", $userId);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $resultTasks = $stmt->get_result();

        // Almacenar las tareas en un array
        $tasksData = array();
        if ($resultTasks->num_rows > 0) {
            while ($row = $resultTasks->fetch_assoc()) {
                $row['start'] = $row['start'] . 'T' . $row['startTime'];
                $tasksData[] = $row;
            }
        }
        $stmt->free_result();
        $stmt->close();

        // Devolver los datos en formato JSON
        return $tasksData;
    } else {
        return null; // Retrono null si hay usuario en la sesión
    }
}

// Obtener datos del usuario de la sesión
$tasksData = getUserById();

echo json_encode($tasksData, JSON_PRETTY_PRINT);
?>






