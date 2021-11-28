<?php
session_start();
include '../../conexion.php';
		$arreglo=$_SESSION['carrito'];
		$numerodeventa=0;
		$re=mysqli_query($conection, "SELECT * from compras order by numerodeventa DESC limit 1");	
		while (	$data=mysqli_fetch_array($re)) {
					$numerodeventa=$data['numerodeventa'];	
					$foto 		  =$data['foto'];
					$subtotal	  =$data['subtotal'];
					$total		  =$data['total'];
		}
		if($numerodeventa==0){
			$numerodeventa=1;
		}else{
			$numerodeventa=$numerodeventa+1;
		}
		$total=0;
		for($i=0; $i<count($arreglo);$i++){
		
			mysqli_query($conection,"INSERT into compras (numerodeventa, foto,nombre,precio,cantidad,subtotal,total) values(
				".$numerodeventa.",
				'".$arreglo[$i]['foto']."',
				'".$arreglo[$i]['Nombre']."',	
				'".$arreglo[$i]['Precio']."',
				'".$arreglo[$i]['Cantidad']."',
				'".($arreglo[$i]['Precio']*$arreglo[$i]['Cantidad'])."',
				'".$total=($arreglo[$i]['Cantidad']+$arreglo[$i]['Precio'])+$total."'
			)");

		}
		unset($_SESSION['carrito']);
		header("Location: ventas_cerradas.php");

?>