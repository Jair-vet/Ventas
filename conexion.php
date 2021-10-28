<?php
	
	$host = '127.0.0.1';
	$user = 'root';
	$password = 'CARLOS2300j';
	$db = 'ventas';

	$conection = @mysqli_connect($host, $user, $password, $db);

	// mysqli_close($conection); Cerrar la conexion a la base de datos.

	if(!$conection){
		echo  "Error con la conexion!!";
	}
?>