
<?php
	session_start();
	if($_SESSION['rol'] != 1 ) // Solo Admi puede ver
	{ 
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		//print_r($_FILES); // verificar lo que trae post  por medio del arraglo.
		$alert='';
		if (empty($_POST['nombre'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$nombre     = $_POST['nombre'];

			$foto        = $_FILES['foto']; 
			$nombre_foto = $foto['name'];
			$type		 = $foto['type'];
			$url_temp	 = $foto['tmp_name'];

			$imgProducto = 'img_producto.png'; //opcional png

			// Validacion para la foto jpg
			if($nombre_foto != '')
			{
				$destino      = 'img/banner/';  // dentro de la carpeta de mi archivo
				$img_nombre   = 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto  = $img_nombre.'jpg';  // fotos deben ser jpg.
				$src 		  = $destino.$imgProducto; // almacenar la imagen en cualquier formato que venga
			}

			$query_insert = mysqli_query($conection, "INSERT INTO banner(nombre,foto)
					      					VALUES('$nombre','$imgProducto')");
			if($query_insert){
				if($nombre_foto != ''){
					move_uploaded_file($url_temp,$src); // almcena la ruta del archivo y lo mueve a la nueva ruta
				}
				$alert='<p class="msg_save">Producto Guardado Correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al Guardar al Producto.</p>'; 
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Registro Banner</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1><i class="fas fa-cubes"></i> Registro Banner</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	
			<form action="" method="post" enctype="multipart/form-data">


				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre">

				<div class="photo">
					<label for="foto">Foto</label>
				        <div class="prevPhoto">
				        <span class="delPhoto notBlock">X</span>
				        <label for="foto"></label>
				        </div>
				        <div class="upimg">
				        <input type="file" name="foto" id="foto">
				        </div>
				        <div id="form_alert"></div>
				</div>

				<button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Informacion</button>
				<a href="lista_producto.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			

		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>