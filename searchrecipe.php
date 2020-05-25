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

if (!isset($_GET['ingrediente']) && !isset($_GET['dificultad']) && !isset($_GET['nombre']))
{
    http_response_code(400);
    echo "must specify parameters.";
    die;
}

$ingrediente = $_GET['ingrediente'];
$dificultad = $_GET['dificultad'];
$nombre = $_GET['nombre'];

$recetas = view_recipes($ingrediente, $nombre, $dificultad);


header("Content-Type: application/json");
if ($recetas == false)
{
    echo "[]";
} else 
{
    echo json_encode($recetas);
}
?>