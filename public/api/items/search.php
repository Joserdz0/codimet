<?php

//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
header('Content-Type: text/html');
// verificamos si existe una sesion activa
$sql = 'SELECT items.id as item_id, items.name as item_name, items.price as item_price,  items.quantity as item_quantity, items.status as item_status
            FROM items
    
            WHERE items.id = ?
            AND items.status = 1';
$results = R::getAll($sql, [$_GET['item']]);

//traemos todos los registros de la tabla user_has_roles
//echo json_encode($results);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

</head>

<body>
    <div class="row">
        <div class="col s12 m6">
            <div class="card" style="background-color:#3B4094;">
                <div class="card-content white-text">
                    <span class="card-title">
                        <?php
                        echo $results[0]['item_name'];
                        ?>
                    </span>
                    <p>PRECIO:
                        <?php
                        echo $results[0]['item_price'];
                        ?>
                    </p>
                    <p>CANTIDAD:
                        <?php
                        echo $results[0]['item_quantity'];
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        M.AutoInit();
    </script>
</body>

</html>