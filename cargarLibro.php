<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Admin
 *
 * Encargado de la carga de libros 
 *
 */
require_once ("Config/includes.php");

$idSaga = $_REQUEST ["idSaga"];

$retTotal = $_REQUEST ["retTotal"];

echo "<table>\n";

$directorio = "Biblioteca";

$archivo = scandir ($directorio);

?>

<html>
<HEAD>
<TITLE>Carga de Libros</TITLE>
</HEAD>
<BODY>
	<div id='content'>
		<div id="separadorh"></div>
		<legend>
			<h3>Carga de Libros</h3>
		</legend>
		<div id="separadorh"></div>
		<div id='cuerpo' align='center'>
			<fieldset>
				<form method="POST" action="#" enctype="multipart/form-data">

					Orden: <br> 
					<input type="number" name="orden"> 
					<br> 
					<br> Titulo: <br> 
					<input type="text" name="titulo"> 
					<br> 
					<br> Saga: <br>
					<div class="ui-widget">
						<select name='idSaga' id='idSaga'>
								<?php
								$sqlSaga = "SELECT * FROM Saga";
								
								$result = mysqli_query ($link, $sqlSaga) or die ('Query error: ' . mysqli_error ($link));
								
								while ($row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC))
								{
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
								?>
								</select>
					</div>
					<br> 
					<br> Cantidad de Capitulos: <br> 
					<input type="number" name="cantCapitulos"> 
					<br> 
					<br> A&ntilde;o: <br> 
					<input type="number" min="1400" max="2016" name="anioEdicion"> 
					<br> 
					<br> Rese&ntilde;a: <br>
					<textarea name="descripcion" rows="10" cols="40">Descripcion</textarea>
					<br> 
					<br> Imagen: <br> 
					<input type=file name="imagen">

					<br> 
					<br> Direccion YouTube: <br> <input type="text" name="Youtube"> 
					<br> 
					<br> 
					<input type='hidden' name='retTotal' value='<?php echo $retTotal; ?>'> 
					<input type='hidden' name='darDeAlta' value='1'> 
					<input type="Submit" value="Dar de Alta">

				</form>

			</fieldset>
		</div>
	</div>
</BODY>
</html>
<script>
	$(document).ready(function() { $("#idSaga").select2(); });
</script>

<?php
/**
 * inciamos el prosesamiento de datos en caso de que reciva el parametro "darDeAlta" en 1
 */

if ((isset ($_REQUEST ['darDeAlta'])) and ($_REQUEST ['darDeAlta'] == 1))
{
	if (isset ($_REQUEST ['orden']))
	{
		$orden = trim ($_REQUEST ['orden']);
	}
	if (isset ($_REQUEST ['titulo']))
	{
		$titulo = trim ($_REQUEST ['titulo']);
		$titulo = ucfirst (strtolower ($titulo));
	}
	if (isset ($_REQUEST ['idSaga']))
	{
		$idSaga = trim ($_REQUEST ['idSaga']);
		
		$sqlSaga = "SELECT * FROM Saga WHERE idSaga = $idSaga";
		$result = mysqli_query ($link, $sqlSaga) or die ('Query error: ' . mysqli_error ($link));
		$row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC);
		
		$tituloSaga = trim ($row2 ['titulo']);
		$idAutor = trim ($row2 ['idAutor']);
	}
	if (isset ($_REQUEST ['cantCapitulos']))
	{
		$cantCapitulos = trim ($_REQUEST ['cantCapitulos']);
	}
	if (isset ($_REQUEST ['anioEdicion']))
	{
		$anioEdicion = trim ($_REQUEST ['anioEdicion']);
	}
	if (isset ($_REQUEST ['descripcion']))
	{
		$descripcion = trim ($_REQUEST ['descripcion']);
		$descripcion = htmlentities ($descripcion, ENT_QUOTES);
		$descripcion = htmlspecialchars ($descripcion, ENT_QUOTES);
	}

	if (isset ($_REQUEST ['Youtube']))
	{
		$codigoYouTube = trim ($_REQUEST ['Youtube']);
	}
	if (isset ($_FILES ['imagen']) and $_FILES ['imagen'] ['size'] > 1)
	{
		$nombre_tmp = $_FILES ['imagen'] ['tmp_name'];
		$nombre = $_FILES ['imagen'] ['name'];
		$tipo = $_FILES ['imagen'] ['type'];
		$tamano = $_FILES ['imagen'] ['size'];
		
		$ext_permitidas = array (
				'pjpeg|jpeg|gif|png' 
		);
		$partes_nombre = explode ('.', $nombre);
		$extension = end ($partes_nombre);
		$ext_correcta = in_array ($extension, $ext_permitidas);
		
		$tipo_correcto = preg_match ('/^image\/(pjpeg|jpeg|gif|png|txt|doc|pdf|xls|sql|html|htm|php|sql)$/', $tipo);
		
		$limite = 50000 * 1024;
		
		if ($tamano <= $limite)
		{
			if ($_FILES ['imagen'] ['error'] > 0)
			{
				echo 'Error: ' . $_FILES ['imagen'] ['error'] . '<br/>' . var_dump ($_FILES) . " en linea " . __LINE__;
			}
			else
			{
				if (file_exists ($nombre))
				{
					echo '<br/>El archivo ya existe: ' . $nombre;
				}
				else
				{
					$estructura = "fotosLibros";
					if (file_exists ($estructura))
					{
						move_uploaded_file ($nombre_tmp, $estructura . "/" . str_replace (' ', '_', $titulo) . "." . $extension) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . str_replace (' ', '_', $titulo . "." . $extension), 0775);
					}
					else
					{
						mkdir ($estructura, 0777, true);
						move_uploaded_file ($nombre_tmp, $estructura . "/" . str_replace (' ', '_', $titulo) . "." . $extension) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . str_replace (' ', '_', $titulo . "." . $extension), 0775);
					}
				}
			}
			$imagen = str_replace (' ', '_', $titulo);
$imagen = $imagen . "." . $extension;
		}
		else
		{
			echo 'Archivo inválido';
		}
	}
	
	if ($imagen == "")
	{
		$imagen = " ";
	}
	
	$sqlAutor = "SELECT * FROM Autor WHERE idAutor = $idAutor";
	
	$result = mysqli_query ($link, $sqlAutor) or die ('Query error: ' . mysqli_error ($link));
	
	$row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC);
	
	$apellido = trim ($row2 ['apellido']);
	$realname = trim ($row2 ['nombre']);
	$segname = trim ($row2 ['segNombre']);
	
	if ($segname != "")
	{
		$direCarpeta = $apellido . "_" . $realname . "_" . $segname;
	}
	else
	{
		$direCarpeta = $apellido . "_" . $realname;
	}
	
	$tituloCarpetaSaga = str_replace (' ', '_', $tituloSaga);
	$tituloCarpeta = str_replace (' ', '_', $titulo);
	
	$tituloCarpeta = $direCarpeta . "/" . $tituloCarpetaSaga . "/" . str_pad ($orden, 2, "0", STR_PAD_LEFT) . "-" . $tituloCarpeta;
	
	// print($tituloCarpeta);
	
	if (! file_exists ("Biblioteca/" . $tituloCarpeta))
	{
		mkdir ("Biblioteca/" . $tituloCarpeta, 0775, true);
	}
	
	$sqlInsertLibro = "INSERT INTO Libro(
								titulo,
								idAutor,
								idSaga,
								ordenSaga,
								cantCap,
								anio,
								resenia,
								imagen,
ListaDeRepr)
						   VALUES (
								'$titulo',
								'$idAutor',
								'$idSaga',
								'$orden',
								'$cantCapitulos',
								'$anioEdicion',
								'$descripcion',
								'$imagen',
'$codigoYouTube'
								 )";
	
	if (mysqli_query ($link, $sqlInsertLibro) or die ('Query error: ' . mysqli_error ($link) . '  -  ' .$sqlInsertLibro))
	{
		echo '<div id="dialog" title="Correcto" style="display: none;"><p>Datos Guardados!!!</p>';
		echo '</div>';
		if($retTotal == 1)
		{
			header("location:Total.php");
		}
	}
}

/* liberar la serie de resultados */
@mysqli_free_result ($result);

/* cerrar la conexión */
mysqli_close ($link);
?>