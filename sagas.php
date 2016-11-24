<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category general
 *
 * Muestra el listado de sagas para un autor X
 *
 */

require_once ("Config/includes.php");

if (isset ($_GET ["autorId"]))
{
	$autorId = $_GET ['autorId'];
}
else
{
	header ("Location:index.php");
	exit ();
}

$equery = "SELECT * FROM Autor WHERE idAutor = $autorId";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);

echo "<div id='autor'>";
echo '<img class="fotoAutor" src="fotosAutores/'.$row['foto'].'">';
echo '<Br />';
echo '<h4>'.$row['apellido'].", ".$row['nombre']." ".$row['segNombre'].'</h4>';

echo 'Fecha de nacimiento: '.$row['fechaNac'];
echo '<Br />';
if($row['fechaDec']>1)
{
echo 'Fecha de defuncion: '.$row['fechaDec'];
echo '<Br />';
}
echo '<Br />';
echo $row['notas'];
echo '<Br />';

echo "</div>";

echo "<h3>Sagas</h3>\n";

$equery = "SELECT * FROM Saga WHERE idAutor = $autorId ORDER BY titulo";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
{
	
	$idSaga = trim ($row ['idSaga']);
	
	$titulo = trim ($row ['titulo']);
	
	$tituloLink = str_replace (' ', '_', $titulo);
	
	echo "<li><a href='titulos.php?idSaga=" . $idSaga . "&idAutor=" . $autorId . "'>" . $titulo . "</a></li><Br/>";
}

mysqli_close ($link);
?>

<Br />
<Br />
<Br />
<Br />
<Br />
<Br />