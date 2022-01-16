<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ganaste</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='src/ganaPierde.css'>
    <script src='main.js'></script>
</head>
<?php
    session_start();
?>
<body id="bodyG">
    <div class="gana">
        <h1>HAS GANADO!! Felicidades <?=$_SESSION["usuario"]?></h1>
        <h2>La palabra era <?=$_SESSION["palabra"]?></h2>
        <form action="redirigir.php" method="POST">
            <input type="submit" value="Jugar de nuevo" name="juega" class="juega">
        </form>
        <br>
        <form action="redirigir.php" method="POST">
            <input type="submit" value="Salir" class="sale" name="sale">
        </form>
    </div>
</body>
</html>