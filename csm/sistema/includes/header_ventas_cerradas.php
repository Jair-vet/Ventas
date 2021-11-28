<?php

	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

?>
<header>
	<div class="header">
		<h1><i class="fab fa-aws"></i> Sistema de Ventas Para Alumnos</h1>
			<div class="optionsBar">
				<p>México, <?php echo fechaC(); ?></p>
				<span>|</span>
				<span class="user"><?php echo $_SESSION['nombre']; ?></span>  <!-- Nombre del Usuario que Ingresa -->
				<img class="photouser" src="../img/user.png" alt="Usuario">
				<a href="salir.php"><img class="close" src="../img/salir.png" alt="Salir del sistema" title="Salir"></a>
			</div>
		</div>
		
</header>
<div class="modal">
	<div class="bodyModal">
		
	</div>
</div>