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

if (!isset($_GET['from']) || !isset($_GET['to']))
{
    http_response_code(400);
    echo "must specify date range";
    die;
}

$from = $_GET['from'];
$to = $_GET['to'];

$fromD = date_create($from);
$toD = date_create($to);
//$from = strtotime($from);
//$to = strtotime($to);

$fromFormatted = str_replace("-","/",$from);
$toFormatted = str_replace("-","/",$to);

$planificaciones = retrieve_schedule($_SESSION['login'], $fromFormatted, $toFormatted);

if (count($planificaciones) < 14)
{
    $oneDay = new DateInterval("P1D");
    $dateI = $fromD;
    for ($i=0; $i < 14; $i++) { 
        date_add($dateI, $oneDay);
        $dateIFormatted = date_format($dateI, "d/m/Y");
        //echo $dateIFormatted;
        create_schedule($_SESSION['login'], $dateIFormatted, "Almuerzo");
        create_schedule($_SESSION['login'], $dateIFormatted, "Cena");
    }
    $planificaciones = retrieve_schedule($_SESSION['login'], $from, $to);
}

header("Content-Type: application/json");
if ($planificaciones == false)
{
    echo "[]";
} else 
{
    echo json_encode($planificaciones);
}


// TODO: If week is empty, create!


?>