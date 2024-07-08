<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
header('Content-Type: text/html');

// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {

    $sales = 'SELECT sales.id as sale_id,sales.total as sale_total,sales.updated_at as sale_updated, companies.name as companie_name, companies.image as companie_image
        FROM sales
        LEFT JOIN companies ON sales.company_id = companies.id

        WHERE sales.id = ?';
    $sales = R::getAll($sales, [$_GET['sale']]);

    $items = 'SELECT itemsforsales.price as itemsforsale_price, itemsforsales.quantity as itemsforsale_quantity, items.name as item_name
            FROM itemsforsales
            LEFT JOIN items ON itemsforsales.item_id = items.id
            WHERE itemsforsales.sale_id = ?';
    $items = R::getAll($items, [$_GET['sale']]);
    function formatoFecha($fecha)
    {
        $dia = substr($fecha, 8, 2);
        $mes = substr($fecha, 5, 2);
        $ano = substr($fecha, 0, 4);
        return $dia . '-' . $mes . '-' . $ano;
    }
    function formatoHora($fecha)
    {
        $hora = substr($fecha, 11, 8);
        return $hora;
    }
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
        <style>
            .center {
                display: flex;
                /* align-items: center; */
                justify-content: center
            }

            .between {
                display: flex;
                /* align-items: center; */
                justify-content: space-between;
            }

            .end {
                display: flex;
                justify-content: flex-end
            }

            .negritas {
                font-weight: bolder;
            }
        </style>
    </head>

    <body>
        <div class="container" style="margin-top: 25px;">
            <div class="row">
                <div class="col s12 center">
                    <img class="materialboxed" width="100" src="https://codimet-store.com/images/companies/<?php echo $sales[0]['companie_image'] ?>">
                </div>
                <div class="col s12 center">
                    <h6><?php echo $sales[0]['companie_name'] ?></h6>
                </div>
                <div class="col s12 between">
                    <p class="negritas">No. VENTA:</p>
                    <p><?php echo $sales[0]['sale_id'] ?></p>
                </div>
                <div class="col s12 between">
                    <p class="negritas">FECHA:</p>
                    <p><?php echo formatoFecha($sales[0]['sale_updated']) ?></p>
                </div>
                <div class="col s12 between">
                    <p class="negritas">HORA:</p>
                    <p><?php echo formatoHora($sales[0]['sale_updated']) ?></p>
                </div>
                <div class="col s12">
                    <hr>
                </div>
                <div class="col s7">
                    <p class="negritas">PRODUCTO:</p>
                </div>
                <div class="col s2">
                    <p class="negritas center">PRECIO:</p>
                </div>
                <div class="col s1">
                    <p class="negritas center">CANTIDAD:</p>
                </div>
                <div class="col s2">
                    <p class="negritas center">TOTAL:</p>
                </div>
                <?php
                foreach ($items as $key => $item) {
                ?>
                    <div class="col s7">
                        <p><?php echo $item['item_name'] ?></p>
                    </div>
                    <div class="col s2 end">
                        <p>$</p>
                        <p><?php echo $item['itemsforsale_price'] ?></p>
                    </div>
                    <div class="col s1 end">
                        <p>X</p>
                        <p><?php echo $item['itemsforsale_quantity'] ?></p>
                    </div>
                    <div class="col s2 end">
                        <p>$</p>
                        <p><?php echo ($item['itemsforsale_price'] * $item['itemsforsale_quantity']) ?></p>
                    </div>
                <?php
                }
                ?>
                <div class="col s10 negritas">
                    <p>TOTAL</p>
                </div>
                <div class="col s2 end negritas">
                    <p>$</p>
                    <p><?php echo $sales[0]['sale_total'] ?></p>
                </div>
                <div class="col s12">
                    <hr>
                </div>
                <div class="col s12 center">
                    <p>¡Gracias por su compra! Agradecemos su preferencia. <br> ¡Vuelva pronto!</p>
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




<?php

    //traemos todos los registros de la tabla user_has_roles
    //echo json_encode(['status' => 1,'message' => 'SESION ACTIVA' , 'data' => $sales ]);
} else {
    //echo json_encode(['status' => 0,'message' => 'NO EXISTE SESION' ]);
}
?>