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

if (!isset($_POST['id']) || !isset($_POST['date']) || !isset($_POST['meal']))
{
    http_response_code(400);
    echo "must specify id, date and meal";
    die;
}

$recp_id = $_POST['id'];
$recpD = $_POST['date'];
$recp_date = str_replace("-","/",$recpD);

$recp_meal = $_POST['meal'];

$result = add_schedule($_SESSION['login'], $recp_id, $recp_date, $recp_meal);
if ($result == "ok")
{
    echo "ok";
}
else if ($result == "already exists")
{
    http_response_code(400);
    echo "already exists";
}
else 
{
    http_response_code(400);
    echo "error adding";
}

?>