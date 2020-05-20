<?php
session_start();
include_once("database_service.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $usuario['user'] = $user;
    $usuario['pass'] = $pass;

    if (user_login($usuario)) {
        $_SESSION['login'] = $user;
        echo "success";
    } else {
        echo "wrong pass";
        http_response_code(401);
    }
    die;
}

if (isset($_SESSION['login']))
{
    header('Location: dashboard.php');
}

// TODO: AJAX FORM

?>


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

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <script
        src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
        crossorigin="anonymous"></script>
        
    <!--Código javascript-->
    <script type="text/javascript" src="validacionLogin.js"></script>

    <!--Código javascript iconos usuario y contraseña-->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <script src="js/login.js"></script>

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

            <form action="" method="post" name="formLogin" id="form-login" onsubmit="return validarFormLogin()">


                <div class="usr">
                    <input type="text" placeholder="Nombre de usuario" name="user" id="user">
                    <i class="fas fa-user" style="color:#563514"></i>
                </div>

                <div class="psw">
                    <input type="password" placeholder="Contraseña" name="pass" id="pass">
                    <i class="fas fa-key" style="color:#563514"></i>
                </div>

                <button type="submit" id="enviar">Entrar</button>

            </form>

        </div>

        <a class="btn" href="signup.php">No tengo cuenta</a>



    </div>

</body>

</html>