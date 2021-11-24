<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> Contacto</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php include "incluides/nav.php"; ?>

    <?php
        if(isset($_POST['sendmail'])){
            if(mail($_POST['correo'], $_POST['nombre'], $_POST['mensaje'])){
                echo header("Location: contacto2.php");
            }else{
                echo "CORREO ENVIADO";
                echo header("Location: contacto2.php");
            }
        }
    ?>
   <div class="form_register">
            <h1> Enviar Correo</h1>
            <hr>  
            <form method="post">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre" require>
                <label for="apellido">Apellidos</label>
                <input type="text" name="apellido" id="apellido" placeholder="Apellidos" require>
                <label for="correo">Correo</label>
                <input type="text" name="correo" id="correo" placeholder="Correo electronico" require>
                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="mensaje" require></textarea><br>

                <button type="submit" class="btn_save" name="sendmail">Enviar</button> 
            </form>
        </div> 
</body>
<?php include "incluides/footer.php"; ?>
</html>