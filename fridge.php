<?php

include_once("database_service.php");

session_start();

if (!isset($_SESSION['login'])) 
{
    // Not logged, redirect to login
    header('Location: .');
    http_response_code(403);
    die;
}

$nevera = get_fridge($_SESSION['login']);
$listaCompra = get_shopping_list($_SESSION['login']);

$all = new stdClass();
$all->nevera = $nevera;
$all->listaCompra = $listaCompra;

header("Content-Type: application/json");
echo json_encode($all);

?>