<?php 
	
	session_start();
	include "../conexion.php";
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 ) // Solo Admi y Supervisores pueden ver
	{ 
		header("location: ./");
	}

	if(!empty($_POST))
	{
		$alert='';
		if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario'])  || empty($_POST['rol']))
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idUsuario 	= $_POST['idUsuario'];
			$nombre 	= $_POST['nombre'];
			$email  	= $_POST['correo'];
			$user   	= $_POST['usuario'];
			$clave  	= md5($_POST['clave']);
			$rol    	= $_POST['rol'];

			
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
					$sql_update = mysqli_query($conection,"UPDATE usuario
															SET nombre = '$nombre', correo='$email',usuario='$user',clave='$clave', rol='$rol'
															WHERE idusuario= $idUsuario ");

				}
	

				if($sql_update){
				
					$alert='<p class="msg_save">Usuario actualizado correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al actualizar el usuario.</p>';
				}

			}


		}

	}

	//Mostrar Datos
	if(empty($_REQUEST['id']))
	{
		header('Location: lista_usuarios.php');
		mysqli_close($conection);
	}
	$iduser = $_REQUEST['id'];

	$sql= mysqli_query($conection,"SELECT u.idusuario, u.nombre,u.correo,u.usuario, (u.rol) as idrol, (r.rol) as rol
									FROM usuario u
									INNER JOIN rol r
									on u.rol = r.idrol
									WHERE idusuario= $iduser ");
	mysqli_close($conection);
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

			if($idrol == 1){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
			}else if($idrol == 2){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';	
			}else if($idrol == 3){
				$option = '<option value="'.$idrol.'" select>'.$rol.'</option>';
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
				<input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data['foto']; ?>">
				<input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data['foto']; ?>">

				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre completo" value="<?php echo $nombre; ?>">
				
				<label for="correo">Correo electrónico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo electrónico" value="<?php echo $correo; ?>">
				
				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario" value="<?php echo $usuario; ?>">
				
				<label for="clave">Contraseña</label>
				<input type="password" name="clave" id="clave" placeholder="Contraseña de acceso">
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
				
				
				<input type="submit" value="Actualizar usuario" class="btn_save">
				<a href="lista_usuarios.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>

			</form>


		</div>


	</section>
	<?php include "includes/footer.php"; ?>
</body>
</html>