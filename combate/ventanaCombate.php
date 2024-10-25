<?php
// Incluir el archivo de la pokédex
include '../pokedex.php';

// Obtener el equipo 1 y el equipo 2 desde la URL
$equipo1 = isset($_GET['equipo1']) ? explode(',', urldecode($_GET['equipo1'])) : [];
$equipo2 = isset($_GET['equipo2']) ? explode(',', urldecode($_GET['equipo2'])) : [];

/**
 * Encuentra un Pokémon en la pokédex por su nombre.
 *
 * @param string $nombre El nombre del Pokémon a buscar.
 * @param array $pokedex La pokédex donde se buscará el Pokémon.
 * @return array|null El Pokémon encontrado, o null si no se encuentra.
 */
function obtenerPokemon($nombre, $pokedex) {
    foreach ($pokedex as $pokemon) {
        if ($pokemon['name'] === $nombre) {
            return $pokemon; // Retorna el Pokémon encontrado
        }
    }
    return null; // Retorna null si no se encuentra
}

/**
 * Calculo de daño, teniendo en cuenta tipos y posibilidad de crítico.
 *
 * @param mixed $pokeAt Pokémon atacante.
 * @param mixed $pokeDef Pokémon defensor.
 * @param mixed $log Array que guarda todo el log del combate.
 * @return float|int Daño final que, en caso de ser 0 o menos, retorna 1.
 */
function daño($pokeAt, $pokeDef, &$log) {
    $ataque_tipo = $pokeAt["ataque"] * ataqueTipos($pokeAt, $pokeDef);
    $daño = $ataque_tipo - $pokeDef["def"] + 2;
    $random = rand(1, 100); // Rand para calcular el índice de golpe crítico del 5%
    $critico = false;

    if ($random <= 5) {
        $daño *= 1.5; // Aumentar el daño en caso de golpe crítico
        $critico = true; // Marcar como golpe crítico
    }
    
    if ($daño <= 0) {
        $daño = 1; // Asegurar que el daño sea al menos 1
    }

    // Registrar el daño infligido
    if ($critico) {
        $log[] = "<span style='color:yellow;'>{$pokeAt['name']} inflige un golpe crítico de {$daño} puntos de daño a {$pokeDef['name']} (HP: {$pokeDef['hp']})</span>";
    } else {
        $log[] = "{$pokeAt['name']} inflige {$daño} puntos de daño a {$pokeDef['name']} (HP: {$pokeDef['hp']})";
    }

    return $daño; // Retornar el daño calculado
}

/**
 * Realiza un ataque de un Pokémon a otro, para bajarle la vida usando la funcion de daño
 *
 * @param array &$atacante Pokémon atacante.
 * @param array &$defensor Pokémon defensor.
 * @param array &$log Registro de combate donde se almacenan los eventos.
 * @return bool True si el Pokémon defensor se ha debilitado, false en caso contrario.
 */
function realizarAtaque(&$atacante, &$defensor, &$log) {
    $danio = daño($atacante, $defensor, $log); // Calcular el daño infligido
    $defensor['hp'] -= $danio; // Reducir la salud del defensor

    // Verificar si el defensor se ha debilitado
    if ($defensor['hp'] <= 0) {
        $log[] = "{$defensor['name']} se ha debilitado."; // Registrar debilitamiento
        return true; // Pokémon debilitado
    }
    return false; // Continúa la batalla
}

// Obtener los Pokémon del equipo 1
$team1 = [];
foreach ($equipo1 as $nombre) {
    $pokemon = obtenerPokemon($nombre, $pokedex);
    if ($pokemon) {
        $team1[] = $pokemon; // Agregar Pokémon al equipo 1
    }
}

// Obtener los Pokémon del equipo 2
$team2 = [];
foreach ($equipo2 as $nombre) {
    $pokemon = obtenerPokemon($nombre, $pokedex);
    if ($pokemon) {
        $team2[] = $pokemon; // Agregar Pokémon al equipo 2
    }
}

// Inicializar los índices de los Pokémon activos
$indice1 = 0; // Índice del Pokémon actual del equipo 1
$indice2 = 0; // Índice del Pokémon actual del equipo 2

// Almacenar el registro de combate
$log = [];

/**
 * Simula el combate entre dos equipos de Pokémon.
 *
 * @param array $equipo1 El primer equipo de Pokémon.
 * @param array $equipo2 El segundo equipo de Pokémon.
 * @return void
 */
function combate($equipo1, $equipo2) {
    global $indice1, $indice2, $log; // Acceder a variables globales

    while ($indice1 < count($equipo1) && $indice2 < count($equipo2)) {
        $pokemon1 = &$equipo1[$indice1];
        $pokemon2 = &$equipo2[$indice2];

        $log[] = "<h3>Combate: {$pokemon1['name']} vs {$pokemon2['name']}</h3>";

        $spe1 = $pokemon1['spe'];
        $spe2 = $pokemon2['spe'];

        // Turnos alternos de ataque
        while ($pokemon1['hp'] > 0 && $pokemon2['hp'] > 0) {
            $speed_tie = mt_rand(1, 2); // Determinar quién ataca primero en caso de empate de velocidad
            if ($spe1 > $spe2 || ($spe1 == $spe2 && $speed_tie == 1)) {
                // Pokémon del equipo 1 ataca primero
                if (realizarAtaque($pokemon1, $pokemon2, $log)) {
                    break; // Si el Pokémon 2 se debilita, salir del bucle
                }
        
                // Pokémon del equipo 2 ataca
                if (realizarAtaque($pokemon2, $pokemon1, $log)) {
                    break; // Si el Pokémon 1 se debilita, salir del bucle
                }
            } else {
                // Pokémon del equipo 2 ataca primero
                if (realizarAtaque($pokemon2, $pokemon1, $log)) {
                    break; // Si el Pokémon 1 se debilita, salir del bucle
                }
        
                // Pokémon del equipo 1 ataca
                if (realizarAtaque($pokemon1, $pokemon2, $log)) {
                    break; // Si el Pokémon 2 se debilita, salir del bucle
                }
            }
        }

        // Cambiar de Pokémon si uno se debilita
        if ($pokemon1['hp'] <= 0) {
            $indice1++; // Cambiar al siguiente Pokémon del equipo 1
        }
        if ($pokemon2['hp'] <= 0) {
            $indice2++; // Cambiar al siguiente Pokémon del equipo 2
        }
    }

    // Verificar quién es el ganador
    if ($indice1 < count($equipo1)) {
        $log[] = "<strong>¡El Equipo 1 ha ganado el combate!</strong>";
    } else {
        $log[] = "<strong>¡El Equipo 2 ha ganado el combate!</strong>";
    }
}

// Ejecutar la función de combate
combate($team1, $team2);

// Enlace para volver al inicio
$volverInicio = '<a href="../inicio/inicio.php">Volver al inicio</a>';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combate Pokémon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Jugador 1 -->
        <div class="player1">
            <h3>Equipo 1</h3>
            <div class="pokemon-container">
                <?php foreach ($team1 as $pk): ?>
                    <div class="pokemon-card <?php echo $pk['hp'] <= 0 ? 'derrotado' : ''; ?>">
                        <p><?php echo htmlspecialchars(ucfirst($pk['name'])); ?> <br> <?php echo htmlspecialchars($pk['hp']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo $pk['img']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Registro de combate -->
        <aside>
            <h1>Registro del Combate</h1>
            <div class="log">
                <?php foreach ($log as $entry): ?>
                    <p><?php echo $entry; ?></p>
                <?php endforeach; ?>
            </div>
        </aside>

        <!-- Jugador 2 -->
        <div class="player2">
            <h3>Equipo 2</h3>
            <div class="pokemon-container">
                <?php foreach ($team2 as $pk): ?>
                    <div class="pokemon-card <?php echo $pk['hp'] <= 0 ? 'derrotado' : ''; ?>">
                        <p><?php echo htmlspecialchars(ucfirst($pk['name'])); ?> <br> <?php echo htmlspecialchars($pk['hp']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo $pk['img']; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Enlace para volver al inicio -->
    <footer>
        <?php echo $volverInicio; ?>
    </footer>
</body>
</html>