<?php
//Esto solo es en local
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');

//con php checamos si existe una sesion activa y si si la hay regresamos un json con los datos de la sesion si no regresamos un json vacio
header('Content-Type: application/json');
// Incluir RedBeanPHP
require 'rb-mysql.php';
$host = 'localhost';
$db = 'codimet';
$user = 'root';
$pass = '';
//------------------------------------------------
// Configurar la conexión a la base de datos
R::setup("mysql:host={$host};dbname={$db}", $user, $pass);
// Verificar la conexión
if (!R::testConnection()) {
    die('No se pudo conectar a la base de datos');
}

session_start();