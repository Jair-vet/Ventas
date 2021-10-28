<?php
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 ) // Solo Admi y Supervisores pueden ver
	{ 
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		header("location: lista_producto.php");
		//print_r($_FILES); // verificar lo que trae post  por medio del arreglo.
		$idproducto = $_REQUEST['id'];

		$sql = mysqli_query($conection, "SELECT * FROM producto WHERE codproducto = $idproducto and estatus = 1");
		$result_sql = mysqli_num_rows($sql);

		if($result_sql == 0){
			header("location: lista_producto.php");
		}else{

			while ($data = mysqli_fetch_array($sql)) {
				# code...
				$idproducto  =$data['codproducto'];
				$descripcion =$data['descripcion'];
				$precio      =$data['precio'];
				$existencia  =$data['existencia'];
				$proveedor   =$data['proveedor'];
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

		$query_producto = mysqli_query($conection, "SELECT p.codproducto,p.descripcion,p.precio,p.existencia,													p.foto,pr.codproveedor,pr.proveedor
		 											FROM producto p 
		 											INNER JOIN proveedor pr 
		 											ON p.proveedor = pr.codproveedor
		 										    WHERE p.codproducto = $id_producto and p.estatus = 1");
		$result_producto = mysqli_num_rows($query_producto);

		$foto = '';
		$classRemove = 'notBlock';

		if($result_producto > 0){
			$data_producto = mysqli_fetch_assoc($query_producto);

			if($data_producto['foto'] != 'img_produto.png'){
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

		<div class="data_delete">
			<h1><i class="fas fa-cubes"></i> Producto</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	
			<form action="" method="post" enctype="multipart/form-data">

				<p> Nombre:     <span><?php echo $data_producto['descripcion']; ?></span></p>
				<p> Precio:     <span><?php echo $data_producto['precio'] ?></span></p>
				<p> Existencia: <span><?php echo $data_producto['existencia'] ?></span></p>
				<p> Proveedor: <span><?php echo $data_producto['proveedor'] ?></span></p>
				<div class="photo">
					<label for="foto">Foto</label>
				        <div class="prevPhoto">
				        <span class="delPhoto notBlock">X</span>
				        <label for="foto"></label>
				        <?php echo $foto; ?>
				        </div>
				        <div class="upimg">
				        <input type="file" name="foto" id="foto">
				        </div>
				        <div id="form_alert"></div>
				</div>
				<a href="lista_producto.php" class="btn_cancel"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			

		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>