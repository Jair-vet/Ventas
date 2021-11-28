<?php
	session_start();
		
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
	{
		header("location: ./");
	}
	include "../../conexion.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8"/>
	<?php include "../includes/scripts.php"; ?>
	<title>Administración Ventas</title>
</head>
<body>
	<?php include "../includes/header_ventas_cerradas.php"; ?>
<link rel="stylesheet" href="../css/style.css">
	
	
	<br>
	<br>
	<br>
	<br>
	<br>
	<br>

	<center><h1>Últimas Ventas</h1></center>
	<selection>
	<center><a href="../ventas_cerradas1.php" class="aceptar">Regresar</a></center><br>
	<!-- <center><a href="ventas_cerradas.php" class="return">Regresar</a></center> -->
	<table style="width: 900px; margin-left: auto;margin-right: auto;border: solid;">	
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
						<td><img src="../'.$data['foto'].'" width="100px" heigth="100px" /></td>
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
	<?php include "../includes/footer.php"; ?>
</body>
</html>