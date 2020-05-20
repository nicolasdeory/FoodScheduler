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

$neededIngredients = get_needed_ingredients($_SESSION['login']);

$missingIngreds = [];
foreach ($neededIngredients as $ingred) {
    $qtyInFridge = get_quantity_in_fridge($_SESSION['login'], $ingred['ID_INGREDIENTE']);
    if ($qtyInFridge == false || $qtyInFridge['CANTIDAD'] < $ingred['CANTIDAD'])
    {
        $ingred['CANTIDAD'] = $ingred['CANTIDAD'] - $qtyInFridge['CANTIDAD'];
        array_push($missingIngreds, $ingred);
    }
}

header("Content-Type: application/json");
if ($missingIngreds == false)
{
    echo "[]";
} else 
{
    echo json_encode($missingIngreds);
}

?>