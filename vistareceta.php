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

if (!isset($_GET['recipeID']))
{
    http_response_code(400);
    echo "must specify recipe Id";
    die;
}

$recetaId = $_GET['id'];
$receta =  view_recipe($recetaId);
?>

<div class="barra-superior">
    <span class="material-icons"> keyboard_backspace </span>
    <div class="titulo-receta"> <?php echo $receta['NOMBRE'] ?> </div>
</div>
<div class="barra-like">
    <span class="material-icons corazon"> favorite </span>
    <p class="texto-like"> <?php echo $receta['POPULARIDAD']?> </p>
    <div class="titulo-receta"> Espaguetis a la boloñesa </div>
</div>
<div class="barra-like">
    <span class="material-icons corazon"> favorite </span>
    <p class="texto-like"> 273 </p>
</div>
<div class="columnas">

    <div class="columna-izquierda">
        <div class="contenido-columna-izquierda">
            <div class="foto">
                <figure>
                    <img src="prueba/espaguetis.jpg" class="foto">
                </figure>
            </div>
            <div class="tiempo-dificultad">
                <div class="tiempo-dificultad-elem">
                    <span class="material-icons"> query_builder </span>
                    <p class="tiempo-receta"> <?php echo $receta['TIEMPOELABORACION'] ?> </p>
                </div>
                <div class="tiempo-dificultad-elem">
                    <p class="tiempo-receta"> Fácil </p>
                    <span class="material-icons"> grade </span>
                    <span class="material-icons"> grade </span>
                    <span class="material-icons"> star_border </span>
                    <span class="material-icons"> star_border </span>
                    <span class="material-icons"> star_border </span>
                </div>
            </div>
            <div class="ingredientes">
                <p class="titulo-seccion"> Ingredientes </p>
                <p class="elemento-seccion"> 500gr. de espaguetis </p>
                <p class="elemento-seccion"> 175 gr. de carne picada de ternera </p>
                <p class="elemento-seccion"> 175 gr. de carne picada de cerdo </p>
                <p class="elemento-seccion"> 1 cebolla y 1 diente de ajo </p>
                <p class="elemento-seccion"> 2 zanahorias </p>
                <p class="elemento-seccion"> 700 gr. de tomates </p>
                <p class="elemento-seccion"> Aceite de oliva </p>
                <p class="elemento-seccion"> Orégano </p>
            </div>
        </div>
    </div>

    <div class="columna-derecha">
        <p class="titulo-seccion"> Procedimiento </p>
        <p> texto del cuerpo de la receta </p>
    </div>

</div>