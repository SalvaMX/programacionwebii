<?php
require_once 'librerias/database.php';
session_start();
$db = new Database();
$categorias = $db->obtenerCategorias();
	if (isset($_POST['id_video'])) {
		$db->quitarVideo($_POST['id_video']);
}
if (isset($_POST['id_curso_video'])) {
	$curso = $db->consultarCurso($_POST['id_curso_video']);
	$videos = $db->obtenerVideos($_POST['id_curso_video']);
	$datos = [
				"id_curso"    =>$_POST['id_curso_video'],
				"orden"       =>$_POST['orden'],
		"titulo"      =>$_POST['titulo'],
		"tiempo"      =>$_POST['tiempo'],
		"descripcion" =>$_POST['descripcion'],
		"url"         =>$_POST['url']
			];
	if ($db->agregarVideo($datos)) {
		// $_SESSION["alerta"] = '<p class="bien">Video "'.$_POST['titulo'].'"  agregado</p>';
	} else {
				// $_SESSION["alerta"] = '<p class="error">Error al agregar el video</p>';
	}
	$_SESSION['id_curso'] = $_POST['id_curso_video'];
		header("location: modificar-curso.php");
	
} else if (isset($_POST['id_curso_guardar'])) {
	// $curso = $db->consultarCurso($_POST['id_curso_guardar']);
	$datos = [
		"id_curso"      =>$_POST['id_curso_guardar'],
		"id_categoria"  =>$_POST['id_categoria'],
		"titulo"        =>$_POST['titulo'],
		"descripcion"   =>$_POST['descripcion'],
		"texto"         =>$_POST['texto'],
		"img_vista"     =>"",
		"img_contenido" =>""
			];
	if ($db->actualizarCurso($datos)) {
		$_SESSION["alerta"] = '<p class="bg-success rounded">Curso "'.$_POST['titulo'].'"  modificado</p>';
	} else {
		$_SESSION["alerta"] = '<p class="bg-danger rounded">Error al modificar el curso</p>';
			}
		header("location: consultar-cursos.php");
	} else if (isset($_POST['id_curso']) or isset($_SESSION['id_curso'])) {
	if (isset($_POST['id_curso'])) {
				$id_curso = $_POST['id_curso'];
	} else {
		$id_curso = $_SESSION['id_curso'];
	}
	$curso = $db->consultarCurso($id_curso);
		$videos = $db->obtenerVideos($id_curso);
	unset($_POST['id_curso']);
	unset($_SESSION['id_curso']);
}
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
							<h1 class="text-left">Modificar curso</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7 border rounded text-center my-3 bg-light">
			<form action="" method="POST">
				<input class="invisible" type="text" name="id_curso_guardar" value="<?= $id_curso ?>" readonly hidden>
				<div class="form-group">
					<label class="h5" for="categoria"><strong>Categoría:</strong></label>
					<select class="form-control" name="id_categoria">
						<?php foreach ($categorias as $id_categoria => $categoria): ?>
						<?php if ($id_categoria == $curso['id_categoria']): ?>
						<option selected value="<?= $id_categoria ?>"><?= $categoria['nombre_vista'] ?></option>
						<?php else: ?>
						<option value="<?= $id_categoria ?>"><?= $categoria['nombre_vista'] ?></option>
						<?php endif ?>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label class="h5" for="titulo"><strong>Título:</strong></label>
					<input class="form-control text-center" type="text" name="titulo" pattern=".{5,100}" placeholder="Nombre que llevará el curso" required value="<?= $curso['titulo'] ?>">
				</div>
				<div class="form-group">
					<label class="h5" for="descripcion"><strong>Descripción:</strong></label>
					<textarea class="form-control" name="descripcion" placeholder="Agrega una breve descripción"><?= $curso['descripcion'] ?></textarea>
				</div>
				<div class="form-group">
					<label class="h5" for="descripcion"><strong>Contenido:</strong></label>
					<textarea class="form-control" rows="10" name="texto" placeholder="Contenido del curso"><?= $curso['texto'] ?></textarea>
				</div>
				<div class="container row">
					<input class="btn btn-info btn-lg col-10 col-md-5 my-1 mx-auto" type="submit" value="Guardar">
					<a class="btn btn-danger btn-lg col-10 col-md-5 my-1 mx-auto" href="consultar-cursos.php">
						<div>Cancelar</div>
					</a>
				</div>
			</form>
		</div>
		<div class="container col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7 border rounded text-center my-3 bg-light">
			<h3>Videos</h3>
			<div class="container table-responsive bg-white">
				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">Orden</th>
							<th scope="col">Título</th>
							<th scope="col">Duración</th>
							<th scope="col">url</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($videos as $id_video => $video): ?>
						<tr>
							<td scope="row" nowrap class="numero"><strong><?= $video['orden'] ?></strong></td>
							<td nowrap class="titulo" title="<?= $video['titulo'] ?>"><?= substr($video['titulo'],0,20)."..." ?></td>
							<td nowrap class="tiempo"><?= $video['tiempo'] ?></td>
							<td nowrap class="url" title="<?= $video['url'] ?>"><?= "...".substr($video['url'],-11) ?></td>
							
							<td nowrap class="eliminar">
								<form action="" method="POST">
									<input class="id-oculta" type="text" name="id_curso" value="<?= $id_curso ?>" readonly hidden>
									<input class="id-oculta" type="text" name="id_video" value="<?= $id_video ?>" readonly hidden>
									<a class="h4 text-danger" href="#" onclick='this.parentNode.submit(); return false;'>
										<span title="Remover" class="icon-cancel-circle"></span>
									</a>
								</form>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				
			</div>
			<h3>Agregar video</h3>
			<form action="" method="POST">
				<input class="id-oculta" type="text" name="id_curso_video" value="<?= $id_curso ?>" readonly hidden>
				<input class="id-oculta" type="text" name="id_curso" value="<?= $id_curso ?>" readonly hidden>
				<div class="form-group">
					<label class="h5" for="orden"><strong>Orden:</strong></label>
					<input class="form-control text-center" type="number" name="orden" min="0" required placeholder="Asigna el orden del video">
				</div>
				<div class="form-group">
					<label class="h5" for="titulo"><strong>Título:</strong></label>
					<input class="form-control text-center" type="text" name="titulo" pattern="(.*){3,100}" required placeholder="Título del video">
				</div>
				<div class="form-group">
					<label class="h5" for="duracion"><strong>Duración:</strong></label>
					<input class="form-control text-center" type="text" name="tiempo" pattern="[0-9]{2}:[0-9]{2}:[0-9]{2}" title="" placeholder="hh:mm:ss" required>
				</div>
				<div class="form-group">
					<label class="h5" for="descripcion"><strong>Descripción:</strong></label>
					<input class="form-control text-center" type="text" name="descripcion" placeholder="Descripción breve del video (opcional)">
				</div>
				<div class="form-group">
					<label class="h5" for="url"><strong>URL del video:</strong></label>
					<input class="form-control text-center" type="text" name="url" title="" placeholder="https://www.youtube.com/watch?v=[11 caracteres]" pattern="https:\/\/www\.youtube\.com\/watch\?v=.{11}" required>
				</div>
				<div class="container row">
					<input class="col-7 btn btn-success btn-lg mx-auto mb-2" type="submit" value="Agregar">
				</div>
			</form>
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
		<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>