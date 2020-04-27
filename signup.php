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
        <form action="signup.php" method="post">
            <input type="text" name="Nombre" placeholder="Nombre" id="nombre" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,48}" required>
            <input type="text" name="Apellidos" placeholder="Apellidos" id="apellidos" pattern="[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]{2,64}" required>
            <input type="email" name="Email" placeholder="Correo Electrónico" id="email" pattern="^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$" required>
            <input type="text" name="Usuario" placeholder="Usuario" id="username" pattern="[A-Za-z0-9_]{5,15}" required>
            <input type="password" name="Contraseña" placeholder="Contraseña" id="passwd" pattern="^(?=.*[\d\W])(?=.*[a-z])(?=.*[A-Z]).{8,}$" required>
            <button type="submit">Crear Cuenta</button>
        </form>
    </div>
</div>

<!--Código javascript-->       
    <script type="text/javascript" src="validacion.js"></script>


</body>
</html>