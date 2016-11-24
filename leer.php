<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category General
 *
 * Encargado de mostrar el texto del capitulo.
 *
 */

header ('Content-Type: text/html; charset=UTF-8');

require_once ("Config/includes.php");

if (isset ($_GET ["idCapitulo"]))
{
	$idCapitulo = $_GET ['idCapitulo'];
	
	$sql = "SELECT
					Capitulo.idCapitulo idCapitulo,
					Capitulo.nrOrden nrOrden,
					Capitulo.titulo tituloCap,
					Capitulo.foto archivo,
					Capitulo.codigoYouTube codigoYouTube,
					Libro.idLibro idLibro,
					Libro.ordenSaga ordenSaga,
					Libro.titulo tituloLibro,
					Saga.idSaga idSaga,
					Saga.titulo tituloSaga,
					Autor.idAutor idAutor,
					Autor.apellido apellido,
					Autor.nombre nombre,
					Autor.segNombre segNombre
				FROM
					Capitulo,
					Autor,
					Libro,
					Saga
				WHERE
					Capitulo.idLibro = Libro.idLibro
					AND Libro.idSaga = Saga.idSaga
					AND Saga.idAutor = Autor.idAutor
					AND Capitulo.idCapitulo = " . $idCapitulo;
	
	$result = mysqli_query ($link, $sql) or die ('Query error: ' . mysqli_error ($link));
	
	$row = mysqli_fetch_array ($result, MYSQLI_ASSOC);
	
	$idCapitulo = $row ['idCapitulo'];
	
	$apellido = trim ($row ['apellido']);
	$realname = trim ($row ['nombre']);
	$segname = trim ($row ['segNombre']);
	
	if ($segname != "")
	{
		$direCarpeta = $apellido . "_" . $realname . "_" . $segname;
	}
	else
	{
		$direCarpeta = $apellido . "_" . $realname;
	}
	
	$tituloCarpetaSaga = str_replace (' ', '_', trim ($row ['tituloSaga']));
	
	$tituloCarpeta = str_replace (' ', '_', trim ($row ['tituloLibro']));
	
	$tituloCarpeta = $direCarpeta . "/" . $tituloCarpetaSaga . "/" . str_pad ($row ['ordenSaga'], 2, "0", STR_PAD_LEFT) . "-" . $tituloCarpeta;
	
	$capitulo = $row ['archivo'];
	
	$archivo = "Biblioteca/" . $tituloCarpeta . "/" . $capitulo;

$codigoYouTube = $row ['codigoYouTube'];
}

?>

	<body>
		<Div id="cuerpo">

			<?php
			// Mostramos el Numero de capitulo y el Titulo
			echo  '<h4>'.$row ['nrOrden'] . " - " . $row ['tituloCap'] . '</h4>'."<Br /><Br />";
			
			$ar = fopen ($archivo, "r") or die ("No se pudo abrir el archivo");
			echo "<div id='capitulo'>";
			
			$num_lineas = 0;
			while (! feof ($ar))
			{
				$linea = fgets ($ar);// or die ("No se pudo obtener la linea"); // Obtiene una l&#65533;nea desde el puntero a un fichero
				$lineasalto = nl2br ($linea);// or die ("No se pudo insertar el salto"); // Inserta saltos de l&#65533;nea HTML antes de todas las nuevas l&#65533;neas de un string
				
				if ($num_lineas > 3)
				{
					if ((mb_detect_encoding ($lineasalto, 'UTF-8', true)) == true)
					{
						$lineasalto = $lineasalto;
					}
					else
					{
						$lineasalto = utf8_encode ($lineasalto);
					}
					echo ($lineasalto); // Le indicamos que convierta el texto a utf8 para que reconzca acentos y &#65533;'s
				}
				
				$num_lineas = $num_lineas + 1;
			}
			echo "</div>";
			
			fclose ($ar);


if ($codigoYouTube != "")
{ 
echo '<Div align="center"><iframe width="200" height="113" src="https://www.youtube.com/embed/'. $codigoYouTube .'" frameborder="0" allowfullscreen></iframe></Div>';			
}
?>

<Br />
<Br />
<Br />
<Br />

</Div>
	</body>
</html>
		