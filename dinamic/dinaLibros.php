<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 * Genera el listado dinamico de libros
 */

$host = 'mysql.hostinger.com.ar';
$username = 'u530625595_ivan';
$password = 'JuliaMatilde';
$database = 'u530625595_libro';


$link = mysqli_connect ($host, $username, $password, $database);

if (! $link)
{
	die ('Error de Conexi&oacute;n (' . mysqli_connect_errno () . ') ' . mysqli_connect_error ());
}

mysqli_set_charset ($link, "utf8");

if (isset ($_POST ["SAGA"]))
{
	$idSaga = $_REQUEST ["SAGA"];

	$sqlLibro = "SELECT * FROM Libro WHERE idSaga = '$idSaga' ORDER BY ordenSaga";

	$result = mysqli_query ($link, $sqlLibro) or die ('Query error: ' . mysqli_error ($link));
	
	echo '<option value=""> </option>';
	
	while ($row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC))
	{

if (isset ($_REQUEST ['idLibro']))
{
	$idLibro = ($_REQUEST ['idLibro']);
}
else
{
$idSaga = "";
}

if ($idLibro == $row2 ['idLibro'])
{
	$sel = ' selected="selected" ';
}
else
									{
										$sel = '';
									}

		
		$opcionez .= ' <option value=' . $row2 ['idLibro'] . $sel . '>' . substr ($row2 ['titulo'], 0, 50) . ' </option>'; // concatenamos el los options para luego ser insertado en el HTML
	}
	
	echo $opcionez;
}
?>