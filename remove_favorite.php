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
$username = $_SESSION['login'];
$recpId = $_GET['id'];

$res = remove_favorite($username, $recpId);

if ($res)
{
    echo "ok";
}
else 
{
    http_response_code(400);
    echo "error removing favorite";
}

?>