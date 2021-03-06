<?php
	include "../conexion.php";

	$query = mysqli_query($conection, "SELECT * FROM producto WHERE 1");
	$result = mysqli_fetch_array($query);
	if(!$result){
		echo'Hay un error de sql: '.$query;
	}else{
		$data = mysqli_fetch_array($query);
	}
?>
<!DOCTYPE html>
<html lang="es"> 

<head>
    <title> PRODUCTOS </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>

<body>
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/nav2.php"; ?>

    <section id="container">

		<div class="data_delete">
			<h1>Detalle Producto</h1>
			<hr>	
			<section id="edit" method="post" enctype="multipart/form-data">

				<?php
					include '../conexion.php';
					// Validar Producto
					if(empty($_REQUEST['id'])){
						header("location: productop.php");
					}else{
						$id_producto = $_REQUEST['id'];
						if(!is_numeric($id_producto)){
							header("location: productop.php");
						}

						$query_producto = mysqli_query($conection, "SELECT p.codproducto,p.nombre,p.descripcion,p.precio,p.existencia,													p.foto,pr.codproveedor,pr.proveedor
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
								$foto = '<img id="img" src="./img/uploads/'.$data_producto['foto'].'" alt="Producto">';
							}

						}else{
							header("location: productop.php");
						}
					}

					?>
				<div class="producto2">
					<div class="photo">
					<label for="foto"></label>
				        <label for="foto"></label>
				        <?php echo $foto; ?>
				    </div>
				</div>
				<br><br>
				<center>
					<span>Nombre: <?php echo $data_producto['nombre']; ?></span><br>
					<span>Descipcion: <?php echo $data_producto['descripcion']; ?></span><br>
		 			<span>Precio:$ <?php echo $data_producto['precio']; ?></span><br>

					 <a href="./carrito.php?id=<?php echo $id_producto ?>" class="btn_add"> Agregar</a>
					 <a href="./todos.php" class="btn_cancel"> Regresar</a>
			 
				</center>
			</section>
		
		</div>

	</section>
	<br>
	<br>
	<br>
	<br>
</body>
<?php include "includes/footer.php"; ?>


</html>
