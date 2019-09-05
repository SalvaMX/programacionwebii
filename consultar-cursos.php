<?php
require_once 'librerias/database.php';
session_start();
$db = new Database();
$cursos = $db->obtenerCursos();
$categorias = $db->obtenerCategorias();
if (isset($_POST['id_curso'])) {	
	$db->borrarCurso($_POST['id_curso']);
	header("location: consultar-cursos.php");
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
							<h1 class="text-left">Consultar cursos</h1>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="container table-responsive col-12 col-sm-11 col-md-10 col-lg-9 col-xl-8 border rounded text-center my-3 bg-light">
			<div class="row">
				<div class="text-white text-center col-11 col-sm-10 col-md-9 col-lg-8 col-xl-7 mx-auto">
					<?php
					if (isset($_SESSION['alerta'])) {
						echo $_SESSION['alerta'];
													$_SESSION['alerta'] = "";
					}
					?>
				</div>
			</div>
			<table class="table table-hover">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Título</th>
						<th scope="col">Categoría</th>
						<th scope="col" colspan="2">Opciones</th>
					</tr>
				</thead>
				<tbody>
					<?php $i=1; foreach ($cursos as $id_curso => $curso): ?>
					<tr>
						<td scope="row"><strong><?php echo $i; $i++ ?></strong></td>
						<td nowrap><?= $curso['titulo'] ?></td>
						<td nowrap><?= $categorias[$curso['id_categoria']]['nombre_vista'] ?></td>
						<td nowrap>
							<form action="modificar-curso.php" method="POST">
								<input type="text" name="id_curso" value="<?= $id_curso ?>" readonly hidden>
								<a class="h4 text-success" href="#" onclick='this.parentNode.submit(); return false;'>
									<span title="Modificar" class="icon-pencil"></span>
								</a>
							</form>
						</td>
						<td nowrap>
							<form action="" method="POST">
								<input type="text" name="id_curso" value="<?= $id_curso ?>" readonly hidden>
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