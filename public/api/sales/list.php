<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {

    $sql = 'SELECT sales.id as sale_id, sales.total as sale_total,  sales.status as sale_status, sales.updated_at as sale_updated
            FROM sales
    
            WHERE sales.company_id = ?
            AND sales.status = 1
            ORDER BY sales.updated_at DESC;
            ';
    $results = R::getAll($sql, [$_SESSION['company_id']]);
    
    //traemos todos los registros de la tabla user_has_roles
    echo json_encode(['status' => 1,'message' => 'SESION ACTIVA' , 'data' => $results ]);
    }
    else {
        echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION' ]);
    }