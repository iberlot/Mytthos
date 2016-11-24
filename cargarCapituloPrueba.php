<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Admin
 *
 * Encargado de la carga y subida de capitulos 
 *
 */
require_once ("Config/includes.php");

$autorId = $_REQUEST ["autorId"];

$idSaga = $_REQUEST ["idSaga"];

$idLibro = $_REQUEST ["idLibro"];

$retTotal = $_REQUEST ["retTotal"];

echo "<table>\n";

$directorio = "Biblioteca";

$archivo = scandir ($directorio);

?>

<html>
<HEAD>
<TITLE>Carga de Capitulos</TITLE>
</HEAD>
<BODY>
	<div id='content'>
		<div id="separadorh"></div>
		<legend>
			<h3>Carga de Capitulos</h3>
		</legend>
		<div id="separadorh"></div>
		<div id='cuerpo' align='center'>
			<fieldset>
				<form method="POST" action="#" enctype="multipart/form-data">

					Autor:
					<br>
					<div class="ui-widget">
						<select name='idAutor' id='idAutor'>
								<?php
								$sqlAutor = "SELECT * FROM Autor";
								
								$result = mysqli_query ($link, $sqlAutor) or die ('Query error: ' . mysqli_error ($link));
								
								echo '<option value="">Elije un autor</option>';
								
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
					<br>
					Saga:
					<br>
					<div class="ui-widget">
						<select name='idSaga' id='idSaga'>
							<option value="">Elige un Autor</option>
						</select>
					</div>
					<br>
					Libro:
					<br>
					<div class="ui-widget">
						<select name='idLibro' id='idLibro'>
							<option value="0">Elige una Saga</option>
						</select>
					</div>
					<br>
					<br>
					<!--
							Rese&ntilde;a:
							<br>
							<textarea name="descripcion" rows="10" cols="40">Descripcion</textarea>
							<br><br>
						-->
					Archivo:
					<br>
					<input type=file multiple name="capitulo[]" id="capitulo">
					
					<div id="datosArchivos"></div>
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
	//$(document).ready(function() { $("#idSaga").select2(); });
	//$(document).ready(function() { $("#idLibro").select2(); });
	//$(document).ready(function() { $("#idAutor").select2(); });
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#idAutor").change(function(){
			$("#idSaga").load("dinamic/dinaSagas.php", {AUTOR: $("#idAutor").val()});
		});

		$(window).load(function(){
			$("#idSaga").load("dinamic/dinaSagas.php?idSaga=<?php echo $idSaga; ?>", {AUTOR: <?php echo $autorId; ?>});
		});
	});
	
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$("#idSaga").change(function(){
			$("#idLibro").load("dinamic/dinaLibros.php", {SAGA: $("#idSaga").val()});
		});
		
		$(window).load(function(){
			$("#idLibro").load("dinamic/dinaLibros.php?idLibro=<?php echo $idLibro; ?>", {SAGA: <?php echo $idSaga; ?>});
		});
	});
</script>

<script>
$("#capitulo").change(function(){

	var tam = document.getElementById("capitulo").files.length;
var i=1;
	//for (var i=0; i<tam; i++) 
	//{ 
		var nroArch = i+1;
		var nombreArchivo = document.getElementById("capitulo").files[i].name;
		
		var newdiv = document.createElement('div');
        newdiv.innerHTML = "<br>Orden del archivo <b>Nro "+ nroArch +"</b> <input type='text' name='orden["+i+"]' value='"+i+"' size='4'>   -  Titulo del capitulo <input type='text' name='titulo["+i+"]' value='"+nombreArchivo+"'>";

         document.getElementById('datosArchivos').appendChild(newdiv);

	//}  
});
</script> 
<?php
/**
 * inciamos el prosesamiento de datos en caso de que reciva el parametro "darDeAlta" en 1
 */

if ((isset ($_REQUEST ['darDeAlta'])) and ($_REQUEST ['darDeAlta'] == 1))
{
	
	
	if (isset ($_REQUEST ['idSaga']))
	{
		$idSaga = trim ($_REQUEST ['idSaga']);
	}
	if (isset ($_REQUEST ['idAutor']))
	{
		$idAutor = trim ($_REQUEST ['idAutor']);
	}
	if (isset ($_REQUEST ['idLibro']))
	{
		$idLibro = trim ($_REQUEST ['idLibro']);
		
		$sqlSaga = "SELECT * FROM Saga WHERE idSaga = $idSaga";
		$result = mysqli_query ($link, $sqlSaga) or die ('Query error: ' . mysqli_error ($link));
		$row2 = mysqli_fetch_array ($result, MYSQLI_ASSOC);
		
		$tituloSaga = trim ($row2 ['titulo']);
		
		$sqlLibro = "SELECT * FROM Libro WHERE idLibro = $idLibro";
		$resultLibro = mysqli_query ($link, $sqlLibro) or die ('Query error: ' . mysqli_error ($link));
		$rowLibro = mysqli_fetch_array ($resultLibro, MYSQLI_ASSOC);
		
		$tituloLibro = trim ($rowLibro ['titulo']);
		
		$tituloCarpeta = str_replace (' ', '_', $tituloLibro);
		
		$ordenLibro = $rowLibro ['ordenSaga'];
	}
	/*
	 * if (isset($_REQUEST['descripcion']))
	 * {
	 * $descripcion = trim($_REQUEST['descripcion']);
	 * }
	 */
	
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
	
	$tituloCarpeta = $direCarpeta . "/" . $tituloCarpetaSaga . "/" . str_pad ($ordenLibro, 2, "0", STR_PAD_LEFT) . "-" . $tituloCarpeta;
	
	// print($tituloCarpeta);
	
	if (! file_exists ("Biblioteca/" . $tituloCarpeta))
	{
		mkdir ("Biblioteca/" . $tituloCarpeta, 0775, true);
	}
	
	

	$tot = count ($_FILES ['capitulo'] ['name']);
	
	echo $tot;
	// Recorremos el arreglo
	for($i = 0; $i < $tot; $i ++)
	{
		echo $i;

			$orden = $_REQUEST ['orden'];

			print_r(get_defined_vars());
			
			echo "<Br /><Br /><Br /><Br /><Br /><Br /><Br />";
			exit;
		if (isset ($_REQUEST ['orden'][$i]))
		{
			$orden = trim ($_REQUEST ['orden'][$i]);
		}
		if (isset ($_REQUEST ['titulo'][$i]))
		{
			$titulo = trim ($_REQUEST ['titulo'][$i]);
			$titulo = ucfirst (strtolower ($titulo));
		}
		
		$nombre = str_pad ($orden, 2, "0", STR_PAD_LEFT) . "-" . str_replace (' ', '_', $titulo);
		
		$sqlInsertCap = "INSERT INTO Capitulo (
									nrOrden,
									titulo,
									idLibro,
									foto)
							 VALUES (
									'$orden',
									'$titulo',
									'$idLibro',
									'$nombre'
									)";
		
		if (mysqli_query ($link, $sqlInsertCap) or die ('Query error: ' . mysqli_error ($link)))
		{
			if (isset ($_FILES ['capitulo']) and $_FILES ['capitulo'] ['size'] > 1)
			{
			
				$nombre_tmp = $_FILES ['capitulo'] ['tmp_name'] [$i];
				$nombre = $_FILES ['capitulo'] ['name'] [$i];
				$tipo = $_FILES ['capitulo'] ['type'] [$i];
				$tamano = $_FILES ['capitulo'] ['size'] [$i];
				
				$ext_permitidas = array (
						'txt|doc|gif|png' 
				);
				$partes_nombre = explode ('.', $nombre);
				$extension = end ($partes_nombre);
				$ext_correcta = in_array ($extension, $ext_permitidas);
				
				$tipo_correcto = preg_match ('/^image\/(pjpeg|jpeg|gif|png|txt|doc|pdf|xls|sql|html|htm|php|sql)$/', $tipo);
				
				$limite = 50000 * 1024;
				
				if ($tamano <= $limite)
				{
					
					if ($_FILES ['capitulo'] ['error'] [$i] > 0)
					{
						echo 'Error: ' . $_FILES ['capitulo'] ['error'][$i] . '<br/>' . var_dump ($_FILES) . " en linea " . __LINE__;
					}
					else
					{
						
						$nombre = str_pad ($orden, 2, "0", STR_PAD_LEFT) . "-" . str_replace (' ', '_', $titulo);
						
						if (file_exists ($nombre))
						{
							echo '<br/>El archivo ya existe: ' . $nombre;
						}
						else
						{
							
							$estructura = "Biblioteca/" . $tituloCarpeta;
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
					echo 'Archivo inv&aacute;lido';
				}
			}
			
			
			if ($imagen == "")
			{
				$imagen = " ";
			}
			
			echo '<div id="dialog" title="Correcto" style="display: none;"><p>Datos Guardados!!!</p>';
			echo '</div>';
			if ($retTotal == 1)
			{
				header("location:Total.php");
			}
		}
	}
}
?>