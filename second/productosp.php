<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Productos</title>
	 <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
	<?php include "incluides/header.php"; ?>
	<?php include "incluides/nav.php"; ?>
	<section id="container">
	 <div class="data_delete">
        <h1> Productos</h1>
        </div> 
			<table>
				<tr>

				</tr> 
				
				<?php
				include "conexion.php";
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
								$foto = 'csm/sistema/img/uploads/'.$data['foto'];
							}else{
								$foto = 'img/'.$data['foto'];
							}

				?>
					<div class="producto">
					<center>
						<img src=" <?php echo $foto; ?>"><br>
						<span>Nombre: <?php echo $data['nombre']; ?></span><br>
						<span>Precio:$ <?php echo $data['precio']; ?></span><br>
						<a href="ver_producto.php?id=<?php echo $data['codproducto'];?>" class="btn_save">Ver</a>
					</center>
					
				</div>

			<?php
				}
			}

			?>
				
			</table>
		</div>

	</section>
	<?php include "incluides/footer.php"; ?>

</body>
</html>