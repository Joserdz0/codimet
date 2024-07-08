<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {
    //guardamos los campos nombre, valor, id
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $item = R::dispense('items');
    $item->company_id = $_SESSION['company_id'];
    $item->name = strtoupper($name);
    $item->price = $price;
    $item->quantity = $quantity;
    $item->status = 1;

    $id = R::store($item);



    echo json_encode(['status' => 1, 'message' => 'CREADO CORRECTAMENTE', 'data' => $name]);
} else {
    echo json_encode(['status' => 0, 'message' => 'NO EXISTE SESION']);
}
