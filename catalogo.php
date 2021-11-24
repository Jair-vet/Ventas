<?php
	include "conexion.php";

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
    <title> INICIO </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
	<?php include "incluides/nav.php"; ?>

    <br>
    <br>
    <div class="banner">
    	<?php include "incluides/ads.php"; ?>
    </div>

  <br>
  <br>
  <br>
		<table>
			<tr>

			</tr>
			
			<?php

				$products = [];

				$query = mysqli_query($conection, "SELECT p.codproducto,p.nombre,p.descripcion,p.precio,p.existencia,pr.proveedor, p.foto
												   FROM producto p 
												   INNER JOIN proveedor pr
												   ON p.proveedor = pr.codproveedor
												   WHERE p.estatus = 1 "); //ASC = acendente  DESC = desendente.
			
				$data =  mysqli_fetch_all($query);

				$result = mysqli_num_rows($query);

			?>
			<div class="container">
				<?php

					if($result > 0){
						while(count($products) < 3){
							$i = rand(0, $result -1);
							if(!in_array($i, $products)){
								array_push($products, $i);
							}
						}
						foreach($products as $product){
							$p           = $data[$product];
							$codproducto = $p[0];
							$nombre		 = $p[1];
							$descripcion = $p[2];
							$precio      = $p[3];
							$stock       = $p[3];
							$provider    = $p[4];
							$foto        = $p[6];

							if($foto != 'img_producto.png'){
							$foto = 'csm/sistema/img/uploads/'.$foto;
							}else{
							$foto = 'img/'.$foto;
							}
				?>
				<div class="producto1">
					<img class="img_producto1" src=" <?php echo $foto; ?>">
					<span><?php echo $nombre ?></span><br>
					<span>$ <?php echo $precio ?></span><br>
					<a href="ver_producto.php?id=<?php echo $codproducto;?>" class="btn_save">Ver</a>
				</div>

				<?php
						
						}
					}
				?>
			</div>
			</table>
</body>
<?php include "incluides/footer.php"; ?>


</html>

