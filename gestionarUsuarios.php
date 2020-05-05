<?php
  /*
     * #===========================================================#
     * #	Este fichero contiene las funciones de gestión
     * #	de usuarios de la capa de acceso a datos
     * #==========================================================#
     */

 function registrar_usuario($conexion,$usuario) {

	try {
		$consulta = "CALL INSERTAR_USUARIO(:nombre, :apellidos, :email, :user, :pass)";
		$stmt=$conexion->prepare($consulta);
		$stmt->bindParam(':nombre',$usuario["nombre"]);
		$stmt->bindParam(':apellidos',$usuario["apellidos"]);
		$stmt->bindParam(':email',$usuario["email"]);
		$stmt->bindParam(':user',$usuario["user"]);
		$stmt->bindParam(':email',$usuario["email"]);
		$stmt->bindParam(':pass',$usuario["pass"]);
		
		$stmt->execute();
		
		return asignar_generos_usuario($conexion, $usuario["nif"], $usuario["generoLiterario"]);
	
	} catch(PDOException $e) {
		return false;
		// Si queremos visualizar la excepción durante la depuración: $e->getMessage();
    }
}
 
function asignar_generos_usuario($conexion, $nifUsuario, $generos) {
	$consulta = "CALL INSERTAR_GENERO_USUARIO(:genero, :usuario)";
	
	try{
		$stmt=$conexion->prepare($consulta);
		foreach ($generos as $genero){
			$stmt->bindParam(':genero',$genero);
			$stmt->bindParam(':usuario',$nifUsuario);
			$stmt->execute();
		}

		return true;
	}catch(PDOException $e){
		return false;
	}
  }

  
function consultarUsuario($conexion,$user,$pass) {
 	$consulta = "SELECT COUNT(*) AS TOTAL FROM USUARIOS WHERE USER=:user AND PASS=:pass";
	$stmt = $conexion->prepare($consulta);
	$stmt->bindParam(':user',$user);
	$stmt->bindParam(':pass',$pass);
	$stmt->execute();
	return $stmt->fetchColumn();
}

