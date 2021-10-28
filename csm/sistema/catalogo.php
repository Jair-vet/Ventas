<?php
	session_start();
	include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Catalogo de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">

		<h1><i class="fas fa-cube "></i> Catalogo de Productos</h1>
		<th><a href="index.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a></th>
		<br>
		<table>
			<tr>

				<th>Foto</th>
				<th>Descripción</th>
				<th>Precio</th>
				<th>Ver</th>
			</tr>
			
			<?php
				//Paginador
				$sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM producto WHERE estatus = 1");
				$result_resgister = mysqli_fetch_array($sql_registe);
				$total_registro = $result_resgister['total_registro'];

				$por_pagina = 10;

				if(empty($_GET['pagina']))
				{
					$pagina = 1;
				}else{
					$pagina = $_GET['pagina'];
				}

				$desde = ($pagina-1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);

				$query = mysqli_query($conection, "SELECT p.codproducto,p.descripcion,p.precio,p.existencia,pr.proveedor, p.foto
												   FROM producto p 
												   INNER JOIN proveedor pr
												   ON p.proveedor = pr.codproveedor
												   WHERE p.estatus = 1 ORDER BY p.codproducto DESC LIMIT $desde,$por_pagina"); //ASC = acendente  DESC = desendente.
				
				mysqli_close($conection);
				$result = mysqli_num_rows($query);

				if($result > 0){

					while ($data = mysqli_fetch_array($query)) {
						// validar cuando exista una foto y cuando no
						if($data['foto'] != 'img_producto.png'){
							$foto = 'img/uploads/'.$data['foto'];
						}else{
							$foto = 'img/'.$data['foto'];
						}
				?>
				<tr class="row <?php echo $data['codproducto']; ?>"> 
					<td class="img_producto1"><img src=" <?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></td>
					<td><?php echo $data['descripcion']; ?></td>
					<td class="celPrecio"><?php echo $data['precio']; ?></td>
					<td>
						<a class="link_see" href="ver_producto1.php?id=<?php echo $data['codproducto']; ?>"><i class="fas fa-eye"></i> Ver</a>
						<a href="#"><img class="close" src="img/carrito.jpg" alt="Agregar Producto" title="Agregar"></a>
					</td>
				</tr> 
			<?php	
					 }
				}

			?>

<!--------------------- PAginador ------------------>
		</table>
		<div class="paginador">
			<ul>
				<?php
					if($pagina != 1)
					{
				 ?>
				<li><a href="?pagina=<?php echo 1; ?>"><i class="fas fa-backward"></i></a></li>
				<li><a href="?pagina=<?php echo $pagina-1; ?>"><i class="fas fa-caret-left"></i></a></li>
				<?php
					}
					for ($i=1; $i <= $total_paginas; $i++) { 
						# code...
						if($i == $pagina)
						{
							echo '<li class="pageSelected">'.$i.'</li>';
						}else{
						echo '<li><a href="?pagina='.$i.'">'.$i.'</a></li>';
						}
					}

					if($pagina != $total_paginas)
					{
				?>
				<li><a href="?pagina=<?php echo $pagina+1; ?>"><i class="fas fa-caret-right"></i></a></li>
				<li><a href="?pagina=<?php echo $total_paginas; ?>"><i class="fas fa-forward"></i></a></li>
				<?php } ?>
			</ul>
		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>