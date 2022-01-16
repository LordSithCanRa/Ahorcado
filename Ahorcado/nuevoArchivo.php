<?php
 if(isset($_POST["creado"])){
     session_start();
    $_SESSION["creado"] = "creado";
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='src/formArch.css'>
    <title>Introduce un archivo</title>
</head>
<body>   
        <form method='POST' action='leerArchivo.php'  enctype="multipart/form-data">
            Archivo <input type='file' name='fichero' required><br>
            <input type='submit' value='Enviar'>
        </form>  
</body>
</html>