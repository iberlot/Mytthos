<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Admin
 *
 * Encargado de realizar la carga de Sagar para un autor X
 *
 */
require_once ("Config/includes.php");

$autorId = $_REQUEST ["autorId"];

$retTotal = $_REQUEST ["retTotal"];

echo "<table>\n";

$directorio = "Biblioteca";

$archivo = scandir ($directorio);

?>

<html>
<HEAD>
<TITLE>Carga de Sagas</TITLE>
</HEAD>
<BODY>
	<div id='content'>
		<div id="separadorh"></div>
		<legend>
			<h3>Carga de Sagas</h3>
		</legend>
		<div id="separadorh"></div>
		<div id='cuerpo' align='center'>
			<fieldset>
				<form method="POST" action="#" enctype="multipart/form-data">

					Titulo: <br> <input type="text" name="titulo"> <br> <br> Autor: <br>
					<div class="ui-widget">
						<select name='idAutor' id='idAutor'>
								<?php
								$sqlAutor = "SELECT * FROM Autor";
								
								$result = mysqli_query ($link, $sqlAutor) or die ('Query error: ' . mysqli_error ($link));
								
								while ($row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC))
								{
									if ($autorId == $row2 ['idAutor'])
									{
										$sel = ' selected="selected" ';
									}
									else
									{
										$sel = '';
									}
									$combobit2 = ' <option value=' . $row2 ['idAutor'] . $sel . '>' . substr ($row2 ['apellido'], 0, 50) . ',	' . substr ($row2 ['nombre'], 0, 50) . ' </option>'; // concatenamos el los options para luego ser insertado en el HTML
									echo $combobit2;
								}
								?>
								</select>
					</div>
					<br> <br> Cantidad de Libros: <br> <input type="number" name="cantLibros"> <br> <br> Descripcion: <br>
					<textarea name="descripcion" rows="10" cols="40">Descripcion</textarea>
					<br> <br> Imagen: <br> 
					<input type=file name="imagen"><br> <br> 
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
	$(document).ready(function() { $("#idAutor").select2(); });
</script>

<?php
/**
 * inciamos el prosesamiento de datos en caso de que reciva el parametro "darDeAlta" en 1
 */

if ((isset ($_REQUEST ['darDeAlta'])) and ($_REQUEST ['darDeAlta'] == 1))
{
	if (isset ($_REQUEST ['titulo']))
	{
		$titulo = trim ($_REQUEST ['titulo']);
		$titulo = ucfirst (strtolower ($titulo));
	}
	if (isset ($_REQUEST ['idAutor']))
	{
		$idAutor = trim ($_REQUEST ['idAutor']);
	}
	if (isset ($_REQUEST ['cantLibros']))
	{
		$cantLibros = trim ($_REQUEST ['cantLibros']);
	}
	if (isset ($_REQUEST ['descripcion']))
	{
		$descripcion = trim ($_REQUEST ['descripcion']);
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
					$estructura = "fotosSagas";
					if (file_exists ($estructura))
					{
						move_uploaded_file ($nombre_tmp, $estructura . "/" . $nombre) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . $nombre, 0775);
					}
					else
					{
						mkdir ($estructura, 0777, true);
						move_uploaded_file ($nombre_tmp, $estructura . "/" . $nombre) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . $nombre, 0775);
					}
				}
			}
			$imagen = $nombre;
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
	
	$tituloCarpeta = str_replace (' ', '_', $titulo);
	$tituloCarpeta = $direCarpeta . "/" . $tituloCarpeta;
	
	print ($tituloCarpeta);
	
	if (! file_exists ("Biblioteca/" . $tituloCarpeta))
	{
		mkdir ("Biblioteca/" . $tituloCarpeta, 0775, true);
	}
	
	$sqlInsertSaga = "INSERT INTO Saga(
								titulo,
								idAutor,
								cantLibros,
								descripcion,
								imagen)
							VALUES (
								'$titulo',
								'$idAutor',
								'$cantLibros',
								'$descripcion',
								'$imagen'
								 )";
	
	if (mysqli_query ($link, $sqlInsertSaga) or die ('Query error: ' . mysqli_error ($link)))
	{
		echo '<div id="dialog" title="Correcto" style="display: none;"><p>Datos Guardados!!!</p>';
		echo '</div>';
		if($retTotal == 1)
		{
			header("location:Total.php");
		}
	}
}

?>