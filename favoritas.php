<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/vistareceta.css">
    <link rel="stylesheet" href="css/busqueda.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://kit.fontawesome.com/85abaff11f.js" crossorigin="anonymous"></script>


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
            <p> Salir </p>
        </div>
    </div>

    <div class="centro">
        <div class="contenidodelaweb">
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
                             Espaguetis a la boloñesa
                        </div>
                        <div class="info">
                            <div class="like">
                                <div class="likeicon"> <span class="material-icons iconocolumna"> favorite </span> </div>
                                <div class="numberlikes"> 276</div>
                            </div>
                            <div class="time">
                                <div class="timeicon"><i class="far fa-clock"></i></div>
                                <div class="amounttime"> 20 min</div>
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
                                       
                                        <div class="text" id="rating-label-text">Facil</div>
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

        <div class="barralateral">
            <div class="elemento elementoactivo"> <span class="material-icons iconocolumna"> date_range </span> </div>
            <div class="elemento"> <span class="material-icons iconocolumna"> restaurant </span> </div>
            <div class="elemento"> <span class="material-icons iconocolumna"> favorite </span> </div>
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