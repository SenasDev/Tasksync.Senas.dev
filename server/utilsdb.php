<?php

// Funcion para conectar a la base de datos 
function conectdb()
{

    $link=mysqli_connect("localhost","root","","tasksync");
    if(!$link)
        exit("no me he puedo conectar");
    return $link;
}

function sendquery($link,$query)
{
    $result=mysqli_query($link,$query);
    if(!$result)
        exit("Error en la query".mysqli_error($link));
    return $result;

}




