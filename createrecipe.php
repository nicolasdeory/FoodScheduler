<?php

include_once("database_service.php");

session_start();

if (!isset($_SESSION['login'])) {
    // Not logged, redirect to login
    header('Location: .');
    http_response_code(403);
    die;
}

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/vistareceta.css">
    <link rel="stylesheet" type="text/css" href="css/schedule.css">
    <link rel="stylesheet" type="text/css" href="css/createrecipe.css">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Muli:400,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2797f66cfb.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>

<body>

    <div class="menu">
        <div class="izquierda">
            <div class="burger"> <span class="material-icons toggle">menu</span></div>
            <div class="derechatitulo">
                <div class="titulo">
                    <p>Planificador Alimenticio</p>
                </div>
                <div class="espacio"> </div>
                <span class="material-icons campana">notifications</span>
            </div>
        </div>
        <div class="partederechamenu">
            <p> Hola, Nicolas </p>
            <p> Mi cuenta </p>
            <p><a href="logout.php">Salir</a></p>
        </div>
    </div>

    <div class="centro">

        <div class="contenidodelaweb">
            <div class="text">

                <div class="title">
                    <h1>Crear Recetas</h1>
                </div>

                <div class="line">
                    <hr>
                </div>

                <div class="subtitle">
                    <p1></p1>
                </div>
            </div>

            <div class="contenedor" id="contenedor">
                <div class="nombre">
                    <div class="texto-antes">
                        <p>Elige un nombre para la receta</p>
                    </div>
                    <div class="comida">
                        <div class="icon1">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <input type="text" placeholder="" id="input-nombre" class="input-text"></input>
                    </div>



                    <div class="texto-antes">
                        <p>Dificultad de la receta</p>
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
                    <div class="publica">
                        <p>¿Es pública la receta?</p>
                    </div>
                </div>
                <div class="contenedoringredientes">
                    <div class="ingredientenuevo">

                        <div class="texto-antes">
                            <p>Introduce los ingredientes que componen la receta</p>
                        </div>
                        <div class="ingrediente">
                            <div class="ing">
                                <div class="icon2">
                                    <i class="fas fa-cheese"></i>
                                </div>
                                <input type="text" placeholder="" id="input-ingrediente" class="input-ing"></input>
                            </div>
                            <input type="number" placeholder="Cantidad" id="input-ingrediente" class="input-ing"></input>

                            <select name="unidadDeMedida">
                                <option value="Unidad">Unidad</option>
                                <option value="Gramo">Gramos</option>
                                <option value="Mililitro">Mililitro</option>


                            </select>

                        </div>
                    </div>
                </div>



            </div>
            <div class="boton">
                <button class="button" type="button" id="buscar">
                    Añadir Receta
                </button>
            </div>
        </div>

        <div id="page-loader"><span class="material-icons big loading-anim"> restaurant </span></div>

        <div class="barralateral">
            <div class="elemento elementoactivo" id="schedule-button"> <span class="material-icons iconocolumna"> date_range </span> </div>
            <div class="elemento" id="restaurant-button"> <span class="material-icons iconocolumna"> restaurant </span> </div>
            <div class="elemento" id="favorite-button"> <span class="material-icons iconocolumna"> favorite </span> </div>
            <div class="espaciodeabajo"> </div>
        </div>

    </div>

    <script>
        let menu = document.querySelector('.toggle')
        menu.addEventListener('click', (e) => {
            document.querySelector('.partederechamenu').classList.toggle('active');
            document.querySelector('.navegacion').classList.toggle('activenav');
        });
    </script>

</body>

</html>