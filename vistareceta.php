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

if (!isset($_GET['id']) || !is_numeric($_GET['id']))
{
    http_response_code(400);
    echo "must specify valid recipe id";
    die;
}

$recetaId = $_GET['id'];
$receta =  view_recipe($recetaId);
$ingredientes =  view_ingredients($recetaId);
$pasos = view_pasos($recetaId);

?> 
    <div class="barra-superior">
        <span class="material-icons" id="back-button"> keyboard_backspace </span>
        <div class="titulo-receta"> <?php echo $receta['NOMBRE'] ?> </div>
    </div>
    <div class="barra-like">
        <span class="material-icons corazon"> favorite </span>
        <p class="texto-like"> <?php echo $receta['POPULARIDAD']?> </p>
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
                        <p class="tiempo-receta"> <?php echo $receta['TIEMPOELABORACION'] ?> minutos </p>
                    </div>
                    <div class="tiempo-dificultad-elem">
                        <p class="tiempo-receta"> <?php echo $receta['DIFICULTAD']?> &nbsp;</p>
                        <span class="material-icons"> grade </span>
                        <span class="material-icons"> grade </span>
                        <span class="material-icons"> star_border </span>
                        <span class="material-icons"> star_border </span>
                        <span class="material-icons"> star_border </span>
                    </div>
                </div>
                <div class="ingredientes">
                    <p class="titulo-seccion"> Ingredientes </p>
                    <p class="elemento-seccion"> 
                        <?php 
                        foreach ($ingredientes as $ingrediente) { ?>
                            <p> <?php echo $ingrediente['NOMBRE']; ?>,&nbsp;
                                <?php echo $ingrediente['CANTIDAD']; ?>
                                <?php echo $ingrediente['UNIDADDEMEDIDA']; ?> 
                            </p>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="columna-derecha">
            <p class="titulo-seccion"> Procedimiento </p>
            <p>
                <?php 
                    foreach ($pasos as $paso) { ?>
                        <p> <?php echo $paso['DESCRIPCION']; ?>.&nbsp;
                        </p>
                <?php } ?> 
            </p>
        </div>

    </div>
    <script src="js/recipe.js"></script>