<?php

/**
 * Generar equipos aleatorios sin pokemons repetidos
 * @param mixed $pokedex, que almacena todos los pokemon disponibles
 * @return array
 */
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

/**
 * Verifica que no haya repetidos en el equipo
 * @param array con los pokemon del equipo
 * @return bool
 */
function no_repes($equipo)
{

    $equipo_validado = array_unique($equipo);
    if (count($equipo) === count($equipo_validado)) {
        return true;
    } else {
        return false;
    }
}

/**
 * Proporciona el nombre e imagen de cada pokemon del equipo
 * @param array con los pokemon del equipo
 * @param mixed $pokedex de datos con los pokemon
 * @return array{img: mixed, name: mixed[]}
 */
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
    <link rel="icon" href="../imgs/pokeball.ico" type="image/x-icon">
    <link rel="icon" href="../imgs/pokeball.png" sizes="32x32" type="image/png">
    <title>PVE</title>
</head>

<body>

    <a href="../inicio/inicio.php"><img class="esquina" src="../imgs/pokeball.png" alt="logo pokeball azul"></a>
    
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
            unset($_POST["equipo1"]);
            header("Refresh: 0");
        }
    } else {
    ?>
        <div class="formulario_seleccion">
            <form action="pve.php" method="post">
                <label id="titulo_form" for="equipo1" name="equipo1">Selecciona los 6 pokemons del equipo 1</label>
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

                <input class="botones" type="submit" value="Validar equipo" name="equipo1">
            </form>
        </div>
    <?php


    }

    if ($equipo1_validado) {

        $equipo2 = equipo_random($pokedex);

        $pp_equipo1 = select_pokemons($equipo1, $pokedex);
        $pp_equipo2 = select_pokemons($equipo2, $pokedex);
    ?>
        <div class="equipos">
            <!-- Equipo 1 -->

            <div class="equipo">

                <div class="contenedor_pokemon"></div>
                <div class="contenedor_pokemon">
                    <h3 class="titulo">Equipo 1</h3>
                </div>
                <div class="contenedor_pokemon"></div>
                <?php
                foreach ($pp_equipo1 as $poke) {
                ?>
                    <div class="contenedor_pokemon">
                        <?= $poke['img'] ?>
                        <p><?= $poke['name'] ?></p>

                    </div>
                <?php
                }
                ?>
            </div>
            <!--Boton para enviar los pokes-->
            <div class="formulario_enviar">
                <form action="../combate/ventanaCombate.php" method="post">
                    <?php
                    foreach ($equipo1 as $key => $poke1) {
                        echo '<input type="hidden" name="equipo1[]" value="' . $poke1 . '">';
                    }
                    foreach ($equipo2 as $key => $poke2) {
                        echo '<input type="hidden" name="equipo2[]" value="' . $poke2 . '">';
                    }

                    ?>
                    <input class="botones" type="submit" value="Jugar" name="jugar">
                    <input class="botones" type="submit" value="Volver" name="volver-pve">
                </form>

            </div>

            <!-- Equipo 2 -->
            <div class="equipo">
                <div class="contenedor_pokemon"></div>
                <div class="contenedor_pokemon">
                    <h3 class="titulo">Equipo 2</h3>
                </div>
                <div class="contenedor_pokemon"></div>
                <?php
                foreach ($pp_equipo2 as $poke) {
                ?>
                    <div class="contenedor_pokemon">
                        <?= $poke['img'] ?>
                        <p><?= $poke['name'] ?></p>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>


    <?php
    }
    ?>

</body>

</html>