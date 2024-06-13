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

/* $companyusers = R::findAll('companyusers', 'user_id = :user_id', [':user_id' => $_SESSION['id']]);
$companies = [];
foreach ($companyusers as $companyuser) {
    $company = R::load('companies', $companyuser->company_id);
    $companies[] = $company;
}  */
/* $sql = "SELECT roles.* LEFT JOIN roles ON user_has_roles.rol_id = roles.id WHERE user_has_roles.user_id = {$_SESSION['id']}";
$companies = R::findAll('user_has_roles',$sql); */

if (isset($_SESSION['name'])) {

$sql = 'SELECT companies.name as company_name, companies.id as company_id, companies.image as company_image, roles.id as role_id, roles.name as role_name
        FROM user_has_roles
        LEFT JOIN roles ON user_has_roles.role_id = roles.id
        LEFT JOIN companies ON roles.company_id = companies.id

        WHERE user_has_roles.user_id = ?
        AND roles.status = 1';
$results = R::getAll($sql, [$_SESSION['id']]);

//traemos todos los registros de la tabla user_has_roles
echo json_encode(['status' => 1,'message' => 'SESION ACTIVA' , 'data' => $results ]);
}
else {
    echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION' ]);
}