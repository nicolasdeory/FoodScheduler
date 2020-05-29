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

$id_ingred = $_GET['id'];
if (delete_shopping($_SESSION['login'], $id_ingred)) {
    echo "ok";
}
else
{
    http_response_code(500);
    echo "error deleting";
}

?>