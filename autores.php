<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category General
 *
 * Encargado de mostrar el listado de autores
 *
 */

require_once ("Config/includes.php");

echo "<h3>Autores</h3>\n";

$directorio = "Biblioteca";

$archivo = scandir ($directorio);

$equery = "SELECT * FROM Autor ORDER BY Apellido";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
{
	if ($row ['segNombre'] != "")
	{
		$nombre = trim ($row ['nombre']) . "_" . trim ($row ['segNombre']);
		$nombreTitulo = trim ($row ['nombre']) . " " . trim ($row ['segNombre']);
	}
	else
	{
		$nombre = trim ($row ['nombre']);
		$nombreTitulo = trim ($row ['nombre']);
	}
	
	$nombre = str_replace (' ', '_', $nombre);
	
	echo "<li><a href='sagas.php?autorId=" . $row ['idAutor'] . "'>" . $row ['apellido'] . ", " . $nombreTitulo . "</a></li><Br/>";
}

mysqli_close ($link);
?>

<Br />
<Br />
<Br />
<Br />
<Br />
<Br />