<?php
	session_start();
	
	// Importar librerías necesarias para gestionar direcciones y géneros literarios
	require_once("gestionBD.php");
	
	
	// Si no existen datos del formulario en la sesión, se crea una entrada con valores por defecto
	if (!isset($_SESSION["formulario"])) {
		$formulario['nombre'] = "";
		$formulario['apellidos'] = "";
		$formulario['email'] = "";
		$formulario['user'] = "";
		$formulario['pass'] = "";
		
	
		$_SESSION["formulario"] = $formulario;
	}
	// Si ya existían valores, los cogemos para inicializar el formulario
	else
		$formulario = $_SESSION["formulario"];
			
	// Si hay errores de validación, hay que mostrarlos y marcar los campos (El estilo viene dado y ya se explicará)
	if (isset($_SESSION["errores"])){
		$errores = $_SESSION["errores"];
		unset($_SESSION["errores"]);
	}
		
	// Creamos una conexión con la BD
	$conexion = crearConexionBD();
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
        <form action="signup.php" method="post" name="formReg" id="formReg">
            <input type="text" name="nombre" placeholder="Nombre" id="nombre" value="<?php echo $formulario['nombre'];?>">
            <input type="text" name="apellidos" placeholder="Apellidos" id="apellidos" value="<?php echo $formulario['apellidos'];?>">
            <input type="email" name="email" placeholder="Correo Electrónico" id="email" value="<?php echo $formulario['email'];?>">
            <input type="text" name="usuarioReg" placeholder="Usuario" id="usuarioReg" value="<?php echo $formulario['user'];?>">
            <input type="password" name="passReg" placeholder="Contraseña" id="passReg">
            <button type="submit">Crear Cuenta</button>
        </form>
      </div>
    </div>

<!--Código javascript-->       
    <script type="text/javascript" src="validacionReg.js"></script>

<?php
	cerrarConexionBD($conexion);
?>

</body>
</html>