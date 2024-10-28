<?php

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
                $equipo_final[] = ['name' => $pokedex[$x]['name'], 'img' => $pokedex[$x]['img']];
                break;
            }
        }
    }
    return $equipo_final;
}

include '../pokedex.php';
$equipo1 = []; //jugaror 1
$equipo2 = []; //jugador 2 o la IA
$longitud_pokedex = count($pokedex);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <link rel="icon" href="../imgs/pokeball.ico" type="image/x-icon">
    <link rel="icon" href="../imgs/pokeball.png" sizes="32x32" type="image/png">
    <title>PVP</title>
</head>

<body>

    <a href="../inicio/inicio.php"><img class="esquina" src="../imgs/pokeball.png" alt="logo pokeball azul"></a>

    <?php


    $equipo1_validado = false;
    $equipo2_validado = false;


    if (isset($_POST["equipos"])) {
        for ($i = 1; $i <= 6; $i++) {
            $equipo1[] = $_POST["eq1_" . $i];
            $equipo2[] = $_POST["eq2_" . $i];
        }
        if (no_repes($equipo1) && no_repes($equipo2)) {
            $equipo1_validado = true;
            $equipo2_validado = true;
            echo "<script>alert('¡Equipos validos, presiona jugar para continuar!');</script>";
        } else {
            if (!no_repes($equipo1)) {
                $equipo1_validado = false;
                echo "<script>alert('¡Equipo 1 no valido, volviendo al inicio!');</script>";
                unset($_POST["equipos"]);
                header("Refresh: 0");
            } elseif (!no_repes($equipo2)) {
                $equipo2_validado = false;
                echo "<script>alert('¡Equipo 2 no valido, volviendo al inicio!');</script>";
                unset($_POST["equipos"]);
                header("Refresh: 0");
            } else {
                $equipo1_validado = false;
                $equipo2_validado = false;
                echo "<script>alert('¡Equipos no validos, volviendo al inicio!');</script>";
                unset($_POST["equipos"]);
                header("Refresh: 0");
            }
        }
    } else {
    ?>
        <div class="formulario_seleccion">
            <form action="pvp.php" method="post" class="formulario_pokes">
                <div id="jugador1" class="jugador1">
                    <label class="titulo_form" for="equipo1" name="equipo1">Selecciona los 6 pokemons del equipo 1</label>
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
                    <label class="titulo_form" for="equipo2" name="equipo2">Selecciona los 6 pokemons del equipo 2</label>
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
                <input class="botones" type="submit" value="Validar equipo" name="equipos">

            </form>
            <div>

                <div class="botones_estilos">
                    <button id="btn_ocultar_jugador1" class="botones" onclick="ocultarJugador1()">Ocultar datos player1</button>
                    <button id="btn_ocultar_jugador2" class="botones" onclick="ocultarJugador2()">Ocultar datos player2</button>
                </div>


            <?php
        }

        //equipos validados parte 2 de la ejecución

        if ($equipo1_validado && $equipo2_validado) {
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
                            <input class="botones" type="submit" value="Volver" name="volver-pvp">
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
            print_r($equipo1);
        }

            ?>

            <script src="js_pvp.js"></script>
</body>

</html>