<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>ElegirOpcion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='src/estiloEntrada.css'>
    
</head>
<body>
    <?php
    $mostrar = false;//Mostrar caja de error
    if(isset($_POST["usuario"]) and isset($_POST["password"])){
        
            if (comprobarUsuario($_POST["usuario"], $_POST["password"])) {//Si se encuentra el usuario
                $mostrar = false;
            }else{//No se encuentra el usuario
                $mensaje = "No se ha encontrado el usuario dentro de nuestro fichero";
                $mostrar = true;
            }
        
    }

    function comprobarUsuario($usuario, $clave){//Comprobamos que el usuario y la clave estan contenidas en un 
        $encontrar = false;
        $fichero = fopen("usuarios.txt", "r") or die ("No hay usuarios");
        if($fichero){
            while(!feof($fichero) and !$encontrar){
                $linea = fgets($fichero);//Leo una linea
                $usr = explode("-", $linea);//Separo dicha linea buscando el espacio => Usuario Clave
                //$usr seria un array de dos posiciones
                if(!empty($usr[0])){//El fichero esta vacio
                    $usr[1] = trim($usr[1]);
                    if(($usr[0] == $usuario) and ($usr[1] == $clave)){//Comprobacion de que concuerda lo que pasamos con lo que hay dentro del fichero
                        $encontrar = true;
                    }
                    
                }
            }
            fclose($fichero);
        }
        return $encontrar;
    }
    if ($mostrar) {//Lo que se muestra en funcion de si introduce bien o no el usuario
        echo "<div class='error'>";
            echo "<p>".$mensaje."</p>";
            echo "<a href='index.html'>Volver</a>";
        echo "</div>";
    }else{
        echo"<div id='titulo'>";
            echo "<h1>Bienvenido ".$_POST["usuario"]."</h1>";
        echo"</div>";
        session_start();
        $_SESSION["usuario"] = $_POST["usuario"];
        echo"<div class='botones'>";
            echo "<form action='nuevoArchivo.php' method='POST'>";
                echo "<input type='submit' value='Crear archivo' name='creado' id='crear'>";
            echo "</form>";
            echo "<form action='juego.php' method='POST'>";
                echo "<input type='submit' value='Archivo por defecto' name='defecto'>";
            echo "</form>";
        echo "</div>";
    }
    ?>
</body>
</html>