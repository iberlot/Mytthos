<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category General
 *
 * Encargado de cargar los datos de los autores 
 *
 */

require_once ("Config/includes.php");

echo "<table>\n";

$directorio = "Biblioteca";

$archivo = scandir ($directorio);

?>

<html>
	<HEAD>
		<TITLE>Carga de Autore</TITLE>
	</HEAD>
	<BODY>
		<div id='content'>
			<div id="separadorh"></div>
			<legend>
				<h3>Carga de Autores</h3>
			</legend>
			<div id="separadorh"></div>
			<div id='cuerpo' align='center'>
				<fieldset>
					<form method="POST" action="#" enctype="multipart/form-data">
	
						Apellido: <br> <input type="text" name="apellido"> <br> <br> Nombre: <br> <input type="text" name="realname"> <br> <br> Segundo Nombre: <br> <input type="text" name="segname"> <br> <br> Fecha de Nacimiento: <br> <input type="date" name="nac"> <br> <br> Fecha de Defuncion: <br> <input type="date" name="def"> <br> <br> Nacionalidad: <br>
						<div class="ui-widget">
							<select name='nacion' id='nacion'>
								<?php
								$sqlNacionalidad = "SELECT * FROM gentilicios";
								
								echo $sqlNacionalidad;
								
								$result = mysqli_query ($link, $sqlNacionalidad) or die ('Query error: ' . mysqli_error ($link));
								
								while ($row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC))
								{
									$combobit2 = ' <option value=' . $row2 ['idGentilicio'] . '>' . substr ($row2 ['nombreGentilicio'], 0, 50) . '	(' . substr ($row2 ['Pais'], 0, 50) . ') </option>'; // concatenamos el los options para luego ser insertado en el HTML
									echo $combobit2;
								}
								?>
								</select>
						</div>
						<br> <br> Notas: <br>
						<textarea name="notas" rows="10" cols="40">Notas</textarea>
						<br> <br> Imagen: <br> <input type=file name="file1"><br> <br> <input type='hidden' name='darDeAlta' value='1'> <input type="Submit" value="Dar de Alta">
	
					</form>
	
				</fieldset>
			</div>
		</div>
	</BODY>
</html>
<script>
	$(document).ready(function() { $("#nacion").select2(); });
</script>

<?php
/**
 * inciamos el prosesamiento de datos en caso de que reciva el parametro "darDeAlta" en 1
 */

if ((isset ($_REQUEST ['darDeAlta'])) and ($_REQUEST ['darDeAlta'] == 1))
{
	if (isset ($_REQUEST ['apellido']))
	{
		$apellido = trim ($_REQUEST ['apellido']);
	}
	if (isset ($_REQUEST ['realname']))
	{
		$realname = trim ($_REQUEST ['realname']);
	}
	if (isset ($_REQUEST ['segname']))
	{
		$segname = trim ($_REQUEST ['segname']);
	}
	if (isset ($_REQUEST ['nac']))
	{
		$nac = trim ($_REQUEST ['nac']);
	}
	if (isset ($_REQUEST ['def']))
	{
		$def = trim ($_REQUEST ['def']);
	}
	if (isset ($_REQUEST ['nacion']))
	{
		$nacion = trim ($_REQUEST ['nacion']);
	}
	if (isset ($_REQUEST ['notas']))
	{
		$Notas = trim ($_REQUEST ['notas']);
		$Notas = htmlentities($Notas);
	}
	if (isset ($_FILES ['file1']) and $_FILES ['file1'] ['size'] > 1)
	{
		$nombre_tmp = $_FILES ['file1'] ['tmp_name'];
		$nombreArch = $_FILES ['file1'] ['name'];
		$tipo = $_FILES ['file1'] ['type'];
		$tamano = $_FILES ['file1'] ['size'];
		
		$ext_permitidas = array (
				'pjpeg|jpeg|gif|png' 
		);
		$partes_nombre = explode ('.', $nombreArch);
		$extension = end ($partes_nombre);
		$ext_correcta = in_array ($extension, $ext_permitidas);
		
		$tipo_correcto = preg_match ('/^image\/(pjpeg|jpeg|gif|png|txt|doc|pdf|xls|sql|html|htm|php|sql)$/', $tipo);
		
		$limite = 50000 * 1024;
		
		if ($tamano <= $limite)
		{
			if ($_FILES ['file1'] ['error'] > 0)
			{
				echo 'Error: ' . $_FILES ['file1'] ['error'] . '<br/>' . var_dump ($_FILES) . " en linea " . __LINE__;
			}
			else
			{
				if (file_exists ($nombreArch))
				{
					echo '<br/>El archivo ya existe: ' . $nombreArch;
				}
				else
				{
					$estructura = "fotosAutores";
					if (file_exists ($estructura))
					{
						move_uploaded_file ($nombre_tmp, $estructura . "/" . $nombreArch) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . $nombreArch, 0775);
					}
					else
					{
						mkdir ($estructura, 0777, true);
						move_uploaded_file ($nombre_tmp, $estructura . "/" . $nombreArch) or die (" Error en move_uploaded_file " . var_dump (move_uploaded_file) . " en linea " . __LINE__);
						chmod ($estructura . "/" . $nombreArch, 0775);
					}
				}
			}
		}
		else
		{
			echo 'Archivo inválido';
		}
	}
	
	if ($segname != "")
	{
		$tituloCarpeta = $apellido . "_" . $realname . "_" . $segname;
	}
	else
	{
		$tituloCarpeta = $apellido . "_" . $realname;
	}
	
	$sqlInsertAutor = "INSERT INTO Autor(
								apellido,
								nombre,
								segNombre,
								fechaNac,
								fechaDec,
								nacionalidad,
								notas,
								foto)
							VALUES (
								'$apellido',
								'$realname',
								'$segname',
								'$nac',
								'$def',
								'$nacion',
								'$Notas',
								'$nombre'
								 )";
	
	$result = mysqli_query ($link, $sqlInsertAutor) or die ('Query error: ' . mysqli_error ($link));
	
	if ($result)
	{
		mkdir ("Biblioteca/" . $tituloCarpeta, 0775, true);
		
		?>
<div id="dialog" title="Correcto" style='display: none;'>
	<p>Datos Guardados!!!</p>
</div>
<?php
	}
}

?>	