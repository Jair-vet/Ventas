<?php
	session_start();
	include "../conexion.php";
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 ) // Solo Admi y Supervisores pueden ver
	{ 
		header("location: ./");
	}

	if(!empty($_POST))
	{
		// print_r($_FILES); // verificar lo que trae post  por medio del arraglo.
		$alert='';
		if (empty($_POST['proveedor']) || empty($_POST['descripcion']) || empty($_POST['precio'])  || empty($_POST['nombre']) ) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$codproducto  = $_POST['id'];
			$proveedor    = $_POST['proveedor'];
			$descripcion  = $_POST['descripcion']; 
			$nombre 	  = $_POST['nombre']; 
			$precio  	  = $_POST['precio'];
			$cantidad	  = $_POST['cantidad'];
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
					$imgProducto = 'img_producto.png';
				}
			}

			$query_update = mysqli_query($conection, "UPDATE producto
													SET descripcion  = '$descripcion',
														nombre		 = '$nombre',
														proveedor 	 = '$proveedor',
														existencia	 = '$cantidad',
														precio 		 = $precio,
														foto 		 = '$imgProducto'
													WHERE codproducto = $codproducto");
			if($query_update){

				if(($nombre_foto != '' && ($_POST['foto_actual'] != 'img_produto.png')) || ($_POST['foto_actual'] != $_POST['foto_remove']))
				{
					unlink('img/uploads/'.$_POST['foto_actual']);
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

	// Validar Producto
	if(empty($_REQUEST['id'])){
		header("location: lista_producto.php");
	}else{
		$id_producto = $_REQUEST['id'];
		if(!is_numeric($id_producto)){
			header("location: lista_producto.php");
		}

		$query_producto = mysqli_query($conection, "SELECT p.codproducto,p.descripcion,p.nombre,p.precio,p.existencia,p.foto,
															pr.codproveedor,pr.proveedor
		 											FROM producto p 
		 											INNER JOIN proveedor pr 
		 											ON p.proveedor = pr.codproveedor
		 										    WHERE p.codproducto = $id_producto and p.estatus = 1");
		$result_producto = mysqli_num_rows($query_producto);

		$foto = '';
		$classRemove = 'notBlock';

		if($result_producto > 0){
			$data_producto = mysqli_fetch_assoc($query_producto);

			if($data_producto['foto'] != 'img_producto.png'){
				$classRemove = '';
				$foto = '<img id="img" src="img/uploads/'.$data_producto['foto'].'" alt="Producto">';
			}

		}else{
			header("location: lista_producto.php");
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Modificar Producto</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<div class="form_register">
			<h1><i class="fas fa-cubes"></i> Actualizar producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	
			<form action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $data_producto['codproducto']; ?>">
				<input type="hidden" id="foto_actual" name="foto_actual" value="<?php echo $data_producto['foto']; ?>">
				<input type="hidden" id="foto_remove" name="foto_remove" value="<?php echo $data_producto['foto']; ?>">

				<label for="proveedor">Proveedor</label>

				<?php 
					
					$query_proveedor = mysqli_query($conection, "SELECT codproveedor, proveedor FROM proveedor WHERE estatus = 1 ORDER BY proveedor ASC");
					$result_proveedor = mysqli_num_rows($query_proveedor);
					mysqli_close($conection);

				?>	
				<select name="proveedor" id="proveedor" class="notItemOne">
					<option value="<?php echo $data_producto['codproveedor']; ?>" selected><?php echo $data_producto['proveedor']; ?></option>}
					option
					<?php 

					 	if($result_proveedor > 0)
					 	{
					 		while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					 			# code...
					?>
						<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor']; ?></option>
					<?php 
					 		}
					 	}

					?>
					
				</select>

				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" id="nombre" placeholder="Nombre del producto" value="<?php echo $data_producto['nombre'];?>">
				
				<label for="descripcion">Descripcion</label>
				<input type="text" name="descripcion" id="descripcion" placeholder="Descripcion del producto" value="<?php echo $data_producto['descripcion'];?>">

				<label for="precio">Precio</label>
				<input type="number" name="precio" id="precio" placeholder="Precio del Producto" min=0 oninput="validity.valid||(value='');" value="<?php echo $data_producto['precio'];?>">

				<label for="cantidad">Cantidad</label>
		    	<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad del Producto" min=0 oninput="validity.valid||(value='');" value="<?php echo $data_producto['existencia'];?>">

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

				<button type="submit" class="btn_save"><i class="far fa-save"></i> Actualizar Producto</button>
				<a href="lista_producto.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			

		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>