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

<div class="text">
    <div class="title">
        <h1>Recetas favoritas</h1>
    </div>

    <div class="line">
        <hr>
    </div>

    <div class="subtitle">
        <p1>Tienes estas recetas guardadas</p1>
    </div>
</div>
<div class="contenedor">


    <div class="result">
        <div class="photo">
            <img class="spaguetti" src="images/photo1.jpg">
        </div>
        <div class="description">
            <div class="recipetitle">
                <?php echo $saved[0]['NOMBRE'] ?>
            </div>
            <div class="info">
                <div class="like">
                    <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                    <div class="numberlikes"> <?php echo $saved[0]['POPULARIDAD'] ?> </div>
                </div>
                <div class="time">
                    <div class="timeicon"><i class="far fa-clock"></i></div>
                    <div class="amounttime"> <?php echo $saved[0]['TIEMPOELABORACION'] ?> </div>
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

                                <div class="text" id="rating-label-text">  <?php echo $saved[0]['DIFICULTAD'] ?> </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="result">

    </div>

    <div class="result">
        <div class="photo">
        </div>
        <div class="description">
            <div class="recipetitle">
            </div>
            <div class="info">
                <div class="like"></div>
                <div class="time"></div>
                <div class="difficulty"></div>
            </div>
        </div>
    </div>

    <div class="result">

    </div>

    <div class="result">

    </div>

    <div class="result">

    </div>


</div>

</div>