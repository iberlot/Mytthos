<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category config
 *
 * Sistema de validacion de usuarios
 *
 */

session_start ();

include_once ("Config/variables.php"); // incluimos el archivo que contiene las variables
include_once ("Config/config.php"); // incluimos el archivo de configuracion
include_once ("Config/conect.php"); // incluimos el archivo de conexion
// include_once("Config/control_session.php");

$usuario = strtolower (htmlentities ($_POST ["usuario"], ENT_QUOTES));

$password = $_POST ["password"];

// Controlo que usuario y pass esten completos//

if ($usuario == "")
{
	echo "Debe colocar nombre de usuario ";
	exit ();
}
if ($password == "")
{
	echo "Debe colocar contrase&ntilde;a";
	exit ();
}
// /////////////////////////////////////////////////////////

if ($usuario != "" && $password != "")
{
	
	// //////////////////////////////////////////////////////
	// Conecto con Servidor POP3 y verifico si entra ///////
	// //////////////////////////////////////////////////////
	
	$equery = "SELECT * FROM Usuarios WHERE nombreUsuario = '" . $usuario . "'";
	$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));
	
	while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
	{
		$mailUsuario = trim ($row ['mailUsuario']);
		
		echo $mailUsuario . " - " . $password . "<Br />";
		if ($row ['pass']==$password)
		{
			$entro = 1;
		}
		else
		{
			$entro = 0;
		}
	}
	
	// ///////////////////////////////////////////////
	if (($entro == 1)) // or ($usuario=='iberlot') or ($usuario=='mgallardo'))
	{
		$_SESSION ['usuario'] = $usuario;
		
		/**
		 * if(($usuario =='iberlot') or ($usuario=='mgallardo'))
		 * {
		 * $_SESSION['usuario'] = $usuario;
		 * }
		 */
		
		$_SESSION ['estado'] = 'Iniciada';
		
		// Elimina el siguiente comentario si quieres que re-dirigir automáticamente a index.php
		echo "Ingreso exitoso, ahora sera dirigido a la pagina principal.";
		echo "<p><a href='index.php'>inicio</a></p>";
		
		header ("location:index.php");
	}
	else
	{
		echo 'Los datos suministrados son incorrectos....';
		echo "<!--DEBUG:" . $usuario . ":" . $entro . ":" . $imp . ":" . imap_last_error () . "-->";
	}
}