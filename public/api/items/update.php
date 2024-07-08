<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {
    //guardamos los campos nombre, valor, id
    $nombre = $_POST['nombre'];
    $valor = $_POST['valor'];
    $id = $_POST['id'];
    $item = R::load('items', $id);
    if ($item->id) {
        // Modificar los campos necesarios
        $item->$nombre = $valor;
        
        // Guardar los cambios
        R::store($item);
        
        echo json_encode(['status' => 0,'message' => 'ACTUALIZADO CORRECTAMENTE']);
    } else {
        echo json_encode(['status' => 0,'message' => 'NO EXISTE REGISTRO']);
    }

}
else {
    echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION' ]);
}