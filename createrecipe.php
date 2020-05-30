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
    $nombre = $_POST['input-nombre'];
    $ingrediente = $_POST['input-ingrediente'];

    $receta['nombre'] = $nombre;
    $receta['ingrediente'] = $ingrediente;

    if (user_login($usuario)) {
        $_SESSION['login'] = $user;
        echo "success";
    } else {
        echo "wrong pass";
        http_response_code(401);
    }
    die;
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
    <form action="" method="post" name="formLogin" id="form-recipe">
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
                        <input type="text" placeholder="Nombre" id="input-nombre" class="input-nombre"></input>
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
                        <p>¿Es pública la receta?</p>
                    </div>
                    <div class="publica">
                        <form action="">
                            <input class="input-pub" name="type" id="public" type="radio" value="1" placeholder="Pública" checked>
                            <label class="input-pub" for="public">Pública</label>
                            <input class="input-pub" name="type" id="private" type="radio" value="2" placeholder="Privada">
                            <label class="input-pub" for="public">Privada</label><br>

                        </form>




                    </div>
                </div>
                <div class="addplusicons">
                    <div class="contenedornewingredientes" id="contenedornewingredientes">
                        <div class="ingredientenuevo">

                            <div class="texto-antes">
                                <p>Nuevo ingrediente </p>
                            </div>
                            <div class="ingredientenew">
                                <div class="ing">
                                    <div class="icon2">
                                        <i class="fas fa-cheese"></i>
                                    </div>
                                    <input type="text" placeholder="Nombre" id="input-ingrediente" class="input-ing"></input>
                                </div>
                                <div class="cant">
                                    <input type="number" placeholder="Cantidad" id="input-ingrediente" class="input-ing"></input>

                                </div>
                                <div class="unid">


                                    <select name="unidadDeMedida" class="unidadmed">
                                        <option value="Unidad">Unidad</option>
                                        <option value="Gramo">Gramos</option>
                                        <option value="Mililitro">Mililitro</option>


                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 
                <div class="ingredientenuevo">

                    <div class="texto-antes">
                        <p>Nuevo ingrediente</p>
                    </div>
                    <div class="ingredientenew">
                        <div class="ing">
                            <div class="icon2">
                                <i class="fas fa-cheese"></i>
                            </div>
                            <input type="text" placeholder="Nombre" id="input-ingrediente" class="input-ing"></input>
                        </div>
                        <div class="cant">
                            <input type="number" placeholder="Cantidad" id="input-ingrediente" class="input-ing"></input>

                        </div>
                        <div class="unid">


                            <select name="unidadDeMedida" class="unidadmed">
                                <option value="Unidad">Unidad</option>
                                <option value="Gramo">Gramos</option>
                                <option value="Mililitro">Mililitro</option>


                            </select>
                        </div>
                    </div>
                </div>

                <div class="ingredientenuevo">

                    <div class="texto-antes">
                        <p>Nuevo ingrediente</p>
                    </div>
                    <div class="ingredientenew">
                        <div class="ing">
                            <div class="icon2">
                                <i class="fas fa-cheese"></i>
                            </div>
                            <input type="text" placeholder="Nombre" id="input-ingrediente" class="input-ing"></input>
                        </div>
                        <div class="cant">
                            <input type="number" placeholder="Cantidad" id="input-ingrediente" class="input-ing"></input>

                        </div>
                        <div class="unid">


                            <select name="unidadDeMedida" class="unidadmed">
                                <option value="Unidad">Unidad</option>
                                <option value="Gramo">Gramos</option>
                                <option value="Mililitro">Mililitro</option>


                            </select>
                        </div>
                    </div>
                </div>

                <div class="ingredientenuevo">

                    <div class="texto-antes">
                        <p>Nuevo ingrediente</p>
                    </div>
                    <div class="ingredientenew">
                        <div class="ing">
                            <div class="icon2">
                                <i class="fas fa-cheese"></i>
                            </div>
                            <input type="text" placeholder="Nombre" id="input-ingrediente" class="input-ing"></input>
                        </div>
                        <div class="cant">
                            <input type="number" placeholder="Cantidad" id="input-ingrediente" class="input-ing"></input>

                        </div>
                        <div class="unid">


                            <select name="unidadDeMedida" class="unidadmed">
                                <option value="Unidad">Unidad</option>
                                <option value="Gramo">Gramos</option>
                                <option value="Mililitro">Mililitro</option>


                            </select>
                        </div>
                    </div>
                </div> -->
                    </div>
                    <div class="agregaringrediente">
                        <button class="newing" type="button" id="nuevoing"><span class="material-icons">add_circle_outline</span></button>
                        <button class="lessing" type="button" id="quitaring"><span class="material-icons">remove_circle_outline</span></button>
                    </div>
                </div>
            </div>

            <div class="abajo">
                <div class="botonnew">
                    <button class="buttonnew" type="button" id="buscar">
                        Añadir Receta
                    </button>
                </div>

                <div class="addplusicons">
                <div class="contenedorpasos" id="contenedorpasos">
                    <div class="paso">
                        <div class="texto-antes">
                            <p>Paso número: _</p>
                        </div>
                        <input class="input-paso" type="text" placeholder="Describe cómo realizar este paso">
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