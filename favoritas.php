<?php

include_once("database_service.php");

session_start();

if (!isset($_SESSION['login'])) {
    // Not logged, redirect to login
    header('Location: .');
    http_response_code(403);
    die;
}

$userId = $_SESSION['login'];
$saved =  view_saved($userId);

?>

<div class="schedule-section-container">
    <div class="section-header">
        <div class="header">
            <div class="title">Recetas guardadas</div>
        </div>
        <div class="separator"></div>
    </div>
    <div class="subtitle margin">
        <p1>Tus recetas guardadas se mostrarán en esta sección.</p1>
    </div>
    <div class="contenedor">
        <?php foreach ($saved as $receta) { ?>
            <div class="result">
                <div class="photo">
                    <img class="spaguetti" src="images/photo<?php echo $receta['ID_RECETA'] ?>.jpg">
                </div>
                <div class="description">
                    <div class="recipetitle">
                        <?php echo $receta['NOMBRE']; ?>
                    </div>
                    <div class="info">
                        <div class="like">
                            <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                            <div class="numberlikes"> <?php echo $receta['POPULARIDAD']; ?> </div>
                        </div>
                        <div class="time">
                            <div class="timeicon"><i class="far fa-clock"></i></div>
                            <div class="amounttime"> <?php echo $receta['TIEMPOELABORACION']; ?> min </div>
                        </div>
                        <div class="difficulty">
                            <div class="texto-dif">
                                <div class="dif">
                                    <div class="rating">

                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>

                                        <div class="text" id="rating-label-text"> <?php echo $receta['DIFICULTAD']; ?> </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>