<?php
    session_start();

    if (isset($_POST["sale"])) {
       session_destroy();
       header("Location: ./index.html");
    }elseif (isset($_POST["juega"])) {
        //Jugarmos con el archivo por defecto
        $_SESSION["palabra"] = null;
        header("Location: ./juego.php");
        
    }

?>