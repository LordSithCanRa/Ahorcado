<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archivo Seleccionado</title>
    <link rel='stylesheet' type='text/css' media='screen' href='src/leer.css'>
</head>
<body>
<?php
    /* Funcion que nos devuelve un color aleatorio */
    
    
    function verFichero($nombreFichero){
        $fichero = fopen($nombreFichero, "r") or die("Error de apertura");//Abrimos el fichero 
        While(!feof($fichero)){//recorremos por linea
            echo "<p class='palabra'>".utf8_encode(utf8_decode(fgets($fichero)))."</p>";//cogemos la linea en el instante
            }
            fclose($fichero);
    }
    //Nombre original del fichero
    $nombre = $_FILES["fichero"]["name"];
    
    
    //Nombre temporal del fichero con ruta
    $nomTemp = $_FILES["fichero"]["tmp_name"];
    //ruta donde dejaré al fichero
    $exten = pathinfo($nombre); //carga datos del fichero
    //comprobamos que sea .txt
    if(strcmp(strtolower($exten["extension"]), "txt")== 0){
        if ($_FILES["fichero"]["error"] == 0) {
            move_uploaded_file($nomTemp, "creado.txt");//Movemos el fichero subido y le cambiamos el nombre
        }
        echo "<div class='info'>";
            echo "<p class='nomArch'>Nombre del archivo: ".$nombre."</p>";//Nombre que sera cambiado
            echo "<p class='t2'>Palabras creadas:</p>";
            verFichero("creado.txt");
            echo "<h3>Archivo subido correctamente</h3>";
            echo "<form action='juego.php' method='POST'>
                    <input type='submit' value='JUGAR' name='creadoP'>
                </form>";
        echo"</div>";
    }else{
        echo"<div class='error'>";
            echo "<h1>ERROR, SOLO SE PERMITEN .TXT</h1>";
            echo "<a href='nuevoArchivo.php'>Volver a la subida del archivo</a>";
        echo"</div>";

    }
?>
</body>
</html>