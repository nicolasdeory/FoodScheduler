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
            <div class= "titulo"> <p>Planificador Alimenticio</p> </div>
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
    <div class="title">
        <h1>Encontrar Recetas</h1>
    </div>

    <div class="line">
        <hr>
    </div>

    <div class="subtitle">
        <p1>Con estos parámetros, tienes estas recetas disponibles</p1>
    </div>

    <div class="contenedor">
        <div class="search">
            <div class="comida">
                <div class="icon1">
                    <i class="fas fa-utensils"></i>
                </div>
                <input type="text" placeholder="Elige una comida" class="input-text"></input>
            </div>

            <div class="ingrediente">
                <div class="icon2">
                    <i class="fas fa-cheese"></i>
                </div>
                <input type="text" placeholder="Elige un ingrediente" class="input-text"></input>
            </div>


            <div class="dificultad">
                <div class="icon3">
                    <i class="fas fa-user"></i>
                </div>
                

                <div class="texto-dif">
                    <div class="dif">
                        <form>
                            <div class="rating">
                                <input id="star1" name="star" type="radio" value="5" class="radio-btn hide" />
                                <label for="star1"><div class="star"></div></label>
                                <input id="star2" name="star" type="radio" value="4" class="radio-btn hide" />
                                <label for="star2"><div class="star"></div></label>
                                <input id="star3" name="star" type="radio" value="3" class="radio-btn hide" />
                                <label for="star3"><div class="star"></div></label>
                                <input id="star4" name="star" type="radio" value="2" class="radio-btn hide" />
                                <label for="star4"><div class="star"></div></label>
                                <input id="star5" name="star" type="radio" value="1" class="radio-btn hide" />
                                <label for="star5"><div class="star"></div></label>
                                <div class="text" id="rating-label-text">Dificultad</div>
                                <div class="clear"></div>
                            </div>
                        </form>
                    </div>                    
                </div>


            </div>

            <div class="boton">
                <button class="button" type="button">
                    Buscar
                </button>
            </div>
        </div>

        <div class="result">

        </div>

        <div class="result">

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