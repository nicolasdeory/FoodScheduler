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

if (!isset($_GET['id']))
{
    http_response_code(400);
    echo "must specify id";
    die;
}

if (!isset($_GET['type']) || $_GET['type'] != "fridge" || $_GET['type'] != "shoppinglist")
{
    echo "type must be fridge or shoppinglist";
    die;
}

$id_ingred = $_GET['id'];

if ($_GET['type'] == "fridge")
{
    if (delete_fridge($_SESSION['login'], $id_ingred)) {
        echo "ok";
    }
    else
    {
        http_response_code(400);
        echo "error deleting";
    }
}
else 
{
    if (delete_shopping($_SESSION['login'], $id_ingred)) {
        echo "ok";
    }
    else
    {
        http_response_code(400);
        echo "error deleting";
    }
}




?>