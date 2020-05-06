<?php 
  //Definimos las variables
  $nombreErr = $apellidosErr = $emailErr = $userErr = $passErr ="";
  $nombre = $apellidos = $email = $user = $pass ="";
  

  //Indica que es un post
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    //Si el nombre está vacío salta una alerta
	  if (empty($_POST["nombre"])) {
      $nombreErr = "Introduzca su nombre";
    
    //Comprueba que se cumpla la expresión regular
	  } else {
      $nombre = test_input($_POST["nombre"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$nombre)) {
        $nombreErr = "Introduzca un nombre válido";
      }
    }
    
    //Si los apellidos están vacíos salta una alerta
    if (empty($_POST["apellidos"])) {
        $apellidosErr = "Introduzca sus apellidos";
    
    //Comprueba que se cumpla la expresión regular
		} else {
        $apellidos = test_input($_POST["apellidos"]);
		
		  if (!preg_match("/^[a-zA-Z ]*$/",$apellidos)) {
            $apellidosErr = "Introduzca los apellidos válidos";
            }
        }
    //Si el email está vacío salta una alerta
    if (empty($_POST["email"])) {
         $emailErr = "Introduzca su dirección de correo electrónico";
    
         //Valida que el email es correcto
		} else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Introduzca una dirección de correo electrónico válida";
             }
        }
    //Si el nombre de usuario está vacío o no cumple lo requisitos salta una alerta
    if (empty($_POST["user"]) || str_word_count($user)<5 || str_word_count($user)>15) {
        $userErr = "Su nombre de usuario debe tener entre 5 y 15 caracteres";
      
      //Comprueba la expresión regular
      } else {
        $user = test_input($_POST["user"]);
        if (!preg_match('/^[a-zA-Z0-9]{5,15}$/', $user)) {
          $userErr = "Introduzca un nombre de usuario válido";
          }
      }
    
    //Si la contraseña está vacía o no cumple lo requisitos salta una alerta
    if (empty($_POST["pass"]) || !isset($pass[8])) {
        $passErr = "La contraseña debe tener más de 8 caracteres";
      
      //Comprueba la expresión regular
      } else {
        $pass = test_input($_POST["pass"]);
        if (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $pass)) {
          $passErr = "La contraseña debe tener letras minúsculas, mayúsculas, números y caracteres especiales";
        }
      }
    }
    //Función para probar que los datos introducidos no son "datos basura"
   function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--Nombre de la pestaña-->    
    <title>Registrarse</title>
    
<!--Link de la Fuente para las letras pequeñas-->    
    <link href="https://fonts.googleapis.com/css2?family=Muli&display=swap" rel="stylesheet">

<!--Link de la Fuente para el Título--> 
    <link href="https://www.fontspring.com/fonts/horizon-type/acherus-grotesque" rel="stylesheet">

<!--Link al archivo css-->   
    <link rel="stylesheet" href="assets/css/registerstyle.css" type="text/css">

</head>

<body>
<div class="cuadradoReg">
    
<!--Párrafos-->
    <div class="titReg">
        <h1>Registro</h1>
    </div>

<!--Formulario de Registro-->
    <div class="formReg">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="formReg" id="formReg" onsubmit="return validaFormRegistro()">
        
        
            <input type="text" name="nombre" placeholder="Nombre" id="nombre" value="<?php echo $nombre;?>">
            
	      
            <input type="text" name="apellidos" placeholder="Apellidos" id="apellidos" value="<?php echo $apellidos;?>">
            
	     
            <input type="email" name="email" placeholder="Correo Electrónico" id="email" value="<?php echo $email;?>">
            
	      
            <input type="text" name="user" placeholder="Usuario" id="user" value="<?php echo $user;?>">
            
	      
            <input type="password" name="pass" placeholder="Contraseña" id="pass">
            
	      
            <button type="submit">Crear Cuenta</button>
        </form>
      </div>
    </div>

  <?php
echo "<h2>Datos introducidos:</h2>";
echo $nombre;
echo "<br>";
echo $apellidos;
echo "<br>";
echo $email;
echo"<br>";
echo $user;
echo "<br>";
echo $pass;
?>


<!--Validación del formulario en el cliente con javascript-->
  <script src="validacionReg.js"></script>



</body>
</html>