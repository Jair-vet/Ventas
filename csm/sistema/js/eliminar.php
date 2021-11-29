<?php
session_start();
include "../../conexion.php";
	$arreglo=$_SESSION['carrito']; // Guardamos la variable de Session lo que tenga el carrito

	for($i=0;$i<count($arreglo);$i++){
		if($arreglo[$i]['Id']!=$_POST['Id']){
			
			$datosNuevos[]=array(
				'Id'        =>$arreglo[$i]['Id'],
				'Nombre'    =>$arreglo[$i]['Nombre'],
				'Precio'    =>$arreglo[$i]['Precio'],
				'foto'      =>$arreglo[$i]['foto'],
				'Cantidad'  =>$arreglo[$i]['Cantidad']
			);
		}
	}
	if(isset($datosNuevos)){
		$_SESSION['carrito']=$datosNuevos;
	}else{
		unset($_SESSION['carrito']);
		echo '0';
	}
?>