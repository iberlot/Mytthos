<?php

/**
 * 
 * @author iberlot <@> ivanberlot@gmail.com
 * @todo FechaC 25/11/2016 - Lenguaje PHP 
 * 
 * @todo cargas.php
 *
 * @todo 
 * @version 0.1 - Version de inicio 
 * @package  
 * @category 
 */

/*
 * Querido programador:
 *
 * Cuando escribi este codigo, solo Dios y yo sabiamos como funcionaba.
 * Ahora, Solo Dios lo sabe!!!
 *
 * Asi que, si esta tratando de 'optimizar' esta rutina y fracasa (seguramente),
 * por favor, incremente el siguiente contador como una advertencia para el
 * siguiente colega:
 *
 * totalHorasPerdidasAqui = 1
 *
 */


/**
 * inciamos el prosesamiento de datos en caso de que reciva el parametro "darDeAlta" en 1
 */

if((isset($_REQUEST['darDeAlta'])) and ($_REQUEST['darDeAlta'] == 1))
{
	if(isset($_REQUEST['apellido']))
	{
		$apellido = trim($_REQUEST['apellido']);
	}
	if(isset($_REQUEST['realname']))
	{
		$realname = trim($_REQUEST['realname']);
	}
	if(isset($_REQUEST['segname']))
	{
		$segname = trim($_REQUEST['segname']);
	}
	if(isset($_REQUEST['nac']))
	{
		$nac = trim($_REQUEST['nac']);
	}
	if(isset($_REQUEST['def']))
	{
		$def = trim($_REQUEST['def']);
	}
	if(isset($_REQUEST['nacion']))
	{
		$nacion = trim($_REQUEST['nacion']);
	}
	if(isset($_REQUEST['notas']))
	{
		$Notas = trim($_REQUEST['notas']);
		$Notas = htmlentities($Notas);
	}
	if(isset($_FILES['file1']) and $_FILES['file1']['size'] > 1)
	{
		$nombre_tmp = $_FILES['file1']['tmp_name'];
		$nombreArch = $_FILES['file1']['name'];
		$tipo = $_FILES['file1']['type'];
		$tamano = $_FILES['file1']['size'];

		$ext_permitidas = array (
				'pjpeg|jpeg|gif|png'
		);
		$partes_nombre = explode('.', $nombreArch);
		$extension = end($partes_nombre);
		$ext_correcta = in_array($extension, $ext_permitidas);

		$tipo_correcto = preg_match('/^image\/(pjpeg|jpeg|gif|png|txt|doc|pdf|xls|sql|html|htm|php|sql)$/', $tipo);

		$limite = 50000 * 1024;

		if($tamano <= $limite)
		{
			if($_FILES['file1']['error'] > 0)
			{
				echo 'Error: ' . $_FILES['file1']['error'] . '<br/>' . var_dump($_FILES) . " en linea " . __LINE__;
			}
			else
			{
				if(file_exists($nombreArch))
				{
					echo '<br/>El archivo ya existe: ' . $nombreArch;
				}
				else
				{
					$estructura = "fotosAutores";
					if(file_exists($estructura))
					{
						move_uploaded_file($nombre_tmp, $estructura . "/" . $nombreArch) or die(" Error en move_uploaded_file " . var_dump(move_uploaded_file) . " en linea " . __LINE__);
						chmod($estructura . "/" . $nombreArch, 0775);
					}
					else
					{
						mkdir($estructura, 0777, true);
						move_uploaded_file($nombre_tmp, $estructura . "/" . $nombreArch) or die(" Error en move_uploaded_file " . var_dump(move_uploaded_file) . " en linea " . __LINE__);
						chmod($estructura . "/" . $nombreArch, 0775);
					}
				}
			}
		}
		else
		{
			echo 'Archivo inválido';
		}
	}

	if($segname != "")
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

	$result = mysqli_query($link, $sqlInsertAutor) or die('Query error: ' . mysqli_error($link));

	if($result)
	{
		mkdir("Biblioteca/" . $tituloCarpeta, 0775, true);

		?>
<div id="dialog" title="Correcto" style='display: none;'>
	<p>Datos Guardados!!!</p>
</div>
<?php
	}
}

?>	


?>