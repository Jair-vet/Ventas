<?php
	
	include "../conexion.php";
	session_start();

	//print_r($_POST);exit;

	if(!empty($_POST)){

		//Extraer datos del Producto
		if($_POST['action'] == 'infoProducto')
		{
			$producto_id = $_POST['producto'];

			$query = mysqli_query($conection, "SELECT codproducto,descripcion FROM producto
											   WHERE codproducto = $producto_id AND estatus = 1");
			mysqli_close($conection);

			$result = mysqli_num_rows($query);
			if($result > 0){
				$data = mysqli_fetch_assoc($query);
				echo json_encode($data, JSON_UNESCAPED_UNICODE); //las tildes o caracteres no sean un error. //devolver un formato Json para usarlo para el nombre.
				exit;
			}
			echo "error";
			exit;
		}

		//Agregar productos a la entrada
		if($_POST['action'] == 'addProduct')
		{
			if(!empty(['cantidad']) || !empty(['precio']) || !empty(['producto_id']))
			{
				$cantidad    = $_POST['cantidad'];
				$precio      = $_POST['precio'];
				$producto_id = $_POST['producto_id'];
				$usuario_id  = $_SESSION['idUser'];

				$query_insert = mysqli_query($conection, "INSERT INTO entradas(codproducto,
																	          cantidad,precio,usuario_id)
															VALUES ($producto_id,$cantidad,$precio,$usuario_id)");

				if($query_insert){
					//ejecutar lo Amacenado
					$query_upd = mysqli_query($conection, "CALL actualizar_precio_producto($cantidad,$precio,$producto_id)");
					$result_pro = mysqli_num_rows($query_upd);
					if ($result_pro > 0) {
						$data = mysqli_fetch_assoc($query_upd);
						$data['producto_id'] = $producto_id;
						echo json_encode($data, JSON_UNESCAPED_UNICODE); //las tildes o caracteres no sean un error. //devolver un formato Json para usarlo para el nombre.
					exit;
					}
				}else{
					echo 'error';
				}
				mysqli_close($conection);
			}else{
				echo 'error';
			}
		exit;
		}

		//Eliminar Producto
		if($_POST['action'] == 'delProduct')
		{
			if(empty($_POST['producto_id']) || !is_numeric($_POST['producto_id'])){
				echo 'error';
			}else{

				$idproducto = $_POST['producto_id'];

				//$query_delet = mysqli_query($conection, "DELETE FROM usuario WHERE idusuario = $idusuario "); eliminar un registro de la base de datos
				$query_delete = mysqli_query($conection, "UPDATE producto SET estatus = 0 WHERE codproducto =$idproducto ");
				mysqli_close($conection);

				if($query_delete){
					//$alert='<p class="msg_error">Proveedor Eliminado..</p>';
					echo 'ok';
				}else{
					echo 'Error al Eliminar';
				}
			}
			echo 'error';
		}
		exit;
	}

exit;

?>