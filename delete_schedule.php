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

if (!isset($_GET['date']) || !isset($_GET['meal']))
{
    http_response_code(400);
    echo "must specify id and date";
    die;
}

$date = $_GET['date'];
$meal = $_GET['meal'];

$schd_date = str_replace("-","/",$date);

if (delete_schedule($_SESSION['login'], $schd_date, $meal)) {
    echo "ok";
}
else
{
    http_response_code(400);
    echo "error deleting";
}


?>