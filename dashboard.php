<?php
  session_start();
  
  include_once("database_service.php");

  if (!isset($_SESSION['login']))
	{
		// Not logged, redirect to login
		header('Location: .');
		die;
  }
  
  $userId = $_SESSION['login'];
  $usuario = view_user($userId);
  $nombre = $usuario['NOMBRE'];
  $imprimo = explode(" ", $nombre);
  
  
  


  function campana(){
    $neededIngredients = get_needed_ingredients($_SESSION['login']);
    $missingIngreds = [];
    foreach ($neededIngredients as $ingred) {
      $qtyInFridge = get_quantity_in_fridge($_SESSION['login'], $ingred['ID_INGREDIENTE']);
      $qtyInShopping = get_quantity_in_shopping($_SESSION['login'], $ingred['ID_INGREDIENTE']);
      if ($qtyInFridge == false || $qtyInFridge < $ingred['CANTIDAD'])
      {
          if ($qtyInShopping == false || $qtyInShopping < ($ingred['CANTIDAD'] - $qtyInFridge))
          {
              $neededIngred = $ingred['CANTIDAD'] - $qtyInFridge;
              if ($qtyInShopping && $qtyInShopping > 0)
              {
                  $toAddToShopping = $neededIngred - $qtyInShopping;
              }
              else 
              {
                  $toAddToShopping = $neededIngred;
              }
              $ingred['CANTIDAD'] = $toAddToShopping;
              array_push($missingIngreds, $ingred);
          }
      }
  }
  return $missingIngreds;
  }
  
?>

<!DOCTYPE html>

<html>

<head>
  
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="css/vistareceta.css">
  <link rel="stylesheet" type="text/css" href="css/schedule.css">
  <link rel="stylesheet" type="text/css" href="css/fridge.css">
  <link rel="stylesheet" type="text/css" href="css/busqueda.css">
  <link rel="stylesheet" type="text/css" href="css/createrecipe.css">
  <link rel="stylesheet" type="text/css" href="css/ayuda.css">
  <!-- <link rel="stylesheet" href="css/jquery-ui-min.css"> -->
  <link rel="stylesheet" type="text/css" href="css/myacc.css">

  <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Muli:400,700,800,900&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/2797f66cfb.js" crossorigin="anonymous"></script>
  <script
        src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
        crossorigin="anonymous"></script>

  <!-- <script
        src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
        integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
        crossorigin="anonymous"></script> -->

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
        <?php
          
        $missingIngreds = campana();
        
        if ($missingIngreds == false || count($missingIngreds)==0){ 
            ?> <span id="campanacambiar" class="material-icons campana">notifications</span> <?php
        } else {
            ?> <span id="campanacambiar" style= "color: red;" class="material-icons campana">notifications_active</span> <?php
         }
          ?>
        
      </div>
    </div>
    <div class="partederechamenu">
      <p> Hola, <?php echo $imprimo[0] ?> </p>
      <p id="acc-button"><a>Mi cuenta</a></p>
      <p id="help-button"><a>Ayuda</a></p>
      <p><a href="logout.php">Salir</a></p>
    </div>
  </div>

  <div class="centro">
    <div id="page-content" class="contenidodelaweb hidden">

    </div>
    <div id="page-loader"><span class="material-icons big loading-anim"> restaurant </span></div>

    <div class="barralateral">
      <div class="elemento elementoactivo" id="schedule-button"> <span class="material-icons iconocolumna"> date_range </span> </div>
      <div class="elemento" id="fridge-button"> <img src="icons/fridge.png" /></div>
      <div class="elemento" id="search-button"> <span class="material-icons iconocolumna"> restaurant </span> </div>
      <div class="elemento" id="favorite-button"> <span class="material-icons iconocolumna"> favorite </span> </div>
      <div class="elemento" id="create-button"> <span class="material-icons"> note_add </span></div>
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