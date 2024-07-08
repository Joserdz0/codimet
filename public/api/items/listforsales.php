<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {

    $sql = 'SELECT items.id as item_id, items.name as item_name, items.price as item_price,  items.quantity as item_quantity, items.status as item_status
            FROM items
    
            WHERE items.company_id = ?
            AND items.quantity > 0
            AND items.status = 1';
    $results = R::getAll($sql, [$_SESSION['company_id']]);
    
    //traemos todos los registros de la tabla user_has_roles
    echo json_encode(['status' => 1,'message' => 'SESION ACTIVA' , 'data' => $results ]);
    }
    else {
        echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION' ]);
    }