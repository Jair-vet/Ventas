<?php
    if(isset($_POST['enviar'])){
    	if(!empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['coreo']) && !empty($_POST['mensaje'])){
    		$nombre   = $_POST['nombre'];
    		$apellido = $_POST['apellido'];
    		$coreo    = $_POST['correo'];
    		$mensaje  = $_POST['mensaje'];

    		$header = "From: noreply@example.com" . "\r\n";
    		$header.= "Reply-To: noreply@example.com" . "\r\n";
    		$header.= "X-Mailer: PHP/". phpversion();
    		$mail= @mail($email, $nombre, $mensaje,$header);
    		if($mail){
    			header("location: contacto2.php");
    		}
    	}
    }
?>