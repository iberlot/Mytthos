<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 * Conexiones a las bases de datos 
 */

if (file_exists ("config.php"))
{
	include_once ("config.php");
}

$link = mysqli_connect ($host, $username, $password, $database);

if (! $link)
{
	die ('Error de Conexi&oacute;n (' . mysqli_connect_errno () . ') ' . mysqli_connect_error ());
}

mysqli_set_charset ($link, "utf8");
?>