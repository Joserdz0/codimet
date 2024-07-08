<?php
//listamos todos los items
//incluimos el archivo db.php encontrado en la carpeta api
require '../db.php';
// verificamos si existe una sesion activa
if (isset($_SESSION['name'])) {
    //guardamos los campos nombre, valor, id
    $canasta = json_decode($_POST['canasta']);
    $total = $_POST['sumaTotal'];
    $sale = R::dispense('sales');
    $sale->company_id = $_SESSION['company_id'];
    $sale->user_id = $_SESSION['id'];
    $sale->total = $total;
    $sale->status = 1;

    $venta = R::store($sale);
    foreach ($canasta as $key => $value) {
        $item = R::load( 'items',  $value->id ); //reloads our book

        $itemsforsale = R::dispense('itemsforsales');
        $itemsforsale->sale_id = $venta;
        $itemsforsale->item_id = $value->id;
        

        $itemsforsale->price = $item->price;

        $itemsforsale->quantity = $value->cantidad;
        //falta
        $itemsforsale->total = $value->cantidad * $item->price;
        $itemsforsale->status = 1;
        $id = R::store($itemsforsale);
        //Aqui reducimos los la cantidad de los items
        //$itemModif = R::dispense('items');
        $item->quantity =  $item->quantity - $value->cantidad;
        $id = R::store($item);



//
    } 


    echo json_encode(['status' => 1, 'message' => 'CREADO CORRECTAMENTE', 'data' => $canasta]);
} else {
    echo json_encode(['status' => 0, 'message' => 'NO EXISTE SESION']);
}
