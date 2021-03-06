<?php
	session_start();
	if($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 )
	{
		header("location: ./");
	}
	include "../conexion.php";

	if(!empty($_POST))
	{
		if(empty( $_POST['idproveedor']))
		{
			header("location: lista_proveedores.php");
			mysqli_close($conection);
		}

		$idproveedor = $_POST['idproveedor'];

		//$query_delet = mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario "); eliminar un registro de la base de datos
		$query_delete = mysqli_query($conection, "UPDATE proveedor SET estatus = 0 WHERE codproveedor =$idproveedor ");
		mysqli_close($conection);
		if($query_delete){
			//$alert='<p class="msg_error">Proveedor Eliminado..</p>';
			header("location: lista_proveedores.php");
		}else{
			echo "Error al Eliminar";
		}
	}

	if(empty($_REQUEST['id']) )
	{
		header("location: lista_proveedores.php");
		mysqli_close($conection);
	}else{

		$idproveedor = $_REQUEST['id'];

		$query = mysqli_query($conection,"SELECT * FROM proveedor WHERE codproveedor = $idproveedor");
		mysqli_close($conection);
		$result = mysqli_num_rows($query);

		if($result > 0){
			while ($data = mysqli_fetch_array($query)) {
				# code...
				$proveedor = $data['proveedor'];
			}
		}else{
			header("location: lista_proveedores.php");
		}

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Eliminar Proveedor</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="data_delete">
			<i class="fas fa-building fa-7x" style="color: #e66262"></i>
			<br>
			<br>
			<h2>¿Seguro de Eliminar?</h2>
			<p> Proveedor: <span><?php echo $proveedor ?></span></p>

			<form method="post" action="">
				<input type="hidden" name="idproveedor" value="<?php echo $idproveedor; ?>" >
				<a href="lista_proveedores.php" class="btn_cancel"><i class="fas fa-ban"></i> Cancelar</a>
				<button type="submit" class="btn_ok"><i class="far fa-trash-alt"></i> Eliminar</button>
			</form>
		</div>

	</section>
	<?php include "includes/footer.php"; ?>

</body>
</html>