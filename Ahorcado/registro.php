<?php
    $errorIns = false;
    if (isset($_POST["usuario"]) and isset($_POST["password"])) { // se ha entrado por el formulario
            $estaUsu = comprobarUsuario($_POST["usuario"], $_POST["password"]);
            if (!$estaUsu) { //el usuario no está
                $errorIns = insertaUsuario($_POST["usuario"], $_POST["password"]); //devolvemos si se ha insertado correctamente
                
            } else{
                $errorIns = true; //el usuario estaba
            }  
        
    }
    function insertaUsuario($usuario, $clave){
        $error = false;
        $fichero = fopen("usuarios.txt", "a");
        if ($fichero) {
            $linea =  $usuario . "-" . $clave . "\n"; //para que cada usuario esté en una nueva línea
            $error = fwrite($fichero, $linea);

            fclose($fichero);
        }
        return !$error; //si se introduce no hay error
    }

    //busca un nuevo usuario
    function comprobarUsuario($usuario, $clave){
        $enc = false; //para controlar si lo encontramos
        $fichero = fopen("usuarios.txt", "r") or die("no hay usuarios");
        if ($fichero) {
            while (!feof($fichero) and !$enc) { //paramos si lo encontramos o fin de fichero
                $linea = fgets($fichero);
                $usr = explode("-", $linea); //separo el nombre y la clave
                if (!empty($usr[0])) {//el fichero está vacío
                    $usr[1] = trim($usr[1]); //evita el fin de linea
                    if (($usr[0] == $usuario) and ($usr[1] == $clave)){//si el usuario y la clave
                        $enc = true;
                    }else{
                        $enc = false;
                    }
                        
                }
            }
            fclose($fichero);
        }
        return $enc;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Iniciar sesion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='src/estiloLogin.css'>
    <script src='main.js'></script>
</head>
<body>
    <?php
        if(isset($_POST["usuario"]) and isset($_POST["password"])){//Si tenemos los valores
            if (!$errorIns){
               echo"<div class='correcto'>";
                    echo "<p> ".$_POST["usuario"] . " SE HA INTRODUCIDO CORRECTAMENTE </p>";
                    echo"<br>";
                    echo "<form method='POST' action='entrada.php'>
                                <input type='hidden' name='usuario' value='".$_POST["usuario"]."'>
                                <input type='hidden' name='password' value='".$_POST["password"]."'>
                                <input type='submit' value='ir al juego'>
                            </form>";
               echo"</div>";
                /* echo "<a href='entrada.php'>Ir al juego</a>";  */
            }else{//error de registro
                echo "<div class='error'>";
                    echo "<p>ERROR: EL USUARIO YA EXISTE</p>";
                    echo "<a href='registro.html'>Volver a registro</a>"; 
                echo "</div>";
            }    
        }
    ?>
</body>
</html>
