<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category General
 *
 * Encargado de mostrar el listado de capitulos
 *
 */

require_once ("Config/includes.php");

if (isset ($_GET ["saga"]))
{
	$saga = $_GET ['saga'];
}

if (isset ($_GET ["autor"]))
{
	$autor = $_GET ['autor'];
}

if (isset ($_GET ["titulo"]))
{
	$titulo = $_GET ['titulo'];
}

if (isset ($_GET ["idLibro"]))
{
	$idLibro = $_GET ['idLibro'];
}



$equery = "SELECT * FROM Libro WHERE idLibro = $idLibro";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);

echo "<div id='autor'>";
echo '<img class="fotoAutor" src="fotosLibros/'.$row['imagen'].'">';
echo '<Br />';
echo '<h4>'.$row['titulo'].'</h4>';

echo 'Cantidad de capitulos: '.$row['cantCap'];
echo '<Br />';

echo 'A&ntilde;o de edicion: '.$row['anio'];
echo '<Br />';

echo '<Br />';
echo html_entity_decode($row['resenia']);
echo '<Br />';

echo "</div>";

$codigoYouTube = $row ['ListaDeRepr'];


echo "<h3>Capitulos</h3>\n <div id='cuerpo' >\n";

$equery = "SELECT * FROM Capitulo WHERE idLibro = $idLibro ORDER BY nrOrden";
$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));

while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
{
	
	$idCapitulo = $row ['idCapitulo'];
	
	$idLibro = $row ['idLibro'];
	
	$tituloCapitulo = str_pad ($row ['nrOrden'], 2, "0", STR_PAD_LEFT) . "-" . trim ($row ['titulo']);
	
	echo "<a href='leer.php?idCapitulo=$idCapitulo'>
								<b>&nbsp;$tituloCapitulo</b>
							</a>";
	if ($_SESSION ['estado'] == 'Iniciada')
									{
										echo "&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;
										<a href='editar.php?idCapitulo=$idCapitulo'>
										<b>&nbsp;Edit</b>
										</a>";
									}
echo "<Br />";
}

if ($codigoYouTube != "")
{ 
echo "<Br />";
echo '<Div align="center"><iframe width="200" height="113" src="https://www.youtube.com/embed/videoseries?list='. $codigoYouTube .'" frameborder="0" allowfullscreen></iframe></Div>';			
}
mysqli_close ($link);
?>
</div>