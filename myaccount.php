<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--Nombre de la pestaña-->   
    <title>Mi Cuenta</title>
<!--Link de la Fuente para las letras pequeñas-->    
    <link href="https://fonts.googleapis.com/css2?family=Muli&display=swap" rel="stylesheet">

<!--Link de la Fuente para el Título--> 
    <link href="https://www.fontspring.com/fonts/horizon-type/acherus-grotesque" rel="stylesheet">

<!--Link al archivo css-->   
    <link rel="stylesheet" href="assets/css/myaccountstyle.css" type="text/css">

<!--Link de la Fuente para las letras del menú de navegación-->
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
<!--Párrafo-->
    
        <div class="miCuentaTit">
            <h2>Mi cuenta</h2>
        </div> 
        <div class="linea"></div>
    

<!--Menú de navegación-->
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
        <!--Datos de mi cuenta(Temporal)-->
            <div class="rectangulo">
            <script src="https://kit.fontawesome.com/a076d05399.js"></script>
            <i class="fas fa-user" style="color:#563514"></i>
            <div class="datosText">
                <h3>Nombre de Usuario: NicoDeOry</h3>
                <h3>Email: nicolasdeory@gmail.com</h3>
                <h3>Nombre Completo: Nicolás De Ory Carmona</h3>
                <h3>Teléfono: 673245312</h3>
            </div>



    </div>
    <div class="contenidodelaweb"> 
        
    
    </div>
<!--Barra lateral--> 
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