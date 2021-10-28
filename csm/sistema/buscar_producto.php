<?php
	session_start();
	include "../conexion.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Lista de Productos</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<?php 
			$busqueda='';
			$search_proveedor='';
			if (empty($_REQUEST['busqueda']) && empty($_REQUEST['proveedor']))
			 {
				header("location: lista_producto.php");
			}
			if(!empty($_REQUEST['busqueda'])){
				$busqueda = strtolower($_REQUEST['busqueda']);
				$where="";
			}
			if(!empty($_REQUEST['proveedor'])){
				$search_proveedor = ($_REQUEST['proveedor']);
				$where= "proveedor LIKE $search_proveedor AND estatus = 1";			}
		?>

		<h1><i class="fas fa-cube "></i> Lista de Productos</h1>
		<a href="registro_producto.php" class="btn_new"><i class="fas fa-plus"></i> Registrar Producto</a>

		<form action="buscar_producto.php" method="get" class="form_search">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<button type="submit" class="btn_search">Buscar <i class="fas fa-search-plus"></i></button>
		</form>

		<table>
			<tr>
				<th>Código</th>
				<th>Descripción</th>
				<th>Precio</th>
				<th>Existencia</th>
				<th>
				<?php 
					$pro =0;
						if(!empty($_REQUEST['proveedor'])){
							$pro = $_REQUEST['proveedor'];
						}
					$query_proveedor = mysqli_query($conection, "SELECT * FROM proveedor WHERE estatus = 1 											ORDER BY proveedor ASC");
					$result_proveedor = mysqli_num_rows($query_proveedor);
				?>	
				<select name="proveedor" id="search_proveedor">
					<?php 
					 	if($result_proveedor > 0){
					 		while ($proveedor = mysqli_fetch_array($query_proveedor)) {
					 			if($pro == $proveedor['codproveedor'])
					 			{
					?>
						<option value="<?php echo $proveedor['codproveedor']; ?>" selected><?php echo $proveedor['proveedor'] ?></option>
					<?php 
								}else{
					?>		
						<option value="<?php echo $proveedor['codproveedor']; ?>"><?php echo $proveedor['proveedor'] ?></option>	
					<?php		}
					 		}
					 	}

					?>
					
				</select>
				</th>
				<th>Foto</th>
				<th>Acciones</th>
			</tr>
			
			<?php
				//Paginador
				$sql_registe = mysqli_query($conection, "SELECT COUNT(*) AS total_registro FROM producto 
														WHERE $where" );

				$result_resgister = mysqli_fetch_array($sql_registe);
				$total_registro = $result_resgister['total_registro'];

				echo $total_registro;
				exit();

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
					<td><?php echo $data['codproducto']; ?></td>
					<td><?php echo $data['descripcion']; ?></td>
					<td class="celPrecio"><?php echo $data['precio']; ?></td>
					<td class="celExistencia"><?php echo $data['existencia']; ?></td>
					<td><?php echo $data['proveedor']; ?></td>
					<td class="img_producto"><img src=" <?php echo $foto; ?>" alt="<?php echo $data['descripcion']; ?>"></td>

					<?php if($_SESSION['rol'] == 1 || $_SESSION['rol'] == 2){ ?>
					<td>
						<a class="link_see" href="ver_producto.php?id=<?php echo $data['codproducto']; ?>"><i class="fas fa-eye"></i> Ver</a>
						|
						<a class="link_add add_product" product="<?php echo $data['codproducto']; ?>" href=" #"><i class="fas fa-plus"></i> Agregar</a>
						|
						<a class="link_edit" href="editar_producto.php?id=<?php echo $data['codproducto']; ?>"><i class="far fa-edit"></i> Editar</a>
						|
						<a class="link_delete del_product" href="#"  product="<?php echo $data['codproducto']; ?> "><i class="far fa-trash-alt"></i> Eliminar</a>
					</td>
					<?php } ?>
				</tr> 
			<?php	
					 }
				}

			?>
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