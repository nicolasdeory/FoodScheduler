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

?>

        <div class="contenidodelaweb">
            <div class="text">

                <div class="title">
                    <h1>Encontrar Recetas</h1>
                </div>

                <div class="line">
                    <hr>
                </div>

                <div class="subtitle">
                    <p1>Con estos parámetros, tienes estas recetas disponibles</p1>
                </div>
            </div>
            <div class="contenedor" id="contenedor">
                <div class="search">
                    <div class="comida">
                        <div class="icon1">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <input type="text" placeholder="Elige una comida" id="input-nombre" class="input-text"></input>
                    </div>

                    <div class="ingrediente">
                        <div class="icon2">
                            <i class="fas fa-cheese"></i>
                        </div>
                        <input type="text" placeholder="Elige un ingrediente" id="input-ingrediente" class="input-text"></input>
                    </div>


                    <div class="dificultad">
                        <div class="icon3">
                            <i class="fas fa-user"></i>
                        </div>


                        <div class="texto-dif">
                            <div class="dif">
                                <form>
                                    <div class="rating">
                                        <input id="star5" name="star" type="radio" value="5" class="radio-btn hide" />
                                        <label for="star5">
                                            <div class="star"></div>
                                        </label>
                                        <input id="star4" name="star" type="radio" value="4" class="radio-btn hide" />
                                        <label for="star4">
                                            <div class="star"></div>
                                        </label>
                                        <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                                        <label for="star3">
                                            <div class="star"></div>
                                        </label>
                                        <input id="star2" name="star" type="radio" value="2" class="radio-btn hide" />
                                        <label for="star2">
                                            <div class="star"></div>
                                        </label>
                                        <input id="star1" name="star" type="radio" value="1" class="radio-btn hide" />
                                        <label for="star1">
                                            <div class="star"></div>
                                        </label>
                                        <div class="text" id="rating-label-text">Dificultad</div>
                                        <div class="clear"></div>
                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>

                    <div class="boton">
                        <button class="button" type="button" id="buscar">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <script src="busqueda.js"></script>
