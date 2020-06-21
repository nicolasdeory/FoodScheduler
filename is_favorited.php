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


if (!isset($_GET['id']))
{
    http_response_code(400);
    echo "must specify id";
    die;
}
$username = $_SESSION['login'];
$recpId = $_GET['id'];

$res = is_favorited($username, $recpId);

if ($res)
{
    echo "true";
}
else 
{
    echo "false";
}

?>