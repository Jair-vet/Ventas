<?php
	include '../conexion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<title>Administración Ventas</title>
</head>
<body>
	<link rel="stylesheet" href="../css/estilos.css">
	<nav>
    <ul>
        <li><a href="../index.php"> Home</a></li>
        <li class="principal">
            <a href="../productosp.php"> Productos</a>
        </li>
        <li class="principal">
            <a href="../contacto.php">Contacto</a>
        </li>

        <li class="principal">
            <a href="../carrito.php"> Carrito</a>
        </li>
</nav>
	<center><h1>Últimas Ventas</h1></center>
	<selection>
	<center><a href="../csm/sistema/index.php" class="aceptar">Index</a></center>
	<center><a href="ventas_cerradas.php" class="return">Regresar</a></center>
	<table style="width: 800px; margin-left: auto;margin-right: auto;border: solid;">	
		<tr >
			<td>IMAGEN</td>
			<td>NOMBRE</td>
			<td>PRECIO</td>
			<td>CANTIDAD</td>
			<td>SUBTOTAL</td>
		</tr>	

		<?php
		
		$numerodeventa = $_REQUEST['numerodeventa'];
		$re=mysqli_query($conection,"SELECT * from compras WHERE numerodeventa = $numerodeventa");
		while ($data=mysqli_fetch_array($re)) {

				if($numerodeventa!=$data['numerodeventa']){
						echo '<tr><td>TOTAL: $'.$data['total'].'</td><tr></tr>';
						//echo '<td>TOTAL: $'.$data['total'].'</td>';

						if($data['foto'] != 'img_producto.png'){
						$foto = ''.$data['foto'];
						}else{
						$foto = 'img/'.$data['foto'];
						}		
					}
					$numerodeventa=$data['numerodeventa'];
					echo '<tr>
						<td><img src="../csm/sistema/img/uploads/'.$data['foto'].'" width="100px" heigth="100px" /></td>
						<td>'.$data['nombre'].'</td>
						<td>'.$data['precio'].'</td>
						<td>'.$data['cantidad'].'</td>
						<td>'.$data['subtotal'].'</td>
						<td> TOTAL: $'.$data['total'].'</td>

					</tr>';

			}
		?>
	</table>
	</section>
	<?php include "../incluides/footer.php"; ?>
</body>
</html>