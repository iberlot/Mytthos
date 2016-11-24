<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Admin
 *
 * Modulo que muestra el arbol total de libros y da la posibilidad de su insercion. 
 *
 */
require_once ("Config/includes.php");

$rowArchivo = "";
?>
<head>
<script type="text/javascript">
			var abrirenVentanaNueva = 0;
			
			var tagApartado = 'a';
			var docActual = location.href;
			function iniciaMenu(menu){
				idMenu = menu
				menu = document.getElementById(menu);
				for(var m = 0; m < menu.getElementsByTagName('ul').length; m++){
					el = menu.getElementsByTagName('ul')[m]
					el.style.display = 'none';
					el.className = 'menuDoc';
					el.parentNode.className = 'cCerrada'
					textoNodo = el.parentNode.firstChild.nodeValue;
					nuevoNodo = document.createElement(tagApartado);
					if(tagApartado == 'a') nuevoNodo.href = '#' + textoNodo;
					nuevoNodo.className = 'tagApartado';
					nuevoNodo.appendChild(document.createTextNode(textoNodo));
					el.parentNode.replaceChild(nuevoNodo,el.parentNode.firstChild);
					nuevoNodo.onclick = function(){
						hijo = sacaPrimerHijo(this.parentNode, 'ul')
						hijo.style.display = hijo.style.display == 'none' ? 'block' : 'none';
						if(this.parentNode.className == 'cCerrada' || this.parentNode.className == 'cAbierta'){
							this.parentNode.className = this.parentNode.className == 'cCerrada' ? 'cAbierta' : 'cCerrada'
						}
						else{
							this.parentNode.className = this.parentNode.className == 'cAbiertaSeleccionada' ? 'cCerradaSeleccionada' : 'cAbiertaSeleccionada' 
						}
						return false;
					}
				}
				documentoActual(idMenu)
			}
			function sacaPrimerHijo(obj, tag){
				for(var m = 0; m < obj.childNodes.length; m++){
					if(obj.childNodes[m].tagName && obj.childNodes[m].tagName.toLowerCase() == tag){
						return obj.childNodes[m];
						break;
					}
				}
			}
			function documentoActual(menu){
				idMenu = menu
				menu = document.getElementById(menu);
				for(var s = 0; s < menu.getElementsByTagName('a').length; s++){
					if(abrirenVentanaNueva) menu.getElementsByTagName('a')[s].target = 'blank';
					enlace = menu.getElementsByTagName('a')[s].href
					if(enlace == docActual){
						menu.getElementsByTagName('a')[s].parentNode.className = 'documentoActual'
					}
					if(enlace == docActual && menu.getElementsByTagName('a')[s].parentNode.parentNode.id != idMenu){
						menu.getElementsByTagName('a')[s].parentNode.parentNode.parentNode.className = 'cAbiertaSeleccionada'
						var enlaceCatPadre = sacaPrimerHijo(menu.getElementsByTagName('a')[s].parentNode.parentNode.parentNode, 'a')
						enlaceCatPadre.onclick = function(){
							hijo = sacaPrimerHijo(this.parentNode, 'ul')
							hijo.style.display = hijo.style.display == 'none' ? 'block' : 'none';
							this.parentNode.className = this.parentNode.className == 'cAbiertaSeleccionada' ? 'cCerradaSeleccionada' : 'cAbiertaSeleccionada' 
							return false;
			
						} 
						nodoSig = sacaPrimerHijo(menu.getElementsByTagName('a')[s].parentNode.parentNode.parentNode, 'ul')
						nodoSig.style.display = 'block';/**/
						abrePadre(idMenu, enlaceCatPadre.parentNode)
					}
				}
			}
			function abrePadre(idmenu, obj){
				obj.parentNode.parentNode.className = 'cAbiertaSeleccionada'
				var nodoSig = sacaPrimerHijo(obj, 'ul')
				nodoSig.style.display = 'block';
				if(obj.parentNode.id != idmenu){
					abrePadre(idmenu, obj.parentNode.parentNode)
				}
			}
		</script>

<style type="text/css">
<!--
#menu1 {
	font-size: 90%;
	list-style-image: url(/inc/doct.gif);
	border: 1px solid #006699;
	width: 200px;
	padding-top: .5em;
	padding-bottom: .5em;
	list-style: inside;
}

html body #menu1 {
	list-style: outside;
}

.cAbierta {
	list-style-type: none;
	list-style-image: url(/inc/carpabiertat.gif);
}

.cAbiertaSeleccionada {
	list-style-type: none;
	list-style-image: url(/inc/carpabiertasel.gif);
}

.cCerradaSeleccionada {
	list-style-type: none;
	list-style-image: url(/inc/carpcerradasel.gif);
}

.cCerrada {
	list-style-type: none;
	list-style-image: url(/inc/carpcerradat.gif);
}

.menuDoc {
	list-style-type: none;
	list-style-image: url(/inc/doct.gif);
}

.tagApartado, a.tagApartado {
	cursor: pointer;
	font-weight: bold;
	text-decoration: none;
}

.documentoActual {
	list-style-image: url(/inc/docsel.gif);
}

#menu1 a {
	color: #006699;
}

.documentoActual a {
	color: #993300;
}
-->
</style>
</head>
<div id='content'>
	<div id='cuerpo'>
		<ul id='miMenu'>
					<?php
					
					$equery = "SELECT * FROM Autor ORDER BY apellido";
					$result = mysqli_query ($link, $equery) or die ('Query error: ' . mysqli_error ($link));
					
					while ($row = mysqli_fetch_array ($result, MYSQLI_ASSOC))
					{
						if ($row ['segNombre'] != "")
						{
							$nombre = trim ($row ['apellido']) . "_" . trim ($row ['nombre']) . "_" . trim ($row ['segNombre']);
							$nombreTitulo = trim ($row ['apellido']) . ", " . trim ($row ['nombre']) . " " . trim ($row ['segNombre']);
						}
						else
						{
							$nombre = trim ($row ['apellido']) . "_" . trim ($row ['nombre']);
							$nombreTitulo = trim ($row ['apellido']) . ", " . trim ($row ['nombre']);
						}
						
						$nombre = str_replace (' ', '_', $nombre);
						
						$idAutor = $row ['idAutor'];
						
						echo "<!--" . substr ($nombreTitulo, 0, 50) . "-->";
						echo "<li>" . $nombreTitulo;
					if ($_SESSION ['estado'] == 'Iniciada')
									{	
echo "   <a href='cargarSaga.php?autorId=" . $idAutor . "&retTotal=1' >Agregar Saga</a>";
}
						echo "<ul>";
						
						/*
						 * A Partir de aca realizamos la carga de las sagas
						 */
						
						$sqlSagas = "SELECT * FROM Saga WHERE idAutor = $idAutor"; // ORDER BY titulo";
						$resultSagas = mysqli_query ($link, $sqlSagas) or die ('Query error: ' . mysqli_error ($link));
						
						while ($rowSaga = mysqli_fetch_array ($resultSagas, MYSQLI_ASSOC))
						{
							
							$idSaga = trim ($rowSaga ["idSaga"]);
							
							$tituloSaga = trim ($rowSaga ["titulo"]);
							
							$tituloLink = str_replace (' ', '_', $tituloSaga);
							
							echo "<!-- Saga $tituloSaga -->";
							echo "<li>" . $tituloSaga;
							if ($_SESSION ['estado'] == 'Iniciada')
									{
echo "   <a href='cargarLibro.php?idSaga=" . $idSaga . "&retTotal=1' >Agregar Libro</a>";
}
							echo "<ul>";
							
							$sqlLibro = "SELECT * FROM Libro WHERE idAutor = $idAutor and idSaga = $idSaga ORDER BY ordenSaga";
							$resultLibro = mysqli_query ($link, $sqlLibro) or die ('Query error: ' . mysqli_error ($link));
							
							while ($rowLibro = mysqli_fetch_array ($resultLibro, MYSQLI_ASSOC))
							{
								
								$idLibro = $rowLibro ["idLibro"];
								
								$tituloLibro = trim ($rowLibro ["titulo"]);
								
								$ordenLibro = $rowLibro ["ordenSaga"];
								
								$tituloLibroLink = str_pad ($ordenLibro, 2, "0", STR_PAD_LEFT) . "-" . str_replace (' ', '_', $titulo);
								
								echo "<!-- Saga $tituloLibro -->";
								echo "<li>" . $tituloLibro;
if ($_SESSION ['estado'] == 'Iniciada')
									{
								//echo "   <a id="opener">Agregar Capitulo</a>";
								echo "   <a href='cargarCapitulo.php?idSaga=" . $idSaga . "&autorId=" . $idAutor . "&idLibro=" . $idLibro . "&retTotal=1' >Agregar Capitulo</a>";
							}	
echo "<ul>";
								
								$sqlCapitulo = "SELECT * FROM Capitulo WHERE idLibro = $idLibro ORDER BY nrOrden";
								$resultCapitulo = mysqli_query ($link, $sqlCapitulo) or die ('Query error: ' . mysqli_error ($link));
								
								while ($rowCapitulo = mysqli_fetch_array ($resultCapitulo, MYSQLI_ASSOC))
								{
									
									$idCapitulo = $rowCapitulo ['idCapitulo'];
									
									$tituloCapitulo = str_pad ($rowCapitulo ['nrOrden'], 2, "0", STR_PAD_LEFT) . "-" . trim ($rowCapitulo ['titulo']);
									
									echo "<li>";
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
									echo "</li>";
								}
								
								echo "</ul></li>";
							}
							echo "</ul></li>";
						}
						echo "</ul>";
						echo "</li>";
					}
					?>
				</ul>

</div>
	<!--end of cuerpo-->


</div>
<!--end of content-->
<script type="text/javascript" xml:space="preserve">
			<!--
			iniciaMenu('miMenu');
			//-->
		</script>



<?php

/* liberar la serie de resultados */
mysqli_free_result ($result);
mysqli_free_result ($resultSagas);
mysqli_free_result ($resultLibro);
mysqli_free_result ($resultCapitulo);

/* cerrar la conexi&#65533;n */
mysqli_close ($link);
?>