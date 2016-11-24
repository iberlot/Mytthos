<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 * Genera el listado dinamico de sagas
 *
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


if (isset ($_POST ["AUTOR"]))
{
	$idAutor = $_REQUEST ["AUTOR"];
	
	$sqlSaga = "SELECT * FROM Saga WHERE idAutor = '$idAutor' ORDER BY titulo";
	
	$result = mysqli_query ($link, $sqlSaga) or die ('Query error: ' . mysqli_error ($link));

	echo '<option value=""> </option>';
	
	while ($row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC))
	{

if (isset ($_REQUEST ['idSaga']))
{
	$idSaga = ($_REQUEST ['idSaga']);
}
else
{
$idSaga = "";
}

if ($idSaga == $row2 ['idSaga'])
{
	$sel = ' selected="selected" ';
}
else
									{
										$sel = '';
									}

		$combobit2 = ' <option value=' . $row2 ['idSaga'] . $sel . '>' . substr ($row2 ['titulo'], 0, 50) . ' </option>'; // concatenamos el los options para luego ser insertado en el HTML
		echo $combobit2;
	}
}
?>		