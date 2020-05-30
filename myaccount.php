<?php

session_start();
include_once("database_service.php");

$userId = $_SESSION['login'];
$usuario = view_user($userId);

?>
<div class="contenidodelaweb">
    <div class="rectangulo">
    <span class="material-icons userpic" style="color:#563514" style="font-size:100px"> account_circle </span>
        <div class="datosText">
            <h3>Nombre de Usuario: <?php echo $userId ?></h3>
            <h3>Email: <?php echo $usuario['CORREOELECTRONICO']; ?></h3>
            <h3>Nombre Completo: <?php echo $usuario['NOMBRE']; ?></h3>
        </div>
    </div>
</div>