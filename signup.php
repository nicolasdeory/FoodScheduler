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
            <input type="text" name="nombre" placeholder="Nombre" id="nombre">
            <input type="text" name="apellidos" placeholder="Apellidos" id="apellidos">
            <input type="email" name="email" placeholder="Correo Electrónico" id="email">
            <input type="text" name="usuarioReg" placeholder="Usuario" id="usuarioReg">
            <input type="password" name="passReg" placeholder="Contraseña" id="passReg">
            <button type="submit">Crear Cuenta</button>
        </form>
      </div>
    </div>

<!--Código javascript-->       
    <script type="text/javascript" src="validacionReg.js"></script>


</body>
</html>