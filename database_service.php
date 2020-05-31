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
		$consulta = "SELECT * FROM recetas WHERE id_receta = :idrecipe";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':idrecipe', $recetaId);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe[0];
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function view_ingredients($recetaId)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT cantidad, unidaddemedida, nombre FROM cantidadesingredientes natural join ingredientes WHERE cantidadesingredientes.id_receta = :idrecipe";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':idrecipe', $recetaId);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function view_pasos($recetaId)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT descripcion FROM pasos WHERE id_receta = :idrecipe";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':idrecipe', $recetaId);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
		return $recipe;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function view_saved($nombreUsuario)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT recetas.id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetasfavoritas JOIN recetas ON recetasfavoritas.id_receta = recetas.id_receta WHERE recetasfavoritas.nombredeusuario = :nombreUsuario";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':nombreUsuario', $nombreUsuario);
		$stmt->execute();
		$recipe = $stmt->fetchAll();
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
		$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente AND UPPER(nombre) LIKE UPPER(:comida||'%') AND dificultad = :dificultad " ;
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
		$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas" ;
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
		$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE UPPER(nombre) LIKE UPPER(:comida||'%') AND dificultad = :dificultad " ;
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
			$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente AND dificultad = :dificultad " ;
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
			$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE UPPER(nombre) LIKE UPPER(:comida||'%') AND id_ingrediente = :ingrediente " ;
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
			$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE UPPER(nombre) LIKE UPPER(:comida||'%') " ;
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
			$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas NATURAL JOIN cantidadesingredientes WHERE id_ingrediente = :ingrediente " ;
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
			$consulta = "SELECT id_receta, nombre, tiempoelaboracion, popularidad, dificultad FROM recetas WHERE dificultad = :dificultad " ;
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
		$consulta = "INSERT INTO planificaciones VALUES (S_PLANIFICACIONES.nextval, :fecha, :comida, :username) 
			RETURNING id_planificacion INTO :inserted_id";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':fecha', $date);
		$stmt->bindParam(':comida', $mealtype);
		$stmt->bindParam(':username', $username);
		$schdId = -1;
		$stmt->bindParam('inserted_id', $schdId, PDO::PARAM_INT, 8);
		$stmt->execute();
		if ($schdId == -1)
		{
			return false;
		}
		else
		{
			return $schdId;
		}
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
							AND fecha BETWEEN TRUNC(SYSDATE) AND TRUNC(SYSDATE+7))
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
		$consulta = "SELECT cantidad FROM itemsEnNevera
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

function get_quantity_in_shopping($username, $id_ingrediente) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT cantidad FROM itemsEnListaCompra
		WHERE nombreDeUsuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingrediente);
		$stmt->execute();
		$qtyInShopping = $stmt->fetchColumn();
		return $qtyInShopping;
	} catch (PDOException $e) {
		echo $e->getMessage();
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
		WHERE nombreDeUsuario = :username ORDER BY nombre";
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

function add_ingredient($name)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "INSERT INTO ingredientes VALUES (S_INGREDIENTES.nextval, :nombre) RETURNING id_ingrediente INTO :inserted_id";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':nombre', $name);
		$ingredId = -1;
		$stmt->bindParam('inserted_id', $ingredId, PDO::PARAM_INT, 8);
		$stmt->execute();
		return $ingredId;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function add_to_fridge($username, $ingred_name, $qty, $qtyType, $additive) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT id_ingrediente from ingredientes WHERE nombre = :ingred_name";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':ingred_name', $ingred_name);
		$stmt->execute();
		$id_ingred = $stmt->fetchColumn();
		if (!$id_ingred) {
			// if it doesn't exist, add it
			$id_ingred = add_ingredient($ingred_name);
		}

		$consulta = "SELECT cantidad from itemsEnNevera WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$dbQty = $stmt->fetchColumn();
		if ($dbQty) {
			// if it exists, update it
			//delete_fridge($username, $id_ingred);
			$consulta = "UPDATE itemsEnNevera SET cantidad = :qty, unidaddemedida = :qty_type 
							WHERE id_ingrediente = :id_ingred AND nombredeusuario = :username";
			if ($additive)
			{
				$finalQty = $qty + $dbQty;
			}
			else 
			{
				$finalQty = $qty;
			}
		}
		else
		{
			$finalQty = $qty;
			$consulta = "INSERT INTO itemsEnNevera VALUES (S_ITEMSENNEVERA.nextval, :username, :id_ingred, :qty, :qty_type)";
		}
		//$consulta = "INSERT INTO itemsEnNevera VALUES (S_ITEMSENNEVERA.nextval, :username, :id_ingred, :qty, :qty_type)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->bindParam(':qty', $finalQty);
		$stmt->bindParam(':qty_type', $qtyType);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function add_to_fridge_id($username, $id_ingred, $qty, $qtyType, $additive) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT cantidad from itemsEnNevera WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$dbQty = $stmt->fetchColumn();
		if ($dbQty) {
			// if it exists, update it
			//delete_fridge($username, $id_ingred);
			$consulta = "UPDATE itemsEnNevera SET cantidad = :qty, unidaddemedida = :qty_type 
							WHERE id_ingrediente = :id_ingred AND nombredeusuario = :username";
			if ($additive)
			{
				$finalQty = $qty + $dbQty;
			}
			else 
			{
				$finalQty = $qty;
			}
		}
		else
		{
			$finalQty = $qty;
			$consulta = "INSERT INTO itemsEnNevera VALUES (S_ITEMSENNEVERA.nextval, :username, :id_ingred, :qty, :qty_type)";
		}
		//$consulta = "INSERT INTO itemsEnNevera VALUES (S_ITEMSENNEVERA.nextval, :username, :id_ingred, :qty, :qty_type)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->bindParam(':qty', $finalQty);
		$stmt->bindParam(':qty_type', $qtyType);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function add_to_shopping_list($username, $ingred_name, $qty, $qtyType, $additive) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT id_ingrediente from ingredientes WHERE UPPER(nombre) = UPPER(:ingred_name)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':ingred_name', $ingred_name);
		$stmt->execute();
		$id_ingred = $stmt->fetchColumn();
		if (!$id_ingred) {
			// if it doesn't exist, add it
			$id_ingred = add_ingredient($ingred_name);
		}

		$consulta = "SELECT cantidad from itemsEnListaCompra WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$dbQty = $stmt->fetchColumn();
		if ($dbQty) {
			// if it exists, update it
			//delete_fridge($username, $id_ingred);
			$consulta = "UPDATE itemsEnListaCompra SET cantidad = :qty, unidaddemedida = :qty_type 
							WHERE id_ingrediente = :id_ingred AND nombredeusuario = :username";
			if ($additive)
			{
				$finalQty = $qty + $dbQty;
			}
			else 
			{
				$finalQty = $qty;
			}
		}
		else
		{
			$finalQty = $qty;
			$consulta = "INSERT INTO itemsEnListaCompra VALUES (S_ITEMSENLISTACOMPRA.nextval, :username, :id_ingred, :qty, :qty_type)";
		}
		//$consulta = "INSERT INTO itemsEnListaCompra VALUES (S_ITEMSENLISTACOMPRA.nextval, :username, :id_ingred, :qty, :qty_type)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->bindParam(':qty', $finalQty);
		$stmt->bindParam(':qty_type', $qtyType);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function add_to_shopping_list_id($username, $id_ingred, $qty, $qtyType, $additive) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT cantidad from itemsEnListaCompra WHERE nombredeusuario = :username AND id_ingrediente = :id_ingred";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->execute();
		$dbQty = $stmt->fetchColumn();
		if ($dbQty) {
			// if it exists, update it
			//delete_fridge($username, $id_ingred);
			$consulta = "UPDATE itemsEnListaCompra SET cantidad = :qty, unidaddemedida = :qty_type 
							WHERE id_ingrediente = :id_ingred AND nombredeusuario = :username";
			if ($additive)
			{
				$finalQty = $qty + $dbQty;
			}
			else 
			{
				$finalQty = $qty;
			}
		}
		else
		{
			$finalQty = $qty;
			$consulta = "INSERT INTO itemsEnListaCompra VALUES (S_ITEMSENLISTACOMPRA.nextval, :username, :id_ingred, :qty, :qty_type)";
		}
		//$consulta = "INSERT INTO itemsEnListaCompra VALUES (S_ITEMSENLISTACOMPRA.nextval, :username, :id_ingred, :qty, :qty_type)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':id_ingred', $id_ingred);
		$stmt->bindParam(':qty', $finalQty);
		$stmt->bindParam(':qty_type', $qtyType);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
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

function delete_schedule($username, $date, $meal)
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "DELETE (SELECT *
						FROM recetasenplanificaciones rp
						INNER JOIN planificaciones pl
							ON rp.id_planificacion = pl.id_planificacion
						WHERE pl.fecha = :fecha AND pl.nombredeusuario = :username AND pl.comida = :meal)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':fecha', $date);
		$stmt->bindParam(':meal', $meal);
		$stmt->execute();
		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

function add_schedule($username, $recipe_id, $date, $meal) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT id_planificacion from planificaciones 
			WHERE nombredeusuario = :username AND fecha = :fecha AND comida = :meal";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':fecha', $date);
		$stmt->bindParam(':meal', $meal);
		$stmt->execute();
		$id_schd = $stmt->fetchColumn();
		if (!$id_schd) {
			// if the schedule doesn't exist, add it
			$id_schd = create_schedule($username, $date, $meal);
		}

		$consulta = "SELECT id_receta from recetasenplanificaciones 
			WHERE id_planificacion = :id_schd AND id_receta = :id_receta";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':id_schd', $id_schd);
		$stmt->bindParam(':id_receta', $recipe_id);
		$stmt->execute();
		$id_rec = $stmt->fetchColumn();
		if ($id_rec) {
			return "already exists";
		}
		$consulta = "INSERT INTO recetasenplanificaciones VALUES (S_RECETASENPLANIFICACIONES.nextval, :id_receta, :id_schd)";
		$stmt = $conexion->prepare($consulta);
		$stmt->bindParam(':id_schd', $id_schd);
		$stmt->bindParam(':id_receta', $recipe_id);
		$stmt->execute();
		return "ok";
		
	} catch (PDOException $e) {
		echo $e->getMessage();
		return "error";
	}
}

function get_shopping_list($username) 
{
	$conexion = Database::instance();
	if (!$conexion)
		echo "Ha ocurrido un error conectando con la base de datos";

	try {
		$consulta = "SELECT * FROM itemsEnListaCompra NATURAL JOIN ingredientes
		WHERE nombreDeUsuario = :username ORDER BY nombre";
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