<!DOCTYPE html>

<html lang="en">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8">

    

<!--Nombre de la pestaña-->
    <title>Iniciar Sesión</title>

<!--Link de la Fuente para las letras pequeñas-->    
    <link href="https://fonts.googleapis.com/css2?family=Muli&display=swap" rel="stylesheet">

<!--Link de la Fuente para el Título--> 
    <link href="https://www.fontspring.com/fonts/horizon-type/acherus-grotesque" rel="stylesheet">

<!--Link al archivo css-->   
    <link rel="stylesheet" href="assets/css/loginstyle.css" type="text/css">



</head>


<body>


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
        
            
            <div class="usr">
                <input type="text" placeholder="Nombre de usuario" name="usernameLogin" id="usernameLogin">
                <i class="fas fa-user" style="color:#563514"></i>
            </div>
            
            <div class="psw">
                <input type="password" placeholder="Contraseña" name="passwdLogin" id="passwdLogin">
                <i class="fas fa-key" style="color:#563514"></i>
            </div>
            
            <button type="submit" id="enviar">Entrar</button>
        
        </form>
        
    </div>   

        <a class="btn" href="signup.php">No tengo cuenta</a>
  
            
            
</div>








<!--Código javascript-->       
    <script type="text/javascript" src="validacion.js"></script>

<!--Código javascript iconos usuario y contraseña-->     
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
       

</body>

</html>