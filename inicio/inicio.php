<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combates pokemon</title>
    <link rel="stylesheet" href="estilos_inicio.css">
    <link rel="icon" href="../imgs/pokeball.ico" type="image/x-icon">
    <link rel="icon" href="../imgs/pokeball.png" sizes="32x32" type="image/png">



</head>

<body>

    <img id="logo" src="../imgs/logo_v1.png">
    <form action="inicio.php" method="post">
        <p>Elige el modo</p>
        <input type="submit" name="pve" value="PVE">
        <input type="submit" name="pvp" value="PVP">
    </form>

    <?php


    if (isset($_POST["pve"])) {
        header("Location: ../pve/pve.php");
        exit;
    } elseif (isset($_POST["pvp"])) {
        header("Location: ../pvp/pvp.php");
        exit;
    }







    ?>
    <footer>
        <p id="pie"><span>&copy;</span> 2024 Todos los derechos reservados a López<sup>2</sup></p>
    </footer>
</body>

</html>