<?php

function preaty_print($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

//funcion para generar equipos aleatorios sin pokemons repetidos
function equipo_random($pokedex)
{

    $equipo = [];
    $tamaño_pokedex = count($pokedex) - 1;
    for ($i = 0; $i < 6; $i++) {
        $random = rand(0, $tamaño_pokedex);
        $repe = false;
        $poke_random = $pokedex[$random]["name"];
        foreach ($equipo as $poke) {
            if ($poke_random == $poke) {
                $repe = true;
                break;
            }
        }
        if ($repe) {
            $i--;
        }
        if (!$repe) {
            $equipo[] = $poke_random;
        }
    }
    return $equipo;
}

function no_repes($equipo)
{

    $equipo_validado = array_unique($equipo);
    if (count($equipo) === count($equipo_validado)) {
        return true;
    } else {
        return false;
    }
}

//recibe un array de strings y devuelve una matriz con los pokemons para su posterior visualización
function select_pokemons($equipo, $pokedex)
{

    $longitud_equipo = count($equipo);
    $longitud_pokedex = count($pokedex);
    $equipo_final = [];


    for ($i = 0; $i < $longitud_equipo; $i++) {
        $poke = $equipo[$i];
        for($x = 0 ; $x< $longitud_pokedex ; $x++){
            if($poke===$pokedex[$x]["name"]){
                $equipo_final[] = ['name' => $pokedex[$x]['name'],'img' => $pokedex[$x]['img']];
                break;
            }
        }
    }
    return $equipo_final;
}

include '../pokedex.php';
$equipo1 = []; //jugador 1
$equipo2 = []; //jugador 2 o la IA
$longitud_pokedex = count($pokedex);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos_pve.css">
    <title>PVE</title>
</head>

<body>
    <form action="pve.php" method="post">
        <label for="equipo1" name="equipo1">Selecciona los 6 pokemons del equipo 1</label>
        <select id="equipo1_poke1" name="eq1_1">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>
        <select id="equipo1_poke2" name="eq1_2">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>
        <select id="equipo1_poke3" name="eq1_3">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>
        <select id="equipo1_poke4" name="eq1_4">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>
        <select id="equipo1_poke5" name="eq1_5" default="elige un pokemon">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>
        <select id="equipo1_poke6" name="eq1_6">
            <?php
            echo "<option value='default'></option>";
            for ($i = 0; $i < $longitud_pokedex; $i++) {
                $pokemon = $pokedex[$i];
                echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
            }
            ?>
        </select>

        <input type="submit" value="Validar equipo" name="equipo1">
    </form>

    <?php


    $equipo1_validado = false;


    if (isset($_POST["equipo1"])) {
        for ($i = 1; $i <= 6; $i++) {
            $equipo1[] = $_POST["eq1_" . $i];
        }
        if (no_repes($equipo1)) {
            $equipo1_validado = true;
            echo "equipo valido mi rey";
        } else {
            $equipo1_validado = false;
            echo "equipo no valido jefe";
        }
    }

    if ($equipo1_validado) {
        $equipo2 = equipo_random($pokedex);


        $pp_equipo1 = select_pokemons($equipo1,$pokedex);
        $pp_equipo2 = select_pokemons($equipo2,$pokedex);
        preaty_print($pp_equipo1);
        echo "<br>-------------<br>";
        preaty_print($pp_equipo2);
    }




    ?>



</body>

</html>