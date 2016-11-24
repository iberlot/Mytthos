<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category config
 *
 * Archivo que se encarga del control de session para el ingreso y
 * permanencia en el sistema
 *
 */

/**
 * funcion para ver el estado de la sesion
 * este se ejecuta solo si la sesion fue iniciada
 *
 * @return bool $session_id
 * @return bool $session_status
 */
function is_session_started()
{
	if (php_sapi_name () !== 'cli') // Devuelve el tipo de interfaz que hay entre PHP y el servidor
	{
		if (version_compare (phpversion (), '5.4.0', '>=')) // Comparamos la version de php
		{
			return session_status () === PHP_SESSION_ACTIVE ? TRUE : FALSE;
		}
		else
		{
			return session_id () === '' ? FALSE : TRUE;
		}
	}
	return FALSE;
}

// si la secion no esta iniciada lo hace

if (is_session_started () === FALSE)
	session_start ();

if (! isset ($_SESSION ['usuario']))
{
	// si la sesion no fue iniciada lo devolvemos para la pagina anterior
	header ("location:login.php");
	echo "no guardo el inicio de la secion";
	print_r ($_SESSION ['usuario']);
	exit ();
	return; // Este return evita que el codigo continue ejecutandose
}

// Si llega a esta parte del c&oacute;digo es porque la veriable de sesion si existe

// Es importante tener en cuenta que la sesion estara viva mientras no se haya cerrado
// el browser. En el momento que cerramos el browser la sesion es matada

?>