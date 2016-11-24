<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Admin
 *
 * Archivo encargado de la edicion de los textos de los capitulos
 *
 */
require_once ("Config/includes.php");

if (isset ($_REQUEST ["idCapitulo"]))
{
	$idCapitulo = $_REQUEST ['idCapitulo'];
	
	//echo $idCapitulo;
	
	$sql = "SELECT
            	    Capitulo.idCapitulo idCapitulo,
            	    Capitulo.nrOrden nrOrden,
            	    Capitulo.titulo tituloCap,
            	    Capitulo.foto archivo,
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
}
// $archivo = "Biblioteca/".$autor."/".$saga."/".$titulo."/".$capitulo;

// echo $archivo;

if (isset ($_POST ["submit"]))
{
	if ($fp = fopen ($archivo, "w"))
	{
		if ((mb_detect_encoding ($_POST ["newdata"], 'UTF-8', true)) == true)
		{
			$newdata = $_POST ["newdata"];
		}
		else
		{
			$newdata = utf8_encode ($_POST ["newdata"]);
		}
		fwrite ($fp, stripslashes ($newdata));
		fclose ($fp);
	}
}
?>

<body>
	<Div id="cuerpo">
<Div align="center">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- EditarCapitulos -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-3577918067888586"
     data-ad-slot="1795124956"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
</Div>

		<legend>Editar "<?php echo $row['tituloLibro']; ?>"</legend>
		<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
			<textarea name="newdata" rows="50" style="margin: 0px; width: 100%;">
				<?php
				$ar = fopen ($archivo, "r") or die ("No se pudo abrir el archivo");
				while (! feof ($ar))
				{
					$linea = fgets ($ar); // or die("No se pudo obtener la linea"); //Obtiene una línea desde el puntero a un fichero
					                      // $lineasalto=nl2br($linea) or die("No se pudo insertar el salto"); // Inserta saltos de línea HTML antes de todas las nuevas líneas de un string
					$lineasalto = $linea;
					
					if ((mb_detect_encoding ($lineasalto, 'UTF-8', true)) == true)
					{
						$lineasalto = $lineasalto;
					}
					else
					{
						$lineasalto = mb_convert_encoding ($lineasalto, "UTF-8");
					}
					
					echo $lineasalto; // Le indicamos que convierta el texto a utf8 para que reconzca acentos y ñ's
				}
				fclose ($ar);
				?>
			</textarea>
			<input type='text' name='idCapitulo' value='<?php echo $idCapitulo; ?>' style='display: none' />
			<Br />
			<Br />
			<input type="submit" name="submit" value="Guardar">
		</form>

	</Div>

</body>
</html>
