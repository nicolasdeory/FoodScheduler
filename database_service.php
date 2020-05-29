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

function get_needed_ingredients($username) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM (
			SELECT 
				id_ingrediente,
				sum(cantidad) AS cantidad, 
				listagg(nombre , ',') within group (order by nombre) AS para_recetas,
				unidadDeMedida
			FROM cantidadesIngredientes c
			NATURAL JOIN recetasenplanificaciones
			NATURAL JOIN (SELECT id_planificacion FROM planificaciones WHERE nombreDeUsuario = :username
							AND fecha BETWEEN TRUNC(SYSDATE) + 1/86400 AND TRUNC(SYSDATE+7))
			NATURAL JOIN recetas
			GROUP BY id_ingrediente,unidadDeMedida)
		NATURAL JOIN ingredientes";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$missingIngreds = $stmt->fetchAll();
		return $missingIngreds;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function get_quantity_in_fridge($username, $id_ingrediente) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT cantidad INTO cantidadEnNevera FROM itemsEnNevera
		WHERE nombreDeUsuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingrediente);
		$stmt->execute();
		$qtyInFridge = $stmt->fetchColumn();
		return $qtyInFridge;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function get_fridge($username) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM itemsEnNevera NATURAL JOIN ingredientes
		WHERE nombreDeUsuario = :username";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$fridge = $stmt->fetchAll();
		return $fridge;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function add_to_fridge($username, $id_ingred, $qty, $qtyType) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * from itemsEnNevera WHERE nombredeusuario = :username, id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$fridge = $stmt->fetchColumn();
		if ($fridge) {
			// if it exists, delete it
			delete_fridge($username, $id_ingred);
		}
		// doesn't get executed if already exists
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function add_to_shopping_list($username, $id_ingred, $qty, $qtyType) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * from itemsEnListaCompra WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$fridge = $stmt->fetchColumn();
		if ($fridge) {
			// if it exists, delete it
			delete_shopping($username, $id_ingred);
		}
		$consulta = "INSERT INTO itemsEnListaCompra VALUES (S_ITEMSENLISTACOMPRA.nextval, :username, :id_ingred, :qty, :qty_type)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->bindParam(':qty', $qty);
		$stmt->bindParam(':qty_type', $qtyType);
		$stmt->execute();
		// doesn't get executed if already exists
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function delete_shopping($username, $id_ingred)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "DELETE FROM itemsEnListaCompra WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function delete_fridge($username, $id_ingred)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "DELETE FROM itemsEnNevera WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}

function get_shopping_list($username) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM itemsEnListaCompra NATURAL JOIN ingredientes
		WHERE nombreDeUsuario = :username";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$qtyInFridge = $stmt->fetchAll();
		return $qtyInFridge;
	} catch (PDOException $e) {
		//echo $e->getMessage();
		return false;
	}
}