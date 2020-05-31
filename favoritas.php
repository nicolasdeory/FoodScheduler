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
$userOwned = get_user_recipes($userId);

$allRecipes = array_merge($saved, $userOwned);

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
        <?php foreach ($allRecipes as $receta) { ?>
            <div class="result" recipe-id="<?php echo $receta['ID_RECETA']; ?>">
                <div class="recipe-container">
                    <div class="photo">
                        <img class="spaguetti" src="images/photo<?php echo $receta['ID_RECETA'] ?>.jpg">
                    </div>
                    <div class="description">
                        <div class="recipe-title-container">
                            <div class="recipetitle"><?php echo $receta['NOMBRE']; ?></div>
                            <div class="add-schd-btn"><i class="far fa-calendar-plus"></i></div>
                        </div>

                        <div class="info">
                            <div class="like">
                                <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                                <div class="numberlikes"> <?php echo $receta['POPULARIDAD']; ?> </div>
                            </div>
                            <div class="time">
                                <div class="timeicon"><i class="far fa-clock"></i></div>
                                <div class="amounttime"> <?php echo $receta['TIEMPOELABORACION']; ?> min.</div>
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
                <div class="add-to-schedule-prompt">
                    <form>
                        <span class="material-icons btn-schd-close">close</span>
                        <h2>Añadir a planificación</h2>
                        <div class="btn-date">Fecha</div>
                        <input type="date" name="schd-date" required></input>
                        <div class="btn-date">
                            <input type="radio" name="schd-meal" value="Almuerzo" required>
                            <label for="schd-mean-comida">Almuerzo</label>
                            <input type="radio" name="schd-meal" value="Cena" required>
                            <label for="schd-mean-cena">Cena</label>
                        </div>
                        <div class="boton add-to-schd-submit">
                            <button class="button">Añadir</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script>
    window.attachEventsToRecipeCards();
</script>