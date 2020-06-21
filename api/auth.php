<?php

    include("../database_service.php");
    $headers = apache_request_headers();

    if (!isset($headers['Authorization']))
    {
        http_response_code(401);
        die;
    }

    $auth = $headers['Authorization'];
    $base64string = substr($auth,6,strlen($auth)-1);

    $authUserPass = base64_decode($base64string);
    $authSplit = explode(":", $authUserPass);
    //echo $base64string;
    $usuario['user'] = $authSplit[0];
    $usuario['pass'] = $authSplit[1];
    if (!user_login($usuario))
    {
        http_response_code(401);
        echo "{err:'wrong password'}";
        die;
    }
    $API_USER_LOGIN = $usuario['user'];
?>