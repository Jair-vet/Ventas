<?php
	session_start();
	include "../conexion.php";
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 ) // Solo Admi y Supervisores pueden ver
	{ 
		header("location: ./");
	}

	if(!empty($_POST))
	{
		//print_r($_FILES); // verificar lo que trae post  por medio del arraglo.
		$alert='';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])  || empty($_POST['rol']) || empty($_POST['id']) || empty($_POST['foto_actual']) || empty($_POST['foto_remove'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$codproducto  = $_POST['idUsuario'];
			$nombre       = $_POST['nombre'];
			$email 	      = $_POST['correo']; 
			$user  	      = $_POST['usuario'];
			$clave  	  = $_POST['clave'];
			$imgProducto  = $_POST['foto_actual'];
			$imgRemove    = $_POST['foto_remove'];

			$foto        = $_FILES['foto'];
			$nombre_foto = $foto['name'];
			$type		 = $foto['type'];
			$url_temp	 = $foto['tmp_name'];

			$upd = ''; //opcional png

			// Validacion para la foto jpg
			if($nombre_foto != '')
			{
				$destino      = 'img/uploads/';  // dentro de la carpeta de mi archivo
				$img_nombre   = 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto  = $img_nombre.'jpg';  // fotos deben ser jpg.
				$src 		  = $destino.$imgProducto; // almacenar la imagen en cualquier formato que venga
			}else{
				if($_POST['foto_actual'] != $_POST['foto_remove']){
					$imgProducto = 'img_adm.png';
				}
			}

			$query = mysqli_query($conection,"SELECT * FROM usuario 
													   WHERE (usuario = '$user' AND idusuario != $idUsuario)
													   OR (correo = '$email' AND idusuario != $idUsuario) ");

			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{
				if(empty($_POST['clave']))
				{

					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET nombre = '$nombre', correo='$email',usuario='$user',rol='$rol'
															WHERE idusuario= $idUsuario ");
				}else{
					$query_update = mysqli_query($conection, "UPDATE usuario
														SET nombre = '$nombre',
															correo = '$email',
															user = $usuario,
															foto = '$imgProducto'
														WHERE idusuario = $idUsuario");
				}
				if($query_update){

					if(($nombre_foto != '' && ($_POST['foto_actual'] != 'img_adm.png')) || ($_POST['foto_actual'] != $_POST['foto_remove']))
					{
						unlink('img/uploads2/'.$_POST['foto_actual']);
					}

					if($nombre_foto != '')
					{
						move_uploaded_file($url_temp,$src); // almcena la ruta del archivo y lo mueve a la nueva ruta
					}
					$alert='<p class="msg_save">Producto Actualizado Correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al Actualizar al Producto.</p>'; 
				}
			}
		}
	}

	// Validar Producto
	if(empty($_REQUEST['id'])){
		header("location: lista_usuarios.php");
	}else{
		$iduser = $_REQUEST['id'];
		if(!is_numeric($id_producto)){
			header("location: lista_usuarios.php");
		}

		$sql= mysqli_query($conection,"SELECT u.idusuario, u.nombre,u.correo,u.usuario,u.foto, (u.rol) as idrol, (r.rol) as rol
									FROM usuario u
									INNER JOIN rol r
									on u.rol = r.idrol
									WHERE idusuario= $iduser ");
		$result_sql = mysqli_num_rows($sql);

		$foto = '';
		$classRemove = 'notBlock';

		if($result_sql == 0){
		header('Location: lista_usuarios.php');
		}else{
			$option = '';
			while ($data = mysqli_fetch_array($sql)) {
				# code...
				$iduser  = $data['idusuario'];
				$nombre  = $data['nombre'];
				$correo  = $data['correo'];
				$usuario = $data['usuario'];
				$idrol   = $data['idrol'];
				$rol     = $data['rol'];
				$foto    = $data['foto'];

				if($idrol == 1){
					$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
				}else if($idrol == 2){
					$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';	
				}else if($idrol == 3){
					$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
				}

				if($data['foto'] != 'img_adm.png'){
					$classRemove = '';
					$foto = '<img id="img" src="img/uploads2/'.$data['foto'].'" alt="Producto">';
				}
			}

		}
	}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Actualizar Usuario</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		
		<div class="form_register">
			<h1>Actualizar usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" method="post">
				<input type="hidden" name="idUsuario" value="<?php echo $iduser; ?>">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
				<label for="correo">Correo electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
				<label for="clave">Clave</label>
				<input type="password" name="clave" id="clave" placeholder="Clave de acceso">
				<label for="rol">Tipo Usuario</label>

				<?php 
					include "../conexion.php";
					$query_rol = mysqli_query($conection,"SELECT * FROM rol");
					mysqli_close($conection);
					$result_rol = mysqli_num_rows($query_rol);

				 ?>

				<select name="rol" id="rol" class="notItemOne">
					<?php
						echo $option; 
						if($result_rol > 0)
						{
							while ($rol = mysqli_fetch_array($query_rol)) {
					?>
							<option value="<?php echo $rol["idrol"]; ?>"><?php echo $rol["rol"] ?></option>
					<?php 
								# code...
							}
							
						}
					 ?>
				</select>
				
				<div class="photo">
					<label for="foto">Foto</label>
				        <div class="prevPhoto">
				        <span class="delPhoto <?php echo $classRemove; ?> ">X</span>
				        <label for="foto"></label>
				         <?php echo $foto; ?>
				        </div>
				        <div class="upimg">
				        <input type="file" name="foto" id="foto">
				        </div>
				        <div id="form_alert"></div>
				</div>
				<input type="submit" value="Actualizar usuario" class="btn_save">
				<a href="lista_usuarios.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>