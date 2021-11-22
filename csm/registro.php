<?php
	include "conexion.php";
	if(!empty($_POST))
	{
		$alert=' ';
		if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) || empty($_POST['clave'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{


			$nombre = $_POST['nombre'];
			$email  = $_POST['correo'];
			$user   = $_POST['usuario'];
			$clave  = md5($_POST['clave']);
			$rol    = '3';


			$query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario = '$user' OR correo = '$email'");
			$result = mysqli_fetch_array($query);

			if($result > 0){
				$alert='<p class="msg_error">El correo o el usuario ya existe.</p>';
			}else{

				$query_insert = mysqli_query($conection, "INSERT INTO usuario(
															nombre,correo,usuario,clave,rol)
					       									VALUES('$nombre','$email','$user','$clave',
					       									'$rol')");

				if($query_insert){
					
					$alert='<p class="msg_save">Usuario creado Correctamente.</p>';
				}else{
					$alert='<p class="msg_error">Error al crear el usuario.</p>';
				}
			}
 
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"> 
	<title>Registro Usuario</title>
	<link rel="stylesheet" type="text/css" href="css/style1.css">
</head>
<body>
	<section id="container">	

		<div class="form_register">
			<h1> Registrar Usuario</h1>
			
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	

			<form action="" method="post" enctype="multipart/form-data">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre Completo"> 

				<label for="correo">Correro electronico</label>
				<input type="email" name="correo" id="correo" placeholder="Correo electronico">

				<label for="usuario">Usuario</label>
				<input type="text" name="usuario" id="usuario" placeholder="Usuario">

				<label for="clave">Clave</label>
				<input type="password" name="clave" id="clave" placeholder="Clave de acceso">

				
			
				
				<input type="submit" class="btn_save" value="Crear Usuario">
				<a href="index.php" class="btn_exit"> Salir</a>
			</form>
		</div>
	</section>
	<?php include "./sistema/includes/footer.php"; ?>

</body>
</html>