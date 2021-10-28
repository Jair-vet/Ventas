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
	<center><h1>Ventas Cerradas</h1></center>
	<selection>
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
	<?php include "../incluides/footer.php"; ?>
</body>
</html>