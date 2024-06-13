<?php
//Esto solo es en local
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');

header('Content-Type: application/json');
$host = 'localhost';
$db = 'codimet';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

session_start();

// Verifica que se haya enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Consulta para buscar al usuario
    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    // Verifica si se encontró el usuario y si la contraseña es correcta
    if ($user && password_verify($password, $user['password'])) {

        // Credenciales correctas, inicia la sesión

        if ($user['status'] == 0) {
            //usuario inactivo
            echo json_encode(['status' => 0 ,'message' => 'USUARIO INACTIVO' ]);
        } else {
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['status'] = $user['status'];
            $_SESSION['role_id'] = 0;
            $_SESSION['role_name'] = '';   
            $_SESSION['company_id'] = 0;
            $_SESSION['company_name'] = '';
            $_SESSION['company_image'] = '';
            //usuario activo
            echo json_encode(['status' => 1,'message' => 'USUARIO ACTIVO' ]);
        }
        exit;
    } else {
        // Credenciales incorrectas, muestra un mensaje de error
        echo json_encode(['status' => 0,'message' => 'CORREO Y/O CONTRASEÑA INCORRECTA' ]); //usuario no encontrado
        exit;
    }
}
