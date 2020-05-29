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
    $recetas = search_all_recipes();

}else if (!isset($_GET['nombre']) && !isset($_GET['ingrediente'])) { //BUSCA SOLO dificultad
   
    $dificultad = $_GET['dificultad'];
    $recetas = search_recipes_d( $dificultad);

} else if (!isset($_GET['ingrediente']) && !isset($_GET['dificultad'])) { //BUSCA SOLO comida(NOMBRE)
    
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_c($nombre);


} else if (!isset($_GET['nombre']) && !isset($_GET['dificultad'])) { //BUSCA SOLO ingrediente
    
    $ingrediente = $_GET['ingrediente'];
    $recetas = search_recipes_i(get_ingredientid($ingrediente));


} else if (!isset($_GET['ingrediente'])){ 
    $dificultad = $_GET['dificultad'];
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_cd($nombre, $dificultad);

} else if (!isset($_GET['nombre'])) {

    $dificultad = $_GET['dificultad'];
    $ingrediente = $_GET['ingrediente'];
    $recetas = search_recipes_id(get_ingredientid($ingrediente), $dificultad);

} else if (!isset($_GET['dificultad'])) {
    
    $ingrediente = $_GET['ingrediente'];
    $nombre = $_GET['nombre'];
    $recetas = search_recipes_ci($nombre, get_ingredientid($ingrediente));

} else {
    $ingrediente = $_GET['ingrediente'];
    $dificultad = $_GET['dificultad'];
    $nombre = $_GET['nombre'];

    $recetas = search_recipes(get_ingredientid($ingrediente), $nombre, $dificultad);
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