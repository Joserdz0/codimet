<?php
//Esto solo es en local
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');

//con php checamos si existe una sesion activa y si si la hay regresamos un json con los datos de la sesion si no regresamos un json vacio
header('Content-Type: application/json');
session_start();
if (isset($_SESSION['name'])) {
    
    echo json_encode(['status' => 1,'message' => 'SESION ACTIVA' , 'data' => $_SESSION]);
} else {
    echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION']);
}