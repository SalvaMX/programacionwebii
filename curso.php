<?php
require_once 'librerias/database.php';
$db = new Database();
$categorias = $db->obtenerCategorias();
$curso = $db->consultarCurso($_POST['id_curso']);
$videos = $db->obtenerVideos($_POST['id_curso']);
$videos_orden = [];
foreach ($videos as $id_video => $video) {
	$videos_orden[$video['orden']] = [
		"titulo"      => $video['titulo'],
		"tiempo"      => $video['tiempo'],
		"descripcion" => $video['descripcion'],
		"url"         => $video['url']
	];
}
ksort($videos_orden);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Evidencias de Aprendizaje</title>
		<link rel="stylesheet" type="text/css" href="estilos/icomoon.css">
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<header>
			<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
				<a class="navbar-brand" href="index.html"><span class="icon-home"></span> Inicio</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a class="nav-link" href="cursos.php"><span class="icon-bookmarks"></span> Cursos <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="quienes-somos.html"><span class="icon-question"></span> Quienes somos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="administrar.php"><span class="icon-cog"></span> Administrar</a>
						</li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="container-fluid col-12 col-sm-11 border rounded my-3 p-1 bg-light">
			<?php foreach ($videos_orden as $orden => $video): ?>
			<div class="row" id="<?= $orden ?>">
				<div class="container col-12 col-lg-8 text-center">
					<a class="btn btn-primary btn-lg col-12 col-md-5 my-1 mr-md-3 py-1" href="#">
						<div class="row align-items-center">
							<div class="col-6 text-left h2 m-0"><span class="icon-facebook2"></span></div>
							<div class="col-6 text-right h5 m-0 p-2">Compartir</div>	
						</div>
					</a>
					<a class="btn btn-info btn-lg col-12 col-md-5 my-1 ml-md-3 py-1" href="#">
						<div class="row align-items-center">
							<div class="col-6 text-left h2 m-0"><span class="icon-twitter"></span></div>
							<div class="col-6 text-right h5 m-0 p-2">Compartir</div>	
						</div>
					</a>					
					<div class=" col-12 rounded embed-responsive embed-responsive-16by9">
						<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= substr($video['url'], -11) ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>					
				</div>
				<div class="container col-12 col-lg-4 text-center px-0">
					<a class="btn btn-info btn-lg col-11 my-1 py-1" href="cursos.php"><strong>Volver</strong></a>
					<div class="col-10 col-lg-12 mx-auto">
						<h1 class="h2"><?= $curso['titulo'] ?></h1>
						<h3 class="text-info h4"><?= $video['titulo'] ?></h2>
						<p class="h4 text-info"><span class="icon-play2"></span> Video <?= $orden ?>/<?= count($videos) ?></p>
						<p class="h4 text-info"><span class="icon-clock"></span> <?= $video['tiempo']  ?></p>
						<p class="text-info text-justify"><?= $video['descripcion'] ?></p>
						
					</div>
					<div class="row px-2 pr-lg-3">
						<a class="btn btn-primary btn-lg col-5 mx-auto" onclick="mostrar(<?= $orden - 1 ?>)" href="#"><div class="anterior">Anterior</div></a>
						<a class="btn btn-primary btn-lg col-5 mx-auto" onclick="mostrar(<?= $orden + 1 ?>)" href="#"><div class="siguiente">Siguiente</div></a>						
					</div>
				</div>
			</div>
			<?php endforeach ?>
		</div>
			
		<div class="container-fluid col-12 col-sm-11 border rounded my-3 p-1 bg-light">
			<div class="row">
				<div class="col-12 col-lg-8">					
					<div class="row m-0">
						<a class="btn btn-danger btn-lg col-12 my-1 mr-md-3" href="#">
							<div class="row align-items-center">
								<div class="col-6 text-left h2 m-0"><span class="icon-youtube"></span></div>
								<div class="col-6 text-right h5 m-0 p-1">Subscribirse</div>	
							</div>
						</a>
					</div>
					<div class="row m-1">
						<p class="col-12 text-justify"><?= substr($curso['texto'],0, strlen($curso['texto'])/2) ?></p>
					</div>
					<div class="row m-1">				
						<img class="col-12" src="recursos/demo.png" alt="" width="100%">
					</div>
					<div class="row m-1">
						<p class="col-12 text-justify"><?= substr($curso['texto'],strlen($curso['texto'])/2) ?></p>		
					</div>			
				</div>
				<aside class="col-12 col-lg-4 mt-lg-5 pt-lg-4 border-left">							
					<div class="list-group">
						<label class="h5" for="descripcion"><strong>Lista de videos:</strong></label>						
						<?php foreach ($videos_orden as $orden => $video): ?>			
						<a class="list-group-item list-group-item-action" onclick="mostrar(<?= $orden ?>)" href="#"><strong class="h5"><?= $orden.".</strong> ".$video['titulo'] ?></a>					
						<?php endforeach ?>					
					</div>
				</aside>				
			</div>
		</div>
		<footer class="container-fluid text-center bg-dark text-white">
			<div class="row align-items-center">
				<div class="col-sm-12 col-md-6 h6"><small>TuDesarrollo - Cursos de Capacitación, Calle #Número, Colonia, Culiacán, Sinaloa, México., Tel: (66) 7XX XXXX / (667) 1XX XXXX, http://programacionwebunadm.epizy.com, Sitio web elaborado por Mario Salvador Ramírez Guillén, © Todos los derechos reservados</small></div>
				<div class="col-sm-12 col-md-6">
					<a class="text-white h2 mx-3" id="youtube" href="#"><span class="icon-youtube"></a>
					<a class="text-white h2 mx-3" id="facebook" href="#"><span class="icon-facebook2"></a>
					<a class="text-white h2 mx-3" id="twitter" href="#"><span class="icon-twitter"></a>
				</div>
			</div>
		</footer>		
		<script type="text/javascript">
			orden = <?= json_encode(array_keys($videos_orden)) ?>;
			var videos = new Array(orden.length);
			window.onload = function() {
				for (var i = 0; i < orden.length; i++) {
					videos[i] = document.getElementById(orden[i]);
					videos[i].style.display = "none";		
				}
				videos[0].style.display = "flex";				
			}
			function mostrar(id_div) {			
				if (id_div >= orden[0] && id_div <= orden[orden.length-1]) {
					for (var i = 0; i < orden.length; i++) {
						if (id_div == videos[i].id) {
							videos[i].style.display = "flex";
						} else {
							videos[i].style.display = "none";
						}
					}
				}
			}
		</script>
		<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>