<?php
	session_start();
		
	if(empty($_SESSION['active']))
	{
		header('location: ../../');
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
	<?php include "../includes/header.php"; ?>
	<h1>Ventas Cerradas</h1>
	<section>
	<center><a href="../csm/sistema/index.php" class="aceptar">Index</a></center>
	<table style="width: 200px; margin-left: auto;margin-right: auto;border: solid;">	
		<tr >
		
			<td>VENTAS CERRADAS</td>
		</tr>	

		<?php
			$re=mysqli_query($conection,"SELECT * from compras");
			$numerodeventa=0;
			while ($data=mysqli_fetch_array($re)) {
					if($numerodeventa	!=$data['numerodeventa']){
						echo '<tr>';
						echo '<td>Compra Número: '.$data['numerodeventa'].' </td>';
						?>
						<tr><td><center><a href="detalle.php?numerodeventa=<?php echo $data['numerodeventa'];?>" class="cerrar">Detalle</a></center></td><tr>
						<?php
						echo '</tr>';
						if($numerodeventa == $data['numerodeventa']){
						//echo '<td>TOTAL: $'.$data['total'].'</td>';		
					}
					$numerodeventa=$data['numerodeventa'];
			}
		}
		?>
	</table>
	</section>
	<?php include "../includes/footer.php"; ?>
</body>
</html>