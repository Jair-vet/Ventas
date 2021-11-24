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
<html lang="en">
<head>
<title> PRODUCTOS </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/nav2.php"; ?>
	<section id="container">
	</div> 
			<table>
				<tr>

				</tr> 
				
				<?php
				include "../conexion.php";
				$query = mysqli_query($conection, "SELECT p.codproducto,p.nombre,p.descripcion,p.precio,p.existencia,pr.proveedor, p.foto
													FROM producto p 
													INNER JOIN proveedor pr
													ON p.proveedor = pr.codproveedor
													WHERE p.estatus = 1 ");
				$result = mysqli_num_rows($query);
				if($result > 0){
				while($data = mysqli_fetch_array($query)){
					// validar cuando exista una foto y cuando no
							if($data['foto'] != 'img_producto.png'){
								$foto = 'img/uploads/'.$data['foto'];
							}else{
								$foto = 'img/'.$data['foto'];
							}

				?>
					<div class="producto">
					<center>
						<img src=" <?php echo $foto; ?>"><br>
						<span>Nombre: <?php echo $data['nombre']; ?></span><br>
						<span>Precio:$ <?php echo $data['precio']; ?></span><br>
						<a href="ver_producto1.php?id=<?php echo $data['codproducto'];?>" class="btn_save">Ver</a>
					</center>
					
				</div>

			<?php
				}
			}

			?>
				
			</table>
		</div>

	</section>
	<?php include "./includes/footer.php"; ?>

</body>
</html>