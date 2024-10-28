<?php
echo "<br>";
if(isset($_POST["volver-pve"])){
    header("Location: ../pve/pve.php");
}elseif(isset($_POST["volver-pvp"])){
    header("Location: ../pvp/pvp.php");
}


if(isset($_POST["jugar"])){
    echo "<pre>";
    print_r($_POST["equipo1"]);
    echo "</pre>";

    echo "<pre>";
    print_r($_POST["equipo2"]);
    echo "</pre>";


}

