<?php
	session_start();

  /*if (!isset($_SESSION['login']))
	{
		// Not logged, redirect to login
		header('Location: .');
		die;
  }*/
  
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/vistareceta.css">
  <link rel="stylesheet" type="text/css" href="css/schedule.css">
  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli:400,700,800,900&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script src="https://kit.fontawesome.com/2797f66cfb.js" crossorigin="anonymous"></script>
  <script
        src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
        crossorigin="anonymous"></script>
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
    <div id="page-content" class="contenidodelaweb hidden">

    </div>
    <div id="page-loader"><span class="material-icons big loading-anim"> restaurant </span></div>

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