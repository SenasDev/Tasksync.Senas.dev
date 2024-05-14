<?php

// Función para conectar a la base de datos
if (!function_exists('conectdb')) {
    function conectdb() {
        $link = mysqli_connect("localhost", "root", "", "tasksync");
        if (!$link) {
            exit("No me he podido conectar: " . mysqli_connect_error());
        }
        return $link;
    }
}

// Función para enviar consultas a la base de datos
if (!function_exists('sendquery')) {
    function sendquery($link, $query) {
        $result = mysqli_query($link, $query);
        if (!$result) {
            exit("Error en la query: " . mysqli_error($link));
        }
        return $result;
    }
}

?>
