<?php

class Database
{
    static $instance = null;
    static function instance()
    {
		if (self::$instance == null)
		{
			$host="oci:dbname=localhost/XE;charset=UTF8";
			$usuario="system";
			$password="root";
		
			try{
				
				/* Indicar que las sucesivas conexiones se puedan reutilizar */	
				self::$instance=new PDO($host,$usuario,$password,array(PDO::ATTR_PERSISTENT => true));
				
				/* Indicar que se disparen excepciones cuando ocurra un error*/
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			}catch(PDOException $e){
				self::$instance = null;
				return false;
			}
		}
        return self::$instance;
    }
}

?>
