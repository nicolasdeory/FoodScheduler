<?php

include_once("gestionBD.php");

/**
 * Registra un usuario. Devuelve true si 
 */
function user_registration($usuario)
{

	$nameStr = $usuario["name"]." ".$usuario["surname"];
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";
	try {
		$consulta = "CALL REGISTRARUSUARIO_PARAM(:user, :pass, :email, :name, :phone)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':user', $usuario["user"]);
		$stmt->bindParam(':pass', password_hash($usuario["pass"], PASSWORD_DEFAULT)); // salt password here
		$stmt->bindParam(':email', $usuario["email"]);
		$stmt->bindParam(':name', $nameStr);
		if (isset($usuario['phone']))
		{
			$stmt->bindParam(':phone', $usuario['phone']);
		}
		else 
		{
			$stmt->bindValue(':phone', "1111");
		}
		

		$stmt->execute();

		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
		
	}
}

/**
 * Comprueba el login. Devuelve true si el par usuario-contraseña existe en BD
 */
function user_login($usuario)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM USUARIOS WHERE usuario = :user AND contraseña = :pass";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':user', $usuario["user"]);
		$stmt->bindParam(':pass', password_hash($usuario["pass"], PASSWORD_DEFAULT)); // salt password here

		$stmt->execute();
		return (boolean)($stmt->fetchColumn());
	} catch (PDOException $e) {
		return false;
		// $e->getMessage();
	}
}
