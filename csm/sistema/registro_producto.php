<?php
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 ) // Solo Admi y Supervisores pueden ver
	{ 
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		//print_r($_FILES); // verificar lo que trae post  por medio del arraglo.
		$alert='';
		if (empty($_POST['proveedor']) || empty($_POST['descripcion']) || empty($_POST['precio'])  || empty($_POST['existencia']) || empty($_POST['nombre']) ) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$proveedor   = $_POST['proveedor'];
			$nombre  	 = $_POST['nombre'];
			$descripcion = $_POST['descripcion']; 
			$precio  	 = $_POST['precio'];
			$existencia  = $_POST['existencia'];
			$usuario_id  = $_SESSION['idUser'];

			$foto        = $_FILES['foto']; 
			$nombre_foto = $foto['name'];
			$type		 = $foto['type'];
			$url_temp	 = $foto['tmp_name'];

			$imgProducto = 'img_producto.png'; //opcional png

			// Validacion para la foto jpg
			if($nombre_foto != '')
			{
				$destino      = 'img/uploads/';  // dentro de la carpeta de mi archivo
				$img_nombre   = 'img_'.md5(date('d-m-Y H:m:s'));
				$imgProducto  = $img_nombre.'jpg';  // fotos deben ser jpg.
				$src 		  = $destino.$imgProducto; // almacenar la imagen en cualquier formato que venga
			}

			$query_insert = mysqli_query($conection, "INSERT INTO producto(
											descripcion, proveedor, nombre, precio, existencia, usuario_id, foto)
					      					VALUES('$descripcion','$proveedor', '$nombre' ,'$precio', '$existencia','$usuario_id','$imgProducto')");
			if($query_insert){
				if($nombre_foto != ''){
					move_uploaded_file($url_temp,$src); // almacena la ruta del archivo y lo mueve a la nueva ruta
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
	<title>Registro Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1><i class="fas fa-cubes"></i> Registro producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	
			<form action="" method="post" enctype="multipart/form-data">

				<label for="proveedor">Proveedor</label>

				<?php 
					
					$query_proveedor = mysqli_query($conection, "SELECT * FROM proveedor WHERE estatus = 1 	ORDER BY proveedor ASC");
					$result_proveedor = mysqli_num_rows($query_proveedor);
					mysqli_close($conection);

				?>	
				<select name="proveedor" id="proveedor">
					<?php 

					 	if($result_proveedor > 0){
					 		while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					 			# code...
					?>
						<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
					<?php 
					 		}
					 	}

					?>
					
				</select>
				<label for="nombre">Nombre del Producto</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del producto">

				<label for="descripcion">Descripcion del Producto</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripcion del producto">

				<label for="precio">Precio</label>
				<input type="number" name="precio" id="precio" placeholder="Precio del Producto">

				<label for="existencia">Cantidad</label>
		    	<input type="number" name="existencia" id="existencia" placeholder="Cantidad del Producto">

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

				<button type="submit" class="btn_save"><i class="far fa-save"></i> Guardar Producto</button>
				<a href="lista_producto.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			

		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>