<?php

include_once("database_service.php");

session_start();

if (!isset($_SESSION['user'])) 
{
    // Not logged, redirect to login
    header('Location: .');
    http_response_code(403);
    die;
}

$from = $_GET['from'];
$to = $_GET['to'];
if (!isset($from) || !isset($to))
{
    http_response_code(400);
    echo "must specify date range";
    die;
}

$from = strtotime($from);
$to = strtotime($to);

$planificaciones = retrieve_schedule($_SESSION['user'], $from, $to);

if (count($planificaciones) < 14)
{
    $oneDay = new DateInterval("P1D");
    $dateI = $from;
    for ($i=0; $i < 14; $i++) { 
        date_add($oneDay, $dateI);
        create_schedule($_SESSION['user'], $dateI, "Almuerzo");
        create_schedule($_SESSION['user'], $dateI, "Cena");
    }
}

// TODO: If week is empty, create!


?>