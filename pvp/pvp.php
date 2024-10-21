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
        $poke_random = $pokedex[$random];
        foreach ($equipo as $poke) {
            if ($poke_random["name"] == $poke["name"]) {
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

//recibe un array de strings y devuelve una matriz con los pokemons del array
function select_pokemons($equipo, $pokedex)
{

    $longitud_equipo = count($equipo);
    $longitud_pokedex = count($pokedex);
    $equipo_final = [];


    for ($i = 0; $i < $longitud_equipo; $i++) {
        $poke = $equipo[$i];
        for ($x = 0; $x < $longitud_pokedex; $x++) {
            if ($poke === $pokedex[$x]["name"]) {
                $equipo_final[] = $pokedex[$x];
                break;
            }
        }
    }
    return $equipo_final;
}

include '../pokedex.php';
$player1 = []; //jugaror 1
$player2 = []; //jugador 2 o la IA
$longitud_pokedex = count($pokedex);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVP</title>
    <link rel="stylesheet" href='estilos_pvp.css'>

</head>

<body>

    <form action="pvp.php" method="post" class="formulario_pokes">
        <div id="jugador1" class="jugador1">
            <label for="equipo1" name="equipo1">Selecciona los 6 pokemons del equipo 1</label>
            <br>
            <select id="select_eq1" name="eq1_1">
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

        </div>
        <!-- ---------------------------------------------------------------- -->
        <div id="jugador2">
            <label for="equipo2" name="equipo2">Selecciona los 6 pokemons del equipo 2</label>
            <br>
            <select id="equipo2_poke1" name="eq2_1">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
            <select id="equipo2_poke2" name="eq2_2">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
            <select id="equipo2_poke3" name="eq2_3">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
            <select id="equipo2_poke4" name="eq2_4">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
            <select id="equipo2_poke5" name="eq2_5" default="elige un pokemon">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
            <select id="equipo2_poke6" name="eq2_6">
                <?php
                echo "<option value='default'></option>";
                for ($i = 0; $i < $longitud_pokedex; $i++) {
                    $pokemon = $pokedex[$i];
                    echo "<option value=" . $pokedex[$i]['name'] . ">" . $pokemon['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <br>
        <input type="submit" value="Validar equipo" name="equipos">

    </form>

    <button id="btn_ocultar_jugador1" onclick="ocultarJugador1()">Ocultar datos player1</button>
    <button id="btn_ocultar_jugador2" onclick="ocultarJugador2()">Ocultar datos player2</button>







    <?php


    $equipo1_validado = false;
    $equipo2_validado = false;


    if (isset($_POST["equipos"])) {
        for ($i = 1; $i <= 6; $i++) {
            $player1[] = $_POST["eq1_" . $i];
            $player2[] = $_POST["eq2_" . $i];
        }
        if (no_repes($player1)) {
            $equipo1_validado = true;
            echo "<br>equipo 1 valido mi rey<br>";
        } else {
            $equipo1_validado = false;
            echo "<br>equipo1 no valido jefe <br>";
        }
        if (no_repes($player2)) {
            $equipo2_validado = true;
            echo "<br>equipo 2 valido mi rey<br>";
        } else {
            $equipo2_validado = false;
            echo "<br>equipo2 no valido jefe<br>";
        }
    }


    if ($equipo1_validado && $equipo2_validado) {
        $player1_valido = select_pokemons($player1, $pokedex);
        $player2_valido = select_pokemons($player2, $pokedex);
        preaty_print($player1_valido);
        preaty_print($player2_valido);
    }

    ?>


    <script src="pvp.js"></script>
</body>

</html>