<?php
$tokenUnicoBD = "101452";

if (isset ( $_POST ["token"] ))
{
	// Con el token que se guarda en session despues del login ya podes saber quien es la persona y tenes los datos en la base
	$tokenSession = $_POST ["token"];
}
else
{
	$tokenSession = "";
}
if (isset ( $_POST ["funcion"] ))
{
	$funcion = $_POST ["funcion"];
}
else
{
	$funcion = "";
}


if ($tokenUnicoBD == $tokenSession)
{
	
	include_once ("Config/variables.php"); // incluimos el archivo que contiene las variables
	include_once ("Config/config.php"); // incluimos el archivo de configuracion
	include_once ("Config/conect.php"); // incluimos el archivo de conexion
	include_once ("Config/funciones.php"); // incluimos el archivo que va a contener todas las funciones del sistem

	if ($funcion == 'header')
	{
		include_once ("inc/header2.php");
	}
	elseif ($funcion == 'autores')
	{
		$directorio = "Biblioteca";
		
		$archivo = scandir ( $directorio );
		
		$equery = "SELECT * FROM Autor ORDER BY Apellido";
		$result = mysqli_query ( $link, $equery ) or die ( 'Query error: ' . mysqli_error ( $link ) );
		
		while ($row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ))
		{
			if ($row ['segNombre'] != "")
			{
				$nombre = trim ( $row ['nombre'] ) . "_" . trim ( $row ['segNombre'] );
				$nombreTitulo = trim ( $row ['nombre'] ) . " " . trim ( $row ['segNombre'] );
			}
			else
			{
				$nombre = trim ( $row ['nombre'] );
				$nombreTitulo = trim ( $row ['nombre'] );
			}
			
			$nombre = str_replace ( ' ', '_', $nombre );
			
			//$dato .= "<li><a href='sagas.php?autorId=" . $row ['idAutor'] . "'>" . $row ['apellido'] . ", " . $nombreTitulo . "</a></li><Br/>";
				
			$dato .= "<li><a href='?funcion=sagas&autorId=" . $row ['idAutor'] . "'>" . $row ['apellido'] . ", " . $nombreTitulo . "</a></li><Br/>";
		}
		echo $dato;
	}
	elseif ($funcion == 'footer')
	{
		include_once ("inc/footer2.php");
	}
	mysqli_close ( $link );
}

?>