<!DOCTYPE html>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<!--Nombre de la pestaña-->
    <title>Iniciar Sesión</title>

<!--Link de la Fuente para las letras pequeñas-->    
    <link href="https://fonts.googleapis.com/css2?family=Muli&display=swap" rel="stylesheet">

<!--Link de la Fuente para el Título--> 
    <link href="https://www.fontspring.com/fonts/horizon-type/acherus-grotesque" rel="stylesheet">

<!--Link al archivo css-->   
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">


</head>


<body>
<i class="fas fa-user"></i>
<div class="imagen">
    <div class="cuadradoLogin"> 
        <hr>


<!--Párrafos-->
    <div class="titLogin">
        <h1>Planificador Alimentario</h1>
    </div>
    
    <div class="subTitLogin">
        <h5>Encuentra recetas y planifica tu día a día</h5>
    </div>


<!--Formulario de Login-->
        
        <div class="formlogin">
            <form action="login.php" method="post" name="formLogin">
            <input type="text" name="Usuario" placeholder="Nombre de usuario" id="username">
            <input type="password" name="Contraseña" placeholder="Contraseña" id="passwd">
            <button type="submit">Entrar</button>
            </form>
        
        </div>

            <a class="btn" href="signup.php">No tengo cuenta</a>
  
            

    </div>



</div>




<!--Código javascript-->       
    <script type="text/javascript" src="validacion.js"></script>
        

</body>

</html>