<?php
//Esto solo es en local
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');

//con php checamos si existe una sesion activa y si si la hay regresamos un json con los datos de la sesion si no regresamos un json vacio
header('Content-Type: application/json');
session_start();
if (isset($_SESSION['name'])) {
    //todos los datos se datos se deberian de validar antes de ser insertados pero nosotros lo omitimos

    if (isset($_POST['name']) && isset($_POST['value'])) {
        //obtenemos la variable enviada por post llamada name
        $name = $_POST['name'];
        //obtenemos la variable enviada por post llamada value
        $value = $_POST['value'];
        $_SESSION[$name] = $value;
        echo json_encode(['status' => 1, 'message' => 'ACTUALIZADO CORRECTAMENTE']);
    } else {
        echo json_encode(['status' => 0, 'message' => 'DATOS FALTANTES']);
    }
} else {
    echo json_encode(['status' => 0, 'message' => 'NO EXISTE SESION']);
}
