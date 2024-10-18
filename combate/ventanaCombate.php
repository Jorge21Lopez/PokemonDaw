<?php
include "../pokedex.php";
session_save_path("E:/JORGEE/2ºA DAW/Desarrollo Servidor/Practicas/sesiones");
session_start();

if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: ../inicio/inicio.php");
    exit();
}

if (!isset($_SESSION['equipo1'])) {
    $_SESSION['equipo1'] = [];
}
if (!isset($_SESSION['equipo2'])) {
    $_SESSION['equipo2'] = [];
}
if (!isset($_SESSION['log'])) {
    $_SESSION['log'] = [];
}

function obtenerVidaTotal($nombrePk) {
    $infoPk = infoPokemon($nombrePk);
    return $infoPk ? $infoPk['hp'] : 0;
}

if (isset($_GET['namePk'])) {
    foreach ($_GET['namePk'] as $nombrePk1) {
        $vidaTotalPk1 = obtenerVidaTotal($nombrePk1);
        if ($vidaTotalPk1) {
            if (!in_array($nombrePk1, array_column($_SESSION['equipo1'], 'nombre'))) {
                $_SESSION['equipo1'][] = [
                    'nombre' => $nombrePk1,
                    'vida_total' => $vidaTotalPk1,
                    'vida_actual' => $vidaTotalPk1,
                    'img' => infoPokemon($nombrePk1)['img']
                ];
            } else {
                logCombate("Pokémon '{$nombrePk1}' ya está en el equipo 1.");
            }
        } else {
            logCombate("Pokémon '{$nombrePk1}' no encontrado.");
        }
    }
}

if (isset($_GET['namePk2'])) {
    foreach ($_GET['namePk2'] as $nombrePk2) {
        $vidaTotalPk2 = obtenerVidaTotal($nombrePk2);
        if ($vidaTotalPk2) {
            if (!in_array($nombrePk2, array_column($_SESSION['equipo2'], 'nombre'))) {
                $_SESSION['equipo2'][] = [
                    'nombre' => $nombrePk2,
                    'vida_total' => $vidaTotalPk2,
                    'vida_actual' => $vidaTotalPk2,
                    'img' => infoPokemon($nombrePk2)['img']
                ];
            } else {
                logCombate("Pokémon '{$nombrePk2}' ya está en el equipo 2.");
            }
        } else {
            logCombate("Pokémon '{$nombrePk2}' no encontrado.");
        }
    }
}

$equipo1 = $_SESSION['equipo1'];
$equipo2 = $_SESSION['equipo2'];
$log = &$_SESSION['log'];

function logCombate($message){
    global $log;
    $log[] = $message;
}

// Función para obtener el Pokémon activo (el primero con vida) de un equipo
function obtenerPokemonActivo($equipo) {
    foreach ($equipo as $pokemon) {
        if ($pokemon['vida_actual'] > 0) {
            return $pokemon;
        }
    }
    return null; // Si no hay Pokémon vivos
}

function realizarCombate() {
    global $equipo1, $equipo2, $log;

    if (empty($equipo1) || empty($equipo2)) {
        return true;
    }

    $pk1 = obtenerPokemonActivo($equipo1);
    if (!$pk1) {
        logCombate("¡El equipo 2 ha ganado el combate!");
        return true;
    }

    $pk2 = obtenerPokemonActivo($equipo2);
    if (!$pk2) {
        logCombate("¡El equipo 1 ha ganado el combate!");
        return true;
    }

    $damage1 = rand(10, 20);
    $pk2['vida_actual'] -= $damage1;
    logCombate("El Pokémon {$pk1['nombre']} ataca a {$pk2['nombre']} infligiendo $damage1 puntos de daño.");

    if ($pk2['vida_actual'] <= 0) {
        $pk2['vida_actual'] = 0;
        logCombate("¡{$pk2['nombre']} ha sido derrotado!");
    }

    // Actualizar en sesión
    foreach ($equipo2 as &$poke) {
        if ($poke['nombre'] == $pk2['nombre']) {
            $poke['vida_actual'] = $pk2['vida_actual'];
        }
    }

    if ($pk2['vida_actual'] > 0) {
        $damage2 = rand(10, 20);
        $pk1['vida_actual'] -= $damage2;
        logCombate("El Pokémon {$pk2['nombre']} ataca a {$pk1['nombre']} infligiendo $damage2 puntos de daño.");

        if ($pk1['vida_actual'] <= 0) {
            $pk1['vida_actual'] = 0;
            logCombate("¡{$pk1['nombre']} ha sido derrotado!");
        }

        // Actualizar en sesión
        foreach ($equipo1 as &$poke) {
            if ($poke['nombre'] == $pk1['nombre']) {
                $poke['vida_actual'] = $pk1['vida_actual'];
            }
        }
    }

    $_SESSION['equipo1'] = $equipo1;
    $_SESSION['equipo2'] = $equipo2;

    return false;
}

$combateTerminado = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['cerrar_sesion'])) {
    $combateTerminado = realizarCombate();
}
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
                <?php foreach ($equipo1 as $pk): ?>
                    <div class="pokemon-card <?php echo $pk['vida_actual'] <= 0 ? 'derrotado' : ''; ?>">
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida_total']); ?> / <?php echo htmlspecialchars($pk['vida_actual']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php 
            // Obtener el Pokémon activo para el equipo 1
            $pkActivo1 = obtenerPokemonActivo($equipo1);
            if ($pkActivo1): ?>
                <div class="pkAct1">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($pkActivo1['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($pkActivo1['vida_total']); ?> / <?php echo htmlspecialchars($pkActivo1['vida_actual']); ?> hp</p>
                    <?php echo ($pkActivo1['img']); ?>
                </div>
            <?php endif; ?>

            <?php if (!$combateTerminado): ?>
                <!-- Botón para continuar el combate -->
                <form method="post">
                    <button type="submit">Atacar</button>
                </form>
            <?php else: ?>
                <h2>El combate ha terminado.</h2>
            <?php endif; ?>
                    
            <!-- Botón para volver -->
            <form method="post">
                <button type="submit" name="cerrar_sesion">Salir del Combate</button>
            </form>
        </div>

        <!-- Jugador 2 -->
        <div class="player2">
            <h3>Equipo 2</h3>
            <div class="pokemon-container">
                <?php foreach ($equipo2 as $pk): ?>
                    <div class="pokemon-card <?php echo $pk['vida_actual'] <= 0 ? 'derrotado' : ''; ?>">
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida_total']); ?> / <?php echo htmlspecialchars($pk['vida_actual']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php 
            // Obtener el Pokémon activo para el equipo 2
            $pkActivo2 = obtenerPokemonActivo($equipo2);
            if ($pkActivo2): ?>
                <div class="pkAct2">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($pkActivo2['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($pkActivo2['vida_total']); ?> / <?php echo htmlspecialchars($pkActivo2['vida_actual']); ?> hp</p>
                    <?php echo ($pkActivo2['img']); ?>
                </div>
            <?php endif; ?>
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
</body>
</html>
