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

<link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
<!--Párrafo-->
        <h2>Mi cuenta</h2>

<!--Menú de navegación-->
<div class="navegacion">
    <div class="menu">
        <div class="izquierda">
          <div class="burger"> <span class="material-icons toggle">menu</span></div>
          <div class= "titulo"> <p>Planificador Alimenticio</p> </div>
        </div>
        <div class="partederechamenu">
            <span class="material-icons campanades">notifications</span>
            <p> Hola, Nicolas </p>
            <p> Mi cuenta </p>
            <p> Salir </p>
        </div>
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