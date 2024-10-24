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
        for ($x = 0; $x < $longitud_pokedex; $x++) {
            if ($poke === $pokedex[$x]["name"]) {
                $equipo_final[] = ['name' => $pokedex[$x]['name'], 'img' => $pokedex[$x]['img']];
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

    <?php


    $equipo1_validado = false;


    if (isset($_POST["equipo1"])) {
        for ($i = 1; $i <= 6; $i++) {
            $equipo1[] = $_POST["eq1_" . $i];
        }
        if (no_repes($equipo1)) {
            $equipo1_validado = true;
            echo "<script>alert('¡Equipo valido, presiona jugar para continuar!');</script>";
        } else {
            $equipo1_validado = false;
            echo "<script>alert('¡Equipo no valido, rellenalo otra vez!');</script>";
        }
    } else {
    ?>
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


    }

    if ($equipo1_validado) {
        $equipo2 = equipo_random($pokedex);


        $pp_equipo1 = select_pokemons($equipo1, $pokedex);
        $pp_equipo2 = select_pokemons($equipo2, $pokedex);
        ?>
        <div class="equipo-container">
        <!-- Equipo 1 -->
        <div class="equipo">
            <h3>Equipo 1</h3>
            <?php 
                foreach ($pp_equipo1 as $poke){
                    ?>
                    <div class="contenedo-poke">
                        <p><?=$poke['name']?></p>
                        <?=$poke['img']?>
                    </div>
                    <?php
                }
            ?>
        </div>

        <!-- Equipo 2 -->
        <div class="equipo">
            <h3>Equipo 2</h3>
            <?php 
                foreach ($pp_equipo2 as $poke){
                    ?>
                    <div class="contenedo-poke">
                        <p><?=$poke['name']?></p>
                        <?=$poke['img']?>
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="action-button">
    <form action="../combate/combate.php" method="post">
        <?php
        foreach($equipo1 as $key => $poke1){
            echo '<input type="hidden" name="equipo1[]" value="' . $poke1 . '">';

        }
        foreach($equipo2 as $key => $poke2){
            echo '<input type="hidden" name="equipo2[]" value="' . $poke2 . '">';

        }

        ?>
        <input type="submit" value="Jugar" name="jugar">
    </form>
    </div>
    
    <?php
    }




    ?>



</body>

</html>