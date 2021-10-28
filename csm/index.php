<?php
	
$alert = " ";
session_start();
if(!empty($_SESSION['active']))
{
	header('location: sistema/');
}else{

		if(!empty($_POST))
		{ 
			if(empty($_POST['usuario']) || empty($_POST['clave']))
			{
				$alert = "Ingrese su usuario y su clave";
			}else{

				require_once "conexion.php";

				$user = mysqli_real_escape_string($conection, $_POST['usuario']);
				$pass = md5(mysqli_real_escape_string($conection,$_POST['clave']));

				$query = mysqli_query($conection, "SELECT * FROM usuario WHERE usuario= '$user' AND clave = '$pass'");
				mysqli_close($conection);
				$result = mysqli_num_rows($query);

				if($result > 0)
				{
					$data = mysqli_fetch_array($query);
					$_SESSION['active'] = true;
					$_SESSION['idUser'] = $data['idusuario'];
					$_SESSION['nombre'] = $data['nombre'];
					$_SESSION['email']  = $data['correo'];
					$_SESSION['user']   = $data['usuario'];
					$_SESSION['rol']    = $data['rol'];
					$_SESSION['foto']   = $data['foto'];

					header('location: sistema/');
				}else{
					$alert = 'El usuario o la clave son incorrectos';
					session_destroy();
				}
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum=scale=1.0, minimum-scale=1.0">
	<title>Login | Ventas</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">

		a{
		color: #1c1616;
		text-decoration: none;
		text-align: center;
		display: block;
		}
	</style>
</head>
<body>
	<section id="container">
		<form action="" method="post">

			<h3>Iniciar Sesión</h3>
			<img src="img/login.jpg" alt="Login">

			<input type="text" name="usuario" placeholder="Usuario">
		    <input type="password" name="clave" placeholder="Contraseña">
		    <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
		  	<div class="botonCss">
		  		<a href="registro.php">REGISTRARSE</a>
		  	</div>
			<input type="submit" value="INGRESAR"></input>
		</form>

	</section>
</body>
</html>