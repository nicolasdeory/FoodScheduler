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

$username = $_SESSION['login'];

if (!isset($_GET['ingrediente']) && !isset($_GET['dificultad']) && !isset($_GET['nombre']))
{
    $recetas = search_all_recipes($username);

}else if (!isset($_GET['nombre']) && !isset($_GET['ingrediente'])) { //BUSCA SOLO dificultad
   
    $dificultad = $_GET['dificultad'];
    $recetas = search_recipes_d($username, $dificultad);

} else if (!isset($_GET['ingrediente']) && !isset($_GET['dificultad'])) { //BUSCA SOLO comida(NOMBRE)
    
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_c($username, $nombre);


} else if (!isset($_GET['nombre']) && !isset($_GET['dificultad'])) { //BUSCA SOLO ingrediente
    
    $ingrediente = $_GET['ingrediente'];
    $recetas = search_recipes_i($username, get_ingredientid($ingrediente));


} else if (!isset($_GET['ingrediente'])){ 
    $dificultad = $_GET['dificultad'];
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_cd($username, $nombre, $dificultad);

} else if (!isset($_GET['nombre'])) {

    $dificultad = $_GET['dificultad'];
    $ingrediente = $_GET['ingrediente'];
    $recetas = search_recipes_id($username, get_ingredientid($ingrediente), $dificultad);

} else if (!isset($_GET['dificultad'])) {
    
    $ingrediente = $_GET['ingrediente'];
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_ci($username, $nombre, get_ingredientid($ingrediente));

} else {
    $ingrediente = $_GET['ingrediente'];
    $dificultad = $_GET['dificultad'];
    $nombre = $_GET['nombre'];

    $recetas = search_recipes($username, get_ingredientid($ingrediente), $nombre, $dificultad);
}



header("Content-Type: application/json");
if ($recetas == false)
{
    echo "[]";
} else 
{
    echo json_encode($recetas);
}
?>