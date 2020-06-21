<?php

include_once("database_service.php");

if (isset($API_USER_LOGIN))
{
    $_SESSION['login'] = $API_USER_LOGIN;
}
else 
{
    session_start();

    if (!isset($_SESSION['login'])) 
    {
        // Not logged, redirect to login
        header('Location: .');
        http_response_code(403);
        die;
    }
    
}

if ((!isset($_GET['name']) && !isset($_GET['id'])) || !isset($_GET['qty']) || !isset($_GET['qty-type']))
{
    http_response_code(400);
    echo "must specify name or id, qty and qty type";
    die;
}

if (!isset($_GET['type']) || ($_GET['type'] != "fridge" && $_GET['type'] != "shoppinglist"))
{
    echo "type must be fridge or shoppinglist";
    die;
}

if (isset($_GET['id']))
{
    $id_ingred = $_GET['id'];
}
else 
{
    $name_ingred = $_GET['name'];
}

$ingred_qty = $_GET['qty'];
$qty_type = $_GET['qty-type'];

if ($_GET['type'] == "fridge") 
{

    if (isset($id_ingred))
    {
        if (add_to_fridge_id($_SESSION['login'], $id_ingred, $ingred_qty, $qty_type, !isset($_GET['edit']))) {
            echo "ok";
        }
        else
        {
            http_response_code(400);
            echo "error adding";
        }
    }
    else 
    {
        if (add_to_fridge($_SESSION['login'], $name_ingred, $ingred_qty, $qty_type, !isset($_GET['edit']))) {
            echo "ok";
        }
        else
        {
            http_response_code(400);
            echo "error adding";
        }
    }
    
}
else 
{
    if (isset($id_ingred))
    {
        if (add_to_shopping_list_id($_SESSION['login'], $id_ingred, $ingred_qty, $qty_type, !isset($_GET['edit']))) {
            echo "ok";
        }
        else
        {
            http_response_code(400);
            echo "error adding";
        }
    }
    else 
    {
        if (add_to_shopping_list($_SESSION['login'], $name_ingred, $ingred_qty, $qty_type, !isset($_GET['edit']))) {
            echo "ok";
        }
        else
        {
            http_response_code(400);
            echo "error adding";
        }
    }
    
}


?>