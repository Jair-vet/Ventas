<?php
	session_start();
		
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	} 


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title> Sistema Ventas</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container1">
		<h1>Bienvenido al Sistema de Ventas para Estudiantes</h1>
		<br>
		
		<p class="letra"> Nombre:   <span class="user"><?php echo $_SESSION['nombre']; ?></span></p>
		<p class="letra"> Correo:   <span class="user"><?php echo $_SESSION['email']; ?></span></p>
		<p class="letra"> Usuario:  <span class="user"><?php echo $_SESSION['user']; ?></span></p>

		<?php
		if($_SESSION['rol'] == 1){
			echo '<br><br>';
   		echo '<center><a href="ventas_cerradas.php" class="aceptar">Ventas Cerradas</a></center>';
   	}
   		?>
	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>