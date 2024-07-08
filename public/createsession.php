<?php

$host = 'localhost';
$dbname = 'codimet';
$username = 'root';
$password = '';





// Crear una nueva conexión PDO
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

// Establecer el modo de error de PDO para que lance excepciones
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Verifica que se haya enviado el formulario
$name = 'erick';
$email = 'x@gmail.com';
$password = 'meyx8Dw9Y5';
$status  = 1;
$role = 'admin';

// El correo no está registrado, proceder con el registro
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Inserta el nuevo usuario en la base de datos
$stmt = $pdo->prepare('INSERT INTO users (name, email, password, status, role) VALUES (:name, :email, :password, :status, :role)');
$stmt->execute([
    'name' => $name,
    'email' => $email,
    'password' => $hashedPassword,
    'status' => $status,  // Puedes ajustar el valor de status según tus necesidades
    'role' => $role  // Puedes ajustar el valor de role según tus necesidades
]);

exit;
