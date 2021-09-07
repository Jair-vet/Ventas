<?php
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		$alert=' ';
		if (empty($_POST['proveedor']) || empty($_POST['contacto']) || empty($_POST['telefono']) || empty($_POST['direccion'])) 
		{
			$alert='<p class="msg_error">Todos los campos son obligatorios.</p>';
		}else{

			$idproveedor   = $_POST['id'];
			$proveedor     = $_POST['proveedor'];
			$contacto        = $_POST['contacto'];
			$telefono      = $_POST['telefono'];
			$direccion     = $_POST['direccion'];

			$sql_update = mysqli_query($conection, "UPDATE proveedor
		    										SET proveedor= '$proveedor', contacto = '$contacto',telefono = '$telefono',direccion='$direccion'
													WHERE codproveedor= $idproveedor ");

			if($sql_update){
				$alert='<p class="msg_save">Proveeedor Modificado Correctamente.</p>';
			}else{
				$alert='<p class="msg_error">Error al Modificar el Proveedor.</p>';
			}
		}
	}

	// Mostrar Datos 
	if(empty($_REQUEST['id']))
	{
		header('location lista_proveedores.php');
		mysqli_close($conection);
	}
	$idproveedor = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM proveedor WHERE codproveedor = $idproveedor");
	mysqli_close($conection);
	$resul_sql = mysqli_num_rows($sql);

	if($resul_sql == 0){

		header('location: lista_proveedores.php');
	}else{

		while ($data = mysqli_fetch_array($sql)) {
			# code...
			$idproveedor = $data['codproveedor'];
			$proveedor 	  = $data['proveedor'];
			$contacto     = $data['contacto'];
			$telefono     = $data['telefono'];
			$direccion    = $data['direccion'];
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Modificar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		

		<div class="form_register">
			<h1><i class="far fa-edit"></i> Modificar Proveedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ' '; ?></div>	

			<form action="" method="post">
				<input type="hidden" name="id" value="<?php echo $idproveedor ?>">
				<label for="proveedor">Proveedor</label>
				<input type="text" name="proveedor" id="proveedor" placeholder="Nombre del proveedor" value="<?php echo $proveedor?>">
				<label for="contacto">Contacto</label>
				<input type="text" name="contacto" id="contacto" placeholder="Nombre Completo del Contacto"value="<?php echo $contacto?>">
				<label for="telefono">Telefono</label>
				<input type="number" name="telefono" id="telefono" placeholder="Telefono"value="<?php echo $telefono?>">
				<label for="direccion">Direccion</label>
		    	<input type="text" name="direccion" id="direccion" placeholder="Direccion completa"value="<?php echo $direccion?>">			
				<button type="submit" class="btn_save"><i class="far fa-edit"></i> Actualizar Proveedor</button>
				<a href="lista_proveedores.php" class="btn_return"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			

		</div>

	</section>


	<?php include "includes/footer.php"; ?>

</body>
</html>