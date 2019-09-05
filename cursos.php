<?php
require_once 'librerias/database.php';
function conversorSegundosHoras($tiempo_en_segundos) {
	$horas = floor($tiempo_en_segundos / 3600);
	$minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
	$segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
	return $horas . ':' . $minutos . ":" . $segundos;
}
$db = new Database();
$categorias = $db->obtenerCategorias();
$cursos = $db->obtenerCursos();
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
		<div class="container-fluid bg-light p-0">
			<div class="row align-items-center mx-0">
				<img src="recursos/principal.jpg" class="col-12 col-lg-6 figure-img img-fluid mb-0 px-0" alt="..." width="100%">
				<div class="col-12 col-lg-6 container-fluid text-dark px-0">
					<div class="row mx-0">
						<div class="col-3 col-sm-4">
							<img class="float-right" src="recursos/tudesarrollo-logo.png" width="60px">
						</div>
						<div class="col-9 col-sm-8">
							<h1 class="text-left">¿Que curso necesitas?</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style type="text/css">
			.opciones:hover {
				cursor: pointer;
			}
		</style>
		<ul class="nav nav-tabs nav-fill flex-column flex-sm-row justify-content-center">
			<li class="nav-item">
				<a class="nav-link opciones" id="capacitacion"  onclick="buscarCursos('capacitacion')">Capacitación</a>
			</li>
			<li class="nav-item">
				<a class="nav-link opciones" id="talleres" onclick="buscarCursos('talleres')">Talleres</a>
			</li>
			<li class="nav-item">
				<a class="nav-link opciones" id="diplomados" onclick="buscarCursos('diplomados')">Diplomados</a>
			</li>
			<li class="nav-item">
				<a class="nav-link opciones" id="conferencias" onclick="buscarCursos('conferencias')">Conferencias</a>
			</li>
			<li class="nav-item">
				<a class="nav-link opciones" id="desarrollo" onclick="buscarCursos('desarrollo')">Desarrollo</a>
			</li>
		</ul>
		<div class="container col-12 col-sm-9 col-xl-7 align-items-center">
			<span id="filtro-resultado"></span>
			
			<?php foreach ($cursos as $id_curso => $curso): ?>
			<article class="<?= $categorias[$curso['id_categoria']]['nombre_clase'] ?>">
				<div class="container row border rounded my-3 text-center m-0 p-0 shadow">
					<div class="col-12 col-lg-6 col-xl-5">
						<img class="rounded my-2" src="recursos/<?= $categorias[$curso['id_categoria']]['imagen'] ?>" alt="" width="100%">
						<form action="curso.php" method="POST">
							<input class="id-oculta" type="text" name="id_curso" value="<?= $id_curso ?>" readonly hidden>
							<a class="btn btn-info btn-lg col-8 py-2 mb-lg-2" href="#" onclick='this.parentNode.submit(); return false;'>
								<div>Entra YA!</div>
							</a>
						</form>
					</div>
					
					<div class="col-12 col-lg-6">
						<div class="row align-items-center">
							<div class="col-10 col-md-6 col-lg-7 pl-md-5 px-lg-0 mx-auto text-justify text-info">
								<h2 class="text-center"><?= $curso['titulo']."&nbsp" ?></h2>
								<p class="h5"><span class="h3 icon-play2"></span> <?= $curso['num_videos']." videos" ?></p>
								<p class="h5"><span class="h3 icon-clock"></span> <?= conversorSegundosHoras($curso['total_tiempo'])."&nbsp" ?></p>
								<p class="h6"><span class="h3 icon-file-text"></span> <?= $curso['descripcion']."&nbsp" ?></p>
							</div>
							<div class="col-12 col-md-6 col-lg-5" title="<?= $categorias[$curso['id_categoria']]['nombre_vista'] ?>">
								<span class="h1 display-1 text-secondary icon-<?= $categorias[$curso['id_categoria']]['icono'] ?>"></span>
							</div>
						</div>
					</div>
				</div>
			</article>
			
			<?php endforeach ?>
			
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
			function buscarCursos(tipoCurso) {
				var elemento;
				var cursos = [];
				var opciones = new Array(5);
				opciones[0] = "capacitacion";
				opciones[1] = "talleres";
				opciones[2] = "diplomados";
				opciones[3] = "conferencias";
				opciones[4] = "desarrollo";
				for (var i = 0; i < opciones.length; i++) {
					elemento = document.getElementById(opciones[i]);
					elemento.style.color = "#6077C4";
					elemento.style.background = "none";
				}
				elemento = document.getElementById(tipoCurso);
				elemento.style.color = "#E3E3E3";
				elemento.style.background = "#6077C4";
				
				cursos = document.getElementsByTagName('article');
				for (var i = 0; i < cursos.length; i++) {
					if (tipoCurso == cursos[i].className) {
						cursos[i].style.display = "flex";
					} else {
						cursos[i].style.display = "none";
					}
				}
				document.getElementById("filtro-resultado").scrollIntoView(true);
			}
		</script>
		<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>