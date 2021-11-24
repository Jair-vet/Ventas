<?php
	session_start();
	include "../conexion.php";

	// Mostrar Datos 
	if(empty($_REQUEST['id']))
	{
		header('location lista_usuarios.php');
		mysqli_close($conection);
	} 

	$idUser = $_REQUEST['id'];

	$sql = mysqli_query($conection, "SELECT * FROM usuario WHERE idusuario = $idUser ");
	mysqli_close($conection);
	$resul_sql = mysqli_num_rows($sql);
	$foto = '';
	$classRemove = 'notBlock';

	if($resul_sql > 0){

		$data = mysqli_fetch_array($sql);
	
		

			if($data['rol'] == '1' || $data['rol'] == '2' || $data['rol'] == '3' ){
				$data['rol'] = 'Activo';
			}else{
				$data['rol'] = 'In-Activo';
		}
	} 
			

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Detalle de Adm</title>
</head>
<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		

		<div class="data_delete">
			
			<h1>Detalle</h1>
			<br>
			<p> Nombre:   <span><?php echo $data['nombre'] ?></span></p>
			<p> Correo:   <span><?php echo $data['correo'] ?></span></p>
			<p> Usuario:  <span><?php echo $data['usuario'] ?></span></p>
			<p> Estatus:  <span><?php echo $data['rol'] ?></span></p>
		
			<form method="post" action="">
				<input type="hidden" name="idUser" value="<?php echo $idusuario; ?>" >
				
				<a href="lista_usuarios.php" class="btn_cancel"><i class="fas fa-undo-alt"></i> Regresar</a>
			</form>
			
		</div>

	</section>


	<?php include "includes/footer.php"; ?>

</body>
</html>