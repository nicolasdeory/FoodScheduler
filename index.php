

<?php
session_start();
include_once("database_service.php");

if (isset($_SESSION['registerSuccess']) && $_SESSION['registerSuccess'])
{
    $_SESSION['registerSuccess'] = false;
    echo "Registro completado. Introduce tus datos.";
}

?>



