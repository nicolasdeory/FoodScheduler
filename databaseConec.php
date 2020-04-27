<?php

$host = 'oci:dbname=localhost/XE';
$username='usuario';
$passwd='contraseña';


try {
    $con = new PDO($host,$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo 'Conectados a la BD';
    
    // Cerramos la conexión
    $con = null;
    
}catch( PDOException $e ) {
    // tratamiento del error
    echo 'error de conexión: ' . $e->getMessage();
    }





?>