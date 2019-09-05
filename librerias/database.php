<?php

/**
 * Clase que establece la conexión con la base de datos
 */
class Database
{
	
	private $host;
	private $db;
	private $user;
	private $password;
	private $charset;

	function __construct()
	{
		//////////////
		//Localhost	//
		//////////////
		$this->host     = "localhost";
		$this->db       = "programacionweb";
		$this->user     = "root";
		$this->password = "";
		$this->charset  = "utf8mb4";

		//////////////////////
		//Infinityfree host //
		//////////////////////
		// $this->host     = "sql306.epizy.com";
		// $this->db       = "epiz_24253209_programacionwebunadm";
		// $this->user     = "epiz_24253209";
		// $this->password = "ZECPjZbMvfdVLD";
		// $this->charset  = "utf8mb4";
	}

	function conectar()
	{
		try {
			$conexion = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
			$opciones = [
				PDO::ATTR_ERRMODE          => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false,
			];

			$pdo = new PDO($conexion, $this->user, $this->password, $opciones);

			// echo " - Conexion relizada con la BD - ";
			return $pdo;
			
		} catch (PDOException $e) {
			echo 'Error de conexión' . $e->getMessage();
			return false;			
		}
	}

	function obtenerCursos()
	{		
		$items = [];
		try {
			$pdo = $this->conectar();			
			$sentencia = "SELECT *
							FROM cursos";							
			$consulta = $pdo->query($sentencia);
			while ($fila = $consulta->fetch()) {
				$id_curso = $fila["id_curso"];			
				$items[$id_curso] = [
									"id_categoria"  => $fila["id_categoria"],
									"titulo"        => $fila["titulo"],
									"descripcion"   => $fila["descripcion"],
									"texto"         => $fila["texto"],
									"img_vista"     => $fila["img_vista"],
									"img_contenido" => $fila["img_contenido"]											
									];
				//Extraer el tiempo total de los videos del curso
				$sentencia = "SELECT SUM(TIME_TO_SEC(tiempo)) AS total_tiempos,
									 COUNT(id_video) AS num_videos
								FROM videos
							   WHERE id_curso=:id_curso";
				$consulta_videos = $pdo->prepare($sentencia);
				$consulta_videos->execute(["id_curso" => $id_curso]);
				$fila2 = $consulta_videos->fetch();

				$items[$id_curso]["total_tiempo"] = $fila2["total_tiempos"];
				$items[$id_curso]["num_videos"]   = $fila2["num_videos"];


			}			
			return $items;
		} catch (PDOException $e) {			
			return [];
		}
	}

	function consultarCurso($id_curso)
	{
		$item = [];
		try {
			$pdo = $this->conectar();			
			$sentencia = "SELECT *
							FROM cursos
						   WHERE id_curso=:id_curso";							
			$consulta = $pdo->prepare($sentencia);
			$consulta->execute(["id_curso" => $id_curso]);

			while ($fila = $consulta->fetch()) {
				$id_curso = $fila["id_curso"];			
				$item = [
						"id_curso"      => $id_curso,
						"id_categoria"  => $fila["id_categoria"],
						"titulo"        => $fila["titulo"],
						"descripcion"   => $fila["descripcion"],
						"texto"         => $fila["texto"],
						"img_vista"     => $fila["img_vista"],
						"img_contenido" => $fila["img_contenido"]
					];
				
			}			
			return $item;
		} catch (PDOException $e) {			
			return [];
		}
	}

	function insertarCurso($datos)
	{
		try {
			$pdo = $this->conectar();		
			$sentencia = "INSERT INTO cursos (id_categoria,
											  titulo,
											  descripcion,
											  texto,
											  img_vista,
											  img_contenido)
							   VALUES (:id_categoria,
							   		   :titulo,
							   		   :descripcion,
							   		   :texto,
							   		   :img_vista,
							   		   :img_contenido)";
			$consulta = $pdo->prepare($sentencia);
			$consulta->execute([
								'id_categoria'  => $datos["id_categoria"],
								'titulo'        => $datos["titulo"],
								'descripcion'   => $datos["descripcion"],
								'texto'         => $datos["texto"],
								'img_vista'     => $datos["img_vista"],
								'img_contenido' => $datos["img_contenido"]
							   ]);			
			return true;
		} catch (PDOException $e) {			
			return false;
		}
	}

	function obtenerVideos($id_curso)
	{
		$items = [];
		try {
			$pdo = $this->conectar();			
			$sentencia = "SELECT *
							FROM videos
						   WHERE id_curso=:id_curso";							
			$consulta = $pdo->prepare($sentencia);
			$consulta->execute(["id_curso" => $id_curso]);

			while ($fila = $consulta->fetch()) {				
				$items[$fila["id_video"]] = [						
							"orden"      => $fila["orden"],
							"titulo"      => $fila["titulo"],
							"tiempo"      => $fila["tiempo"],
							"descripcion" => $fila["descripcion"],
							"url"         => $fila["url"]
						];				
			}			
			return $items;
		} catch (PDOException $e) {			
			return [];
		}
	}

	function agregarVideo($datos)
	{
		try {
			$pdo = $this->conectar();		
			$sentencia = "INSERT INTO videos (id_curso,
											  orden,
											  titulo,
											  tiempo,
											  descripcion,
											  url)
							   VALUES (:id_curso,
							   		   :orden,
							   		   :titulo,
							   		   :tiempo,
							   		   :descripcion,
							   		   :url)";
			$consulta = $pdo->prepare($sentencia);
			$consulta->execute([
								'id_curso'    => $datos["id_curso"],
								'orden'       => $datos["orden"],
								'titulo'      => $datos["titulo"],
								'tiempo'      => $datos["tiempo"],
								'descripcion' => $datos["descripcion"],
								'url'         => $datos["url"]
							   ]);			
			return true;
		} catch (PDOException $e) {			
			return false;
		}
	}

	function quitarVideo($id_video)
	{
		try {
			$pdo = $this->conectar();
			$sentencia = "DELETE FROM videos
								WHERE id_video = :id_video";
			$consulta = $pdo->prepare($sentencia);			
			$consulta->execute(['id_video' => $id_video]);	
			
			return true;
		} catch (PDOException $e) {			
			return false;
		}
	}

	function borrarCurso($id_curso)
	{
		try {
			$pdo = $this->conectar();
			$pdo->beginTransaction(); //Iniciar transacción

			$sentencia = "DELETE FROM videos
								WHERE id_curso = :id_curso";
			$consulta = $pdo->prepare($sentencia);			
			$consulta->execute(['id_curso' => $id_curso]);			

			$sentencia = "DELETE FROM cursos
								WHERE id_curso = :id_curso";
			$consulta = $pdo->prepare($sentencia);			
			$consulta->execute(['id_curso' => $id_curso]);

			$pdo->commit(); //terminar transacción
			return true;
		} catch (PDOException $e) {			
			$pdo->rollBack(); //Deshacer en caso de error
			return false;
		}
	}

	function actualizarCurso($datos)
	{
		try {
			$pdo = $this->conectar();
			$sentencia = "UPDATE cursos
							SET 
								id_categoria  = :id_categoria,
								titulo        = :titulo,
								descripcion   = :descripcion,
								texto         = :texto,
								img_vista     = :img_vista,
								img_contenido = :img_contenido
						  WHERE id_curso = :id_curso";			
			$consulta = $pdo->prepare($sentencia);			
			$consulta->execute([
				'id_curso'      => $datos['id_curso'],				
				'id_categoria'  => $datos['id_categoria'],
				'titulo'        => $datos['titulo'],
				'descripcion'   => $datos['descripcion'],
				'texto'         => $datos['texto'],
				'img_vista'     => $datos['img_vista'],
				'img_contenido' => $datos['img_contenido']
			]);
					
			return true;
		} catch (PDOException $e) {			
			return false;
		}
	}

	function obtenerCategorias()
	{
		$items = [];

		try {
			$pdo = $this->conectar();
			$sentencia = "SELECT *
							FROM categorias";			
			$consulta = $pdo->query($sentencia);			
			while ($fila = $consulta->fetch()) {				
				$items[$fila['id_categoria']] = [
								'nombre_clase' => $fila['nombre_clase'],
								'nombre_vista' => $fila['nombre_vista'],
								'icono'        => $fila['icono'],
								'imagen'       => $fila['imagen'],
								'descripcion'  => $fila['descripcion']
											  	];
			}
			return $items; 
			
		} catch (PDOException $e) {			
			return [];
		}
	}
}

?>