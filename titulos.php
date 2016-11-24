<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category General
 *
 * Mostramos los titulos que hay para una saga
 *
 */

require_once ("Config/includes.php");

if (isset ($_GET ["idAutor"]))
{
	$idAutor = trim ($_GET ['idAutor']);
}
else
{
	header ("Location:autores.php");
	exit ();
}

if (isset ($_GET ["idSaga"]))
{
	$idSaga = trim ($_GET ['idSaga']);
}
else
{
	header ("Location:sagas.php?autorId=$idAutor");
	exit ();
}



$equery = "SELECT * FROM Saga WHERE idSaga = $idSaga";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);

echo "<div id='autor'>";
echo '<img class="fotoAutor" src="fotosSagas/'.$row['imagen'].'">';
echo '<Br />';
echo '<h4>'.$row['titulo'].'</h4>';

echo 'Cantidad de libros: '.$row['cantLibros'];
echo '<Br />';

echo '<Br />';
echo $row['descripcion'];
echo '<Br />';

echo "</div>";





echo "<h3>Titulos</h3>\n";

$equery = "SELECT * FROM Libro WHERE idAutor = $idAutor and idSaga = $idSaga ORDER BY ordenSaga";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
{
	
	$idSaga = trim ($row ['idSaga']);
	
	$idLibro = $row ['idLibro'];
	
	$titulo = trim ($row ['titulo']);
	
	$ordenLibro = $row ['ordenSaga'];
	
	$tituloLink = str_pad ($ordenLibro, 2, "0", STR_PAD_LEFT) . "-" . str_replace (' ', '_', $titulo);
	
	echo "<li><a href='capitulos.php?idLibro=$idLibro'>";
	
	echo "<b>&nbsp;$titulo</b></a></li><Br/>";
}

mysqli_close ($link);
?>


<Br/><Br/><Br/>
<Br/><Br/><Br/>