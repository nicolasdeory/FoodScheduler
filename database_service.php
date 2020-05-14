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
		$consulta = "CALL REGISTRARUSUARIO_PARAM(:username, :pass, :email, :name, :phone)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $usuario["user"]);
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

		return "success";
	} catch (PDOException $e) {
		$msg = $e->getMessage();
		if (strpos($msg, "ORA-06512") !== false)
		{
			return "unique";
		}
		//$e->err
		return "error";
		
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
		$consulta = "SELECT contraseña FROM USUARIOS WHERE nombredeusuario = :username";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $usuario["user"]);
		$stmt->execute();
		$dbHashedPass = $stmt->fetchColumn();
		return password_verify($usuario['pass'],$dbHashedPass);
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function view_recipe($recetaId)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM recetas WHERE id = :idrecipe";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':idrecipe', $recetaId);
		$stmt->execute();
		$recipe = $stmt->fetchColumn();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function retrieve_schedule($username, $from, $to) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT id_receta, nombre, to_char(fecha,'MM-DD-YYYY') fecha, comida FROM planificaciones
					NATURAL JOIN recetasenplanificaciones 
					NATURAL JOIN recetas
					WHERE nombredeusuario = :username AND fecha BETWEEN :fromRange AND :toRange";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':fromRange', $from);
		$stmt->bindParam(':toRange', $to);
		$stmt->execute();
		$planificaciones = $stmt->fetchAll();
		return $planificaciones;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function create_schedule($username, $date, $mealtype)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "INSERT INTO planificaciones VALUES (S_PLANIFICACIONES.nextval, :fecha, :comida, :username)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':fecha', $date);
		$stmt->bindParam(':comida', $mealtype);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}