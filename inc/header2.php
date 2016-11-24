
 <nav id="menu" class="noPrint">
<a id="logo" href="#">Mytthos</a>
<a class="nav-mobile" id="nav-mobile" href="#"></a>
	<ul class="Estilo3">
		<li><a href="autores.php">Autores&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
		<li><a href="sagas.php">Sagas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
		<li><a href="titulos.php">Titulos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
		<li><a href="Total.php">Listado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>

<?php 
if($_SESSION ['estado'] == 'Iniciada')
{ ?>
		<li><a href="cargarAutor.php">Cargar Autor</a></li>
		<li><a href="cargarSaga.php">Cargar Sagas</a></li>
		<li><a href="cargarLibro.php">Cargar Libro</a></li>
		<li><a href="cargarCapitulo.php">Cargar Capitulo</a></li>
<?php } ?>
	</ul>
</nav>


<script>
    $(function() {

        var btn_movil = $('#nav-mobile'),
            menu = $('#menu').find('ul');

        // Al dar click agregar/quitar clases que permiten el despliegue del men�
        btn_movil.on('click', function (e) {
            e.preventDefault();

            var el = $(this);

            el.toggleClass('nav-active');
            menu.toggleClass('open-menu');
        })

    });
</script>