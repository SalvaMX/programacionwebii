<?php
require_once 'librerias/database.php';
session_start();
$db = new Database();
$categorias = $db->obtenerCategorias();
if ($_POST) {
	$datos = [
		"id_categoria"  =>$_POST['id_categoria'],
		"titulo"        =>$_POST['titulo'],
		"descripcion"   =>$_POST['descripcion'],
		"texto"         =>$_POST['texto'],
		"img_vista"     =>"",
		"img_contenido" =>""
			];
	if ($db->insertarCurso($datos)) {
		$_SESSION["alerta"] = '<p class="bg-success rounded">Curso creado</p>';
	} else {
				$_SESSION["alerta"] = '<p class="bg-danger rounded">Error al crear el curso</p>';
		}
	header("location: administrar.php");
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
							<h1 class="text-left">Agregar curso</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container col-12 col-sm-10 col-md-9 col-lg-8 col-xl-7 border rounded text-center my-3 bg-light">
			<form action="" method="POST">
				<div class="form-group">
					<label class="h5" for="categoria"><strong>Categoría:</strong></label>
					<select class="form-control" name="id_categoria">
						<?php foreach ($categorias as $id_categoria => $categoria): ?>
						<option value="<?= $id_categoria ?>"><?= $categoria['nombre_vista'] ?></option>
						<?php endforeach ?>
					</select>
				</div>
				<div class="form-group">
					<label class="h5" for="titulo"><strong>Título:</strong></label>
					<input class="form-control" type="text" name="titulo" pattern=".{5,100}" placeholder="Nombre que llevará el curso" required>
				</div>
				<div class="form-group">
					<label class="h5" for="descripcion"><strong>Descripción:</strong></label>
					<textarea class="form-control" name="descripcion" placeholder="Agrega una breve descripción"></textarea>
				</div>
				<div class="form-group">
					<label class="h5" for="descripcion"><strong>Contenido:</strong></label>
					<textarea class="form-control" rows="10" name="texto" placeholder="Contenido del curso"></textarea>
				</div>
				<div class="container row">
					<input class="btn btn-info btn-lg col-10 col-md-5 my-1 mx-auto" type="submit" value="Crear curso">
					<a class="btn btn-danger btn-lg col-10 col-md-5 my-1 mx-auto" href="administrar.php">
						<div>Cancelar</div>
					</a>
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