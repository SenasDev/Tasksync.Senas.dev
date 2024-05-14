<?php
include 'getuserbyid.php'; // Asegúrate de incluir el archivo que contiene la función getUserById()

// Obtener datos del usuario con ID 1
$userId = 1;
$userData = getUserById($userId);

// Imprimir los datos del usuario y las tareas en formato JSON en la pantalla
echo json_encode($userData, JSON_PRETTY_PRINT);
?>

