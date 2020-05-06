<?php
include_once("database_service.php");

//Definimos las variables
$nombreErr = $apellidosErr = $emailErr = $userErr = $passErr = "";
$nombre = $apellidos = $email = $user = $pass = "";

$err = null;

//Indica que es un post
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //Comprueba que se cumpla la expresión regular o si el nombre no está vacío
  $nombre = test_input($_POST["nombre"]);
  if (empty($nombre) || !preg_match("/^[a-zA-Z ]*$/", $nombre)) {
    $err['name'] = "Introduzca un nombre válido";
  }

  //Si los apellidos están vacíos salta una alerta
  $apellidos = test_input($_POST["apellidos"]);
    if (empty($apellidos) || !preg_match("/^[a-zA-Z ]*$/", $apellidos)) {
      $err['surname'] = "Introduzca apellidos válidos";
    }

  //Valida que el email es correcto
  $email = test_input($_POST["email"]);
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $err['email'] = "Introduzca una dirección de correo electrónico válida";
  }

  //Si el nombre de usuario está vacío o no cumple lo requisitos salta una alerta
  $user = test_input($_POST["user"]);
    if (empty($user) || !preg_match('/^[a-zA-Z0-9]{5,15}$/', $user)) {
      $err['user'] = "Introduzca un nombre de usuario válido";
    }

  //Si la contraseña está vacía o no cumple lo requisitos salta una alerta
  $pass = test_input($_POST["pass"]);
  if (empty($_POST["pass"]) || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&_-])[A-Za-z\d@$!%*?&_-]{8,}$/', $pass)) {
    $err['pass'] = "La contraseña debe tener más de 8 caracteres, disponer de una letra minúscula, mayúscula, un número y un carácter especial.";
  }

  if (isset($err))
  {
    http_response_code(400);
    echo json_encode($err);
    die;
  } 
  else 
  {
    $usuario['name'] = $_POST['nombre'];
    $usuario['surname'] = $_POST['apellidos'];
    $usuario['email'] = $_POST['email'];
    $usuario['user'] = $_POST['user'];
    $usuario['pass'] = $_POST['pass'];
    if(user_registration($usuario))
    {
      $_SESSION['successRegister'] = true;
      //header("Location: .?success");
    } else 
    {
      echo "Ha ocurrido un error registrando el usuario";
    }
    
  }


}



//Función para probar que los datos introducidos no son "datos basura"
function test_input($data)
{
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
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" name="formReg" id="formReg" onsubmit="return validaFormRegistro()">


        <input type="text" name="nombre" placeholder="Nombre" id="nombre" value="<?php echo $nombre; ?>">


        <input type="text" name="apellidos" placeholder="Apellidos" id="apellidos" value="<?php echo $apellidos; ?>">


        <input type="email" name="email" placeholder="Correo Electrónico" id="email" value="<?php echo $email; ?>">


        <input type="text" name="user" placeholder="Usuario" id="user" value="<?php echo $user; ?>">


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
  echo "<br>";
  echo $user;
  echo "<br>";
  echo $pass;
  ?>


  <!--Validación del formulario en el cliente con javascript-->
  <script src="validacionReg.js"></script>



</body>

</html>