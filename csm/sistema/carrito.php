<?php
    session_start();
	include "../conexion.php";

	if(isset($_SESSION['carrito'])){
		if(isset($_REQUEST['id'])){
			$arreglo=$_SESSION['carrito'];
			$encontro=false;  //Bandera
			$numero=0;
			for($i=0;$i<count($arreglo);$i++){
				if($arreglo[$i]['Id']==$_REQUEST['id']){
					$encontro =true;
					$numero=$i;
				}
			}

			/// Aumentando la cantidad
			if($encontro==true){
				$arreglo[$numero]['Cantidad']=$arreglo[$numero]['Cantidad']+1;
				$_SESSION['carrito']=$arreglo;

			}else{
				$nombre ="";
				$precio =0;
				$foto  ="";
				$query_producto = mysqli_query($conection, "SELECT p.codproducto,p.nombre,p.descripcion,p.precio,p.existencia,									  p.foto,pr.codproveedor,pr.proveedor
							 								FROM producto p 
							 								INNER JOIN proveedor pr 
							 								ON p.proveedor = pr.codproveedor
														    WHERE p.codproducto =" .$_REQUEST['id'] );

				while ($data = mysqli_fetch_array($query_producto)) {
					# code...
					$idproducto  =$data['codproducto'];
					$nombre      =$data['nombre'];
					$precio      =$data['precio'];
					$descripcion =$data['descripcion'];
					$foto 		 =$data['foto'];	


					if($data['foto'] != 'img_producto.png'){
					$foto = 'csm/sistema/img/uploads/'.$data['foto'];
					}else{
						$foto = 'img/'.$data['foto'];
					}											
				}
	//agrege un arreglo nuevo
				$datosNuevos= array('Id'       =>$_REQUEST['id'],
								 'Nombre'	  =>$nombre,
								 'Precio'	  =>$precio,
								 'foto'  	  =>$foto,
								 'Cantidad'   =>1);
	// agregamos el arreglo
				array_push($arreglo, $datosNuevos);
				$_SESSION['carrito'] =$arreglo;
			}
		}

	}else{
		if (isset($_REQUEST['id'])) {
			$nombre ="";
			$precio =0;
			$foto  ="";
			$query_producto = mysqli_query($conection, "SELECT p.codproducto,p.nombre,p.descripcion,p.precio,p.existencia,									  p.foto,pr.codproveedor,pr.proveedor
						 								FROM producto p 
						 								INNER JOIN proveedor pr 
						 								ON p.proveedor = pr.codproveedor
													    WHERE p.codproducto =" .$_REQUEST['id'] );

			while ($data = mysqli_fetch_array($query_producto)) {
				# code...
				$idproducto  =$data['codproducto'];
				$nombre      =$data['nombre'];
				$precio      =$data['precio'];
				$descripcion =$data['descripcion'];
				$foto 		 =$data['foto'];	


				if($data['foto'] != 'img_producto.png'){
				$foto = './img/uploads/'.$data['foto'];
				}else{
					$foto = 'img/'.$data['foto'];
				}											
			}

			$arreglo[] = array('Id'       =>$_REQUEST['id'],
							 'Nombre'	  =>$nombre,
							 'Precio'	  =>$precio,
							 'foto'  	  =>$foto,
							 'Cantidad'   =>1);
			
			$_SESSION['carrito']=$arreglo;

		}
	}
	
	
?>
<!DOCTYPE html>
<html lang="es"> 

<head>
    <title> CARRITO </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>

<body>
	<?php include "includes/scripts.php"; ?>
	<?php include "includes/nav2.php"; ?>

    <h1> Carrito de Compras</h1>
   <section class="edit2">
   	<?php
   			$total=0;
   		if(isset($_SESSION['carrito'])){
   			$datos=$_SESSION['carrito'];
   			$total=0;
   			for($i =0; $i<count($datos);$i++){

   	?>
   		<div class="producto1">
   			<center> 
   				<img src="<?php echo $datos[$i]['foto']; ?>"><br>
   				<span><?php echo $datos[$i]['Nombre']; ?></span><br>
   				<span>Precio:$ <?php echo $datos[$i]['Precio']; ?></span><br>
   				<span>Cantidad: 
   					<input type="text" value=" <?php echo $datos[$i]['Cantidad'];?>"
   					data-precio="<?php echo $datos[$i]['Precio']; ?>"
   					data-id="<?php echo $datos[$i]['Id']; ?>"
   					class="cantidad">
   				</span><br>
   				<span class="subtotal">SubTotal:$ <?php echo $datos[$i]['Cantidad']*$datos[$i]['Precio'];?></span><br>
   				<a href="#" class="eliminar" data-id="<?php echo $datos[$i]['Id']?>">Eliminar</a>
   			</center>
   		</div>
   	<?php
   	$total=($datos[$i]['Cantidad']*$datos[$i]['Precio'])+$total;

   			}

   		}else {
   			echo'<center><h2>El Carrito de Compras esta vacio</h2></center>';
   		}
   		echo '<center><h2 id="total">Total:$ '.$total.'</h2></center>'; 
   		if($total!=0){  // NO APARESCA SI ESTA VACIO
   		echo '<center><a href="ventas/compras.php" class="aceptar">Enviar Pedido</a></center>;';
   	}
   	?>
   	<center><a href="productosp.php" class="ver">Ver catalogo</a></center>

   </section>
   
</body>
<?php include "includes/footer.php"; ?>


</html>
