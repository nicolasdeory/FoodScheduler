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
    $qtyInShopping = get_quantity_in_shopping($_SESSION['login'], $ingred['ID_INGREDIENTE']);
    if ($qtyInFridge == false || $qtyInFridge < $ingred['CANTIDAD'])
    {
        if ($qtyInShopping == false || $qtyInShopping < ($ingred['CANTIDAD'] - $qtyInFridge))
        {
            $neededIngred = $ingred['CANTIDAD'] - $qtyInFridge;
            if ($qtyInShopping && $qtyInShopping > 0)
            {
                $toAddToShopping = $neededIngred - $qtyInShopping;
            }
            else 
            {
                $toAddToShopping = $neededIngred;
            }
            $ingred['CANTIDAD'] = $toAddToShopping;
            array_push($missingIngreds, $ingred);
        }
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