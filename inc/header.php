<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Bliblioteca Online</title>
	<meta name="viewport" content="width=device-width"/>
<?php /**
	<script type="text/javascript">
		var adfly_id = 8019214;
		var adfly_advert = 'adfly_advert';
		var frequency_cap = 5;
		var frequency_delay = 5;
		var init_delay = 3;
		var popunder = true;
	</script>
	<script src="https://cdn.adf.ly/js/entry.js"></script>

*/ ?>

	<script language='javascript' src='js/jquery-2.1.4.js'></script>

    <link href="js/select2-3.5.4/select2.css" rel="stylesheet" />
    <script src="js/select2-3.5.4/select2.min.js"></script>
    <script src="js/textReader.jquery.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />


<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
  (adsbygoogle = window.adsbygoogle || []).push({
    google_ad_client: "ca-pub-3577918067888586",
    enable_page_level_ads: true
  });
</script>

</head>

<header>

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
</header>


<script>
    $(function() {

        var btn_movil = $('#nav-mobile'),
            menu = $('#menu').find('ul');

        // Al dar click agregar/quitar clases que permiten el despliegue del menú
        btn_movil.on('click', function (e) {
            e.preventDefault();

            var el = $(this);

            el.toggleClass('nav-active');
            menu.toggleClass('open-menu');
        })

    });
</script>
<div id="separador" class="separador">
<br>&nbsp;&nbsp;
</div>		