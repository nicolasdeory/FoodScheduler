<?php

include_once("database_service.php");

session_start();

if (!isset($_SESSION['login'])) {
    // Not logged, redirect to login
    header('Location: .');
    http_response_code(403);
    die;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type: application/json");
    if ($_FILES["thumbnail"]["error"] == UPLOAD_ERR_OK) {
        if ($_FILES['thumbnail']['size'] > 8388608) {
            http_response_code(400);
            echo "file is too large";
            die;
        }
        if (
            !isset($_POST['nombre']) || !isset($_POST['dif']) || !isset($_POST['visibility'])
            || !isset($_POST['ingredients']) || !isset($_POST['steps']) || !isset($_POST['tiempo'])
        ) {
            http_response_code(400);
            echo "must specify recipe name, difficulty, visibility, ingredients and steps";
            die;
        }

        $ingredients = json_decode($_POST['ingredients'], true);
        $steps = json_decode($_POST['steps'], true);

        if (!(count($_POST['ingredients']) > 0 && count($_POST['steps']) > 0)) {
            http_response_code(400);
            echo "must specify ingredients and steps";
            die;
        }

        $name = $_POST['nombre'];
        $dif = $_POST['dif'];
        $time = $_POST['tiempo'];
        $visibility = $_POST['visibility'];
        $file = $_FILES["thumbnail"]["tmp_name"];

        $recipeId = create_recipe($_SESSION['login'], $name, $dif, $visibility, $time, $ingredients, $steps);
        if (!$recipeId) {
            http_response_code(400);
            echo "error creating recipe";
            die;
        }
        // now you have access to the file being uploaded
        //perform the upload operation.
        move_uploaded_file($file, "images/photo" . $recipeId . ".jpg");
        echo '"ok"';
        die;
    } else {
        http_response_code(400);
        echo "invalid file";
        die;
    }
}


?>


<div class="schedule-section-container">
    <div class="section-header">
        <div class="header">
            <div class="title">Crear Recetas</div>

            <div class="separator"></div>
        </div>

        <div class="subtitle">
            <p1></p1>
        </div>
    </div>
    <form id="form-recipe" enctype="multipart/form-data">
        <div class="contenedornew" id="contenedor">
            <div class="arriba">
                <div class="nombre">
                    <div class="texto-antes">
                        <p>Elige un nombre para la receta</p>
                    </div>
                    <div class="comidanew">
                        <div class="icon1">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <input type="text" placeholder="Nombre" id="input-nombre" class="input-nombre" required></input>
                    </div>
                    <div class="texto-antes">
                        <p>Dificultad de la receta</p>
                    </div>
                    <div class="dificultadnew">
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
                    <div class="texto-antes">
                        <p>Duración de la receta</p>
                    </div>
                    <div class="comidanew">
                        <div class="icon1">
                            <i class="fas fa-clock"></i>
                        </div>
                        <input type="number" placeholder="Tiempo en minutos" id="input-time" class="input-nombre" required></input>
                    </div>
                </div>
                <div class="addplusicons">
                    <div class="contenedornewingredientes" id="contenedornewingredientes">
                        <div class="ingredientenuevo">

                            <div class="texto-antes">
                                <p>Nuevo ingrediente</p>
                            </div>
                            <div class="ingredientenew">
                                <div class="ing">
                                    <div class="icon2">
                                        <i class="fas fa-cheese"></i>
                                    </div>
                                    <input type="text" placeholder="Nombre" name="input-name" class="input-ing" required></input>
                                </div>
                                <div class="cant">
                                <div class="icon2">
                                <i class="fas fa-balance-scale"></i>
                                    </div>
                                    <input type="number" placeholder="Cantidad" name="input-qty" class="input-ing" required></input>

                                </div>
                                <div class="unid">
                                    <select name="unidadDeMedida" class="unidadmed" id="input-unidad" required>
                                        <option value="Unidad">Unidad</option>
                                        <option value="Gramo">Gramos</option>
                                        <option value="Mililitro">Mililitro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="agregaringrediente">
                        <button class="newing" type="button" id="nuevoing"><span class="material-icons">add_circle_outline</span></button>
                        <button class="lessing" type="button" id="quitaring"><span class="material-icons">remove_circle_outline</span></button>
                    </div>
                </div>
            </div>
            <div class="abajo">
                <div class="abajo-izq">
                    <div class="type">
                        <div class="texto-antes">
                            <p>¿Es pública la receta?</p>
                        </div>
                        <div class="publica">
                            <input class="input-pub" name="visibility" id="public" type="radio" value="1" placeholder="Pública" checked>
                            <label class="input-pub" for="public">Pública</label>
                            <input class="input-pub" name="visibility" id="private" type="radio" value="2" placeholder="Privada">
                            <label class="input-pub" for="private">Privada</label><br>
                        </div>

                        <div class="texto-antes">
                            <p>Miniatura de la receta (Máximo 8MB)</p>
                        </div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="8388608" />
                        <input class="input-pub" name="thumbnail" id="input-thumbnail" type="file" required>
                    </div>
                    <div class="botonnew">
                        <button class="buttonnew button" id="crear-receta">
                            Añadir Receta
                        </button>
                    </div>
                </div>
                <div class="addplusicons">
                    <div class="contenedorpasos" id="contenedorpasos">
                        <div class="paso">
                            <div class="texto-antes">
                                <p>Paso número: 1</p>
                            </div>
                            <textarea class="input-paso" type="text" placeholder="Describe cómo realizar este paso" required></textarea>
                        </div>

                    </div>
                    <div class="agregaringrediente">
                        <button class="newstep" type="button" id="nuevopaso"><span class="material-icons">add_circle_outline</span></button>
                        <button class="lessstep" type="button" id="quitarpaso"><span class="material-icons">remove_circle_outline</span></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="js/createrecipe.js"></script>
    <script src="js/addingredient.js"></script>


</div>