<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta http-equiv="Content-Type" content="text/html" charset="utf-8">
    <title>Ahorcado</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='src/juego.css'>
    <script src='main.js'></script>
</head>

<?php
    session_start();
    if(isset($_SESSION["usuario"])){
        $usuario = $_SESSION["usuario"];
    }
    $arrPalabras = convertirFichero("defecto.txt");
    if(isset($_POST["defecto"])){//Si hemos pulsado la opcion del archivo por defecto
        
        $arrPalabras = convertirFichero("defecto.txt");
    }elseif (isset($_SESSION["creado"])) {//Si hemos pulsado la opcion de subir un nuevo archivo
        
        $arrPalabras = convertirFichero("creado.txt");
    }
    $posAleatoria = rand(1, count($arrPalabras)-1);
        if(!isset($_SESSION["palabra"]) || $_SESSION["palabra"] == null){
            $_SESSION["palabra"] = $arrPalabras[$posAleatoria]; //Donde guardaremos la palabra
            $_SESSION["palabra"] = trim(strtolower($_SESSION["palabra"]));//La convertimos bien
            $_SESSION["intentos"] = 7;
            $_SESSION["fallos"] = "";
            $arr = str_split($_SESSION["palabra"]);
                for ($i=0; $i < count($arr); $i++) { 
                    $arr[$i] = "-";
                }
                
            $pista = implode("",$arr);
            $_SESSION["pista"] = $pista;
            $_SESSION["pista"] = trim(strtolower($_SESSION["pista"]));
            
        }else{
            
            if(isset($_POST["letra"])){        
                valorSeguro($_POST["letra"]);   
                $_POST["letra"] = utf8_encode(utf8_decode($_POST["letra"]));
                $_POST["letra"] = eliminar_tildes(trim(strtolower($_POST["letra"])));
                if ($_SESSION["intentos"] <= 1) {//Perdemos
                    header("Location: ./pierdes.php");
                    
                }
                $arrP = str_split($_SESSION["palabra"]);//Convertimos palabra en array
                $arrPos = encuentraLetra($_POST["letra"], $arrP);//Este array contendra las posiciones de nuestra letra
                
                if(empty($arrPos)){//Si el array esta vacio significa que fallo
                    $_SESSION["intentos"] = $_SESSION["intentos"] - 1;
                    //Actualizando lista de fallos
                    $_SESSION["fallos"] = $_SESSION["fallos"].strtoupper($_POST["letra"])."-";//No tengo en cuenta que este repetida la letra para que se de cuenta el usuario de los fallos
                }else{//Si no esta vacio habra posiciones
                    $arrPista = str_split($_SESSION["pista"]);//Convertimos la pista a array
                    for ($i=0; $i < count($arrPos); $i++) { //Con este bucle añadiremos al array de pista las letras en la posicion correcta
                        $arrPista[$arrPos[$i]] = $_POST["letra"];
                    }
                    $_SESSION["pista"] = implode("", $arrPista);//Guardamos la sesion en forma de palabra
                    //GANAMOS
                    if(strcmp(trim($_SESSION["palabra"]), trim($_SESSION["pista"]))==0){
                        header("Location: ./ganas.php");
                    }
                    
                }
                
            }
            
        }
        //Para la imagen
        switch ($_SESSION["intentos"]) {
            case '1':
                $imagen = "./src/img/ahorcado6.png";
                break;
            case '2':
                $imagen = "./src/img/ahorcado5.png";
                break;
            case '3':
                $imagen = "./src/img/ahorcado4.png";
                break;
            case '4':
                $imagen = "./src/img/ahorcado3.png";
                break;
            case '5':
                $imagen = "./src/img/ahorcado2.png";
                break;
            case '6':
                $imagen = "./src/img/ahorcado1.png";
                break;
            case '7':
                $imagen = "./src/img/ahorcado0.png";
                break;
        }
?>

    <body>
        <div class="header">
            <h1>Juguemos <?=$usuario?></h1>
        </div>
        <div class="grid-container">
            <div class="imagen">
                <img src='<?=$imagen?>' alt='no' id='imagen'>
                <div class='pista'>Pista:
                    <p><?=strtoupper($_SESSION["pista"])?></p>
                </div>
            </div>
            <div class="medio">
                <form method='POST'>
                    <label for="letra">Escriba una letra:
                        <br>
                        <br>
                        <input type='text' name='letra' required autofocus maxlength="1" pattern="[a-n|n-z|A-N|N-Z]">
                        <br>
                        <br>
                    </label>
                    <input type='submit'>
                </form>
                <p class="fallos">Fallos: <?=$_SESSION["fallos"]?></p>
            </div>
        </div>           
    </body>
</html>
<?php
    function encuentraLetra($letra, $arrayPalabra){
        $arrPos = array();//Array de posiciones de dicha letra.
        for ($i=0; $i < count($arrayPalabra); $i++) { 
            if ($arrayPalabra[$i] == $letra) {
                array_push($arrPos, $i);
            }
        }
       
        return $arrPos;//Devolvemos las posiciones de donde se encuentra nuestro array
        

    }

    //Convierte fichero en array
    function convertirFichero($nombreFichero){
        $arr = array();
        $fichero = fopen($nombreFichero, "r") or die("Error de apertura");//Abrimos el fichero 
        While(!feof($fichero)){//recorremos por linea
            array_push($arr, utf8_encode(utf8_decode(fgets($fichero))));//Añadimos cada linea al array que devolveremos
            }
            fclose($fichero);
        return $arr;
    }
    function eliminar_tildes($cadena){

        //Codificamos la cadena en formato utf8 en caso de que nos de errores
        $cadena = utf8_encode($cadena);
    
        //Ahora reemplazamos las letras
        $cadena = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $cadena
        );
    
        $cadena = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $cadena );
    
        $cadena = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $cadena );
    
        $cadena = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $cadena );
    
        $cadena = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $cadena );
    
        $cadena = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $cadena
        );
    
        return $cadena;
    }
    function valorSeguro($cadena){
        $cadena = trim($cadena);
        $cadena = stripslashes($cadena);
        $cadena = htmlspecialchars($cadena);
    }
?>
