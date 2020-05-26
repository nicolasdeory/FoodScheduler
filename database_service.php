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

//view recipes  with all parameters
function search_recipes($ingrediente, $comida, $dificultad)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente AND UPPER(nombre) LIKE UPPER(:comida||'%') AND dificultad = :dificultad " ;
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':ingrediente', $ingrediente);
		$stmt->bindParam(':comida', $comida);
		$stmt->bindParam(':dificultad', $dificultad);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}
// Search ALL RECIPES
function search_all_recipes()
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";
	try {
		$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas" ;
		$stmt = $conexion->prepare($consulta);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

//comida y dificultad:
function search_recipes_cd($comida, $dificultad)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";
	try {
		$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE UPPER(nombre) LIKE UPPER(:comida||'%') AND dificultad = :dificultad " ;
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':comida', $comida);
		$stmt->bindParam(':dificultad', $dificultad);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

//ingrediente y dificultad:
	function search_recipes_id($ingrediente, $dificultad)
	{
		$conexion = Database::instance();
		if (!$conexion)
			echo "Ha ocurrido un error conectando con la base de datos";
		try {
			$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente AND dificultad = :dificultad " ;
			$stmt = $conexion->prepare($consulta);
			$stmt->bindParam(':ingrediente', $ingrediente);
			$stmt->bindParam(':dificultad', $dificultad);
			$stmt->execute();
			$recipe = $stmt->fetchAll();
			return $recipe;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

//comida y ingrediente:
	function search_recipes_ci($comida, $ingrediente)
	{
		$conexion = Database::instance();
		if (!$conexion)
			echo "Ha ocurrido un error conectando con la base de datos";
		try {
			$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE UPPER(nombre) LIKE UPPER(:comida||'%') AND id_ingrediente = :ingrediente " ;
			$stmt = $conexion->prepare($consulta);
			$stmt->bindParam(':comida', $comida);
			$stmt->bindParam(':ingrediente', $ingrediente);
			$stmt->execute();
			$recipe = $stmt->fetchAll();
			return $recipe;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

//comida
	function search_recipes_c($comida)
	{
		$conexion = Database::instance();
		if (!$conexion)
			echo "Ha ocurrido un error conectando con la base de datos";
		try {
			$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE UPPER(nombre) LIKE UPPER(:comida||'%') " ;
			$stmt = $conexion->prepare($consulta);
			$stmt->bindParam(':comida', $comida);
			$stmt->execute();
			$recipe = $stmt->fetchAll();
			return $recipe;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

//ingrediente
function search_recipes_i($ingrediente)
	{
		$conexion = Database::instance();
		if (!$conexion)
			echo "Ha ocurrido un error conectando con la base de datos";
		try {
			$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente " ;
			$stmt = $conexion->prepare($consulta);
			$stmt->bindParam(':ingrediente', $ingrediente);
			$stmt->execute();
			$recipe = $stmt->fetchAll();
			return $recipe;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}


//dificultad
function search_recipes_d($dificultad)
	{
		$conexion = Database::instance();
		if (!$conexion)
			echo "Ha ocurrido un error conectando con la base de datos";
		try {
			$consulta = "SELECT nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE dificultad = :dificultad " ;
			$stmt = $conexion->prepare($consulta);
			$stmt->bindParam(':dificultad', $dificultad);
			$stmt->execute();
			$recipe = $stmt->fetchAll();
			return $recipe;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}




//function get ingredient id from a name
function get_ingredientid($ingrediente)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT ID_INGREDIENTE FROM INGREDIENTES WHERE UPPER(nombre) = UPPER(:ingrediente) " ;
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':ingrediente', $ingrediente);
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