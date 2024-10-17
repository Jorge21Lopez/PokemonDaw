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

function realizarCombate() {
    global $equipo1, $equipo2, $log;

    if (empty($equipo1) || empty($equipo2)) {
        return true;
    }

    $pk1 = null;
    foreach ($equipo1 as &$pokemon1) {
        if ($pokemon1['vida_actual'] > 0) {
            $pk1 = &$pokemon1;
            break;
        }
    }

    if (!$pk1) {
        logCombate("¡El equipo 2 ha ganado el combate!");
        return true;
    }

    $pk2 = null;
    foreach ($equipo2 as &$pokemon2) {
        if ($pokemon2['vida_actual'] > 0) {
            $pk2 = &$pokemon2;
            break;
        }
    }

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

    if ($pk2['vida_actual'] > 0) {
        $damage2 = rand(10, 20);
        $pk1['vida_actual'] -= $damage2;
        logCombate("El Pokémon {$pk2['nombre']} ataca a {$pk1['nombre']} infligiendo $damage2 puntos de daño.");

        if ($pk1['vida_actual'] <= 0) {
            $pk1['vida_actual'] = 0;
            logCombate("¡{$pk1['nombre']} ha sido derrotado!");
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
                    <div class="pokemon-card">
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida_total']); ?> / <?php echo htmlspecialchars($pk['vida_actual']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                        <?php if ($pk['vida_actual'] <= 0): ?>
                            <p style="color: red;">¡Derrotado!</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (!empty($equipo1)): ?>
                <div class="pkAct1">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($equipo1[0]['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($equipo1[0]['vida_total']); ?> / <?php echo htmlspecialchars($equipo1[0]['vida_actual']); ?> hp</p>
                    <?php if ($equipo1[0]['vida_actual'] > 0): ?>
                        <!-- Mostrar la imagen del Pokémon si tiene vida -->
                        <?php echo ($equipo1[0]['img']); ?>
                    <?php else: ?>
                        <!-- Mostrar que está derrotado -->
                        <p style="color: red;">¡Derrotado!</p>
                    <?php endif; ?>
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
                    <div class="pokemon-card">
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida_total']); ?> / <?php echo htmlspecialchars($pk['vida_actual']); ?> hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                        <?php if ($pk['vida_actual'] <= 0): ?>
                            <p style="color: red;">¡Derrotado!</p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (!empty($equipo2)): ?>
                <div class="pkAct2">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($equipo2[0]['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($equipo2[0]['vida_total']); ?> / <?php echo htmlspecialchars($equipo2[0]['vida_actual']); ?> hp</p>
                    <?php if ($equipo2[0]['vida_actual'] > 0): ?>
                        <!-- Mostrar la imagen del Pokémon si tiene vida -->
                        <?php echo ($equipo2[0]['img']); ?>
                    <?php else: ?>
                        <!-- Mostrar que está derrotado -->
                        <p style="color: red;">¡Derrotado!</p>
                    <?php endif; ?>
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

