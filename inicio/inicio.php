<?php
ob_start();

function preaty_print($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}

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
    return count($equipo) === count($equipo_validado);
}

function select_pokemons($equipo, $pokedex)
{
    $equipo_final = [];
    foreach ($equipo as $poke) {
        foreach ($pokedex as $pokemon) {
            if ($poke === $pokemon["name"]) {
                $equipo_final[] = $pokemon;
                break;
            }
        }
    }
    return $equipo_final;
}

include '../pokedex.php';
$player1 = []; 
$player2 = []; 
$longitud_pokedex = count($pokedex);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PVE</title>
</head>

<body>
    <form action="inicio.php" method="post">
        <label for="equipo1">Selecciona los 6 pokémon del equipo 1</label>
        <?php for ($i = 1; $i <= 6; $i++): ?>
            <select id="equipo1_poke<?php echo $i; ?>" name="eq1_<?php echo $i; ?>">
                <option value='default'></option>
                <?php
                for ($j = 0; $j < $longitud_pokedex; $j++) {
                    echo "<option value='" . $pokedex[$j]['name'] . "'>" . $pokedex[$j]['name'] . "</option>";
                }
                ?>
            </select>
        <?php endfor; ?>

        <input type="submit" value="Validar equipo" name="equipo1">
    </form>

    <?php
    $equipo1_validado = false;

    if (isset($_POST["equipo1"])) {
        for ($i = 1; $i <= 6; $i++) {
            $player1[] = $_POST["eq1_" . $i];
        }

        if (no_repes($player1)) {
            $equipo1_validado = true;
        } else {
            echo "Equipo no válido. Hay pokémons repetidos.";
        }

        if ($equipo1_validado) {
            $player2 = equipo_random($pokedex);

            $equipo1_url = implode(',', $player1);
            $equipo2_url = implode(',', array_map(function($poke) {
                return $poke['name'];
            }, $player2));

            $url = "../combate/ventanaCombate.php?equipo1=" . urlencode($equipo1_url) . "&equipo2=" . urlencode($equipo2_url);
            header("Location: $url");
            exit(); 
        }
    }

    ob_end_flush(); 
    ?>
</body>
</html>
