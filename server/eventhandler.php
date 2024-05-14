<?php
include 'utilsdb.php';
session_start();
$link = conectdb();

$response = ['success' => false, 'message' => 'No se pudo ejecutar la operación'];

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $taskId = $_POST["taskId"] ?? null;
    $action = $_POST['action'] ?? 'update';  // Valor predeterminado a 'update' si no se especifica
   

    if ($action == 'delete') {

        // Eliminación
        
        $query = "DELETE FROM task WHERE TaskID=? AND UserID=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "ii", $taskId, $userId);
        if ($stmt && mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'Evento eliminado con éxito';
        } else {
            $response['message'] = 'Error al eliminar evento';
        }
    } elseif ($taskId) {
        // Actualización
        $label = $_POST["label"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $time = $_POST["time"];
        $date = $_POST["date"];
        $query = "UPDATE task SET Label=?, Title=?, Description=?, Time=?, Day=? WHERE TaskID=? AND UserID=?";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "sssssii", $label, $title, $description, $time, $date, $taskId, $userId);
        if ($stmt && mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'Evento actualizado con éxito';
        } else {
            $response['message'] = 'Error al actualizar evento';
        }
    } else {
        // Inserción
        $label = $_POST["label"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $time = $_POST["time"];
        $date = $_POST["date"];
        $query = "INSERT INTO task (Label, Title, Description, Time, Day, UserID) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($stmt, "sssssi", $label, $title, $description, $time, $date, $userId);
        if ($stmt && mysqli_stmt_execute($stmt)) {
            $response['success'] = true;
            $response['message'] = 'Evento creado con éxito';
        } else {
            $response['message'] = 'Error al crear evento';
        }
    }

    mysqli_stmt_close($stmt);
} 

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>





