<?php
include "../pokedex.php";
session_save_path("E:/JORGEE/2ºA DAW/Desarrollo Servidor/Practicas/sesiones");
session_start();

// Cerrar sesión si se envía la solicitud
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: ../inicio/inicio.php"); // Cambiar a la página principal
    exit();
}

// Inicialización de las variables de sesión si no están establecidas
if (!isset($_SESSION['equipo1'])) {
    $_SESSION['equipo1'] = []; // Equipo 1 vacío inicialmente
}
if (!isset($_SESSION['equipo2'])) {
    $_SESSION['equipo2'] = []; // Equipo 2 vacío inicialmente
}
if (!isset($_SESSION['log'])) {
    $_SESSION['log'] = []; // Inicializa el log de combate
}

// Manejo de Pokémon desde la ventana de inicio
if (isset($_GET['namePk'])) {
    $nombrePk1 = $_GET['namePk'];
    $infoPk1 = infoPokemon($nombrePk1); // Obtener información del Pokémon
    if ($infoPk1) {
        $_SESSION['equipo1'][] = [
            'nombre' => $infoPk1['name'],
            'vida' => $infoPk1['hp'],
            'img' => $infoPk1['img']
        ]; // Agregar Pokémon al equipo 1
    } else {
        logCombate("Pokémon '{$nombrePk1}' no encontrado.");
    }
}

if (isset($_GET['namePk2'])) {
    $nombrePk2 = $_GET['namePk2'];
    $infoPk2 = infoPokemon($nombrePk2); // Obtener información del Pokémon
    if ($infoPk2) {
        $_SESSION['equipo2'][] = [
            'nombre' => $infoPk2['name'],
            'vida' => $infoPk2['hp'],
            'img' => $infoPk2['img']
        ]; // Agregar Pokémon al equipo 2
    } else {
        logCombate("Pokémon '{$nombrePk2}' no encontrado.");
    }
}

// Recuperar estado del combate
$equipo1 = $_SESSION['equipo1'];
$equipo2 = $_SESSION['equipo2'];
$log = &$_SESSION['log']; // Referencia al registro

// Función para agregar un mensaje al log
function logCombate($message)
{
    global $log; // Usar la variable de sesión
    $log[] = $message; // Añadir el mensaje al log
}

// Función que maneja todo el combate
function realizarCombate(&$equipo1, &$equipo2)
{
    if (empty($equipo1) || empty($equipo2)) {
        return true; // No se puede combatir si alguno de los equipos está vacío
    }

    $atacante = $equipo1[0]; // Pokémon activo del equipo 1
    $defensor = $equipo2[0]; // Pokémon activo del equipo 2

    // Generar daño aleatorio entre 10 y 20 puntos por cada turno
    $damage = rand(10, 20);
    $defensor['vida'] -= $damage;

    logCombate("El Pokémon {$atacante['nombre']} ataca a {$defensor['nombre']} infligiendo $damage puntos de daño.");

    // Verificar si el Pokémon del equipo 2 ha sido derrotado
    if ($defensor['vida'] <= 0) {
        logCombate("¡{$defensor['nombre']} ha sido derrotado!");
        array_shift($equipo2); // Remover el Pokémon derrotado

        // Verificar si el equipo 2 ha perdido todos sus Pokémon
        if (empty($equipo2)) {
            logCombate("¡El equipo 1 ha ganado el combate!");
            return true; // Terminar el combate
        }
    }

    // Cambio de turno: el Pokémon del equipo 2 ataca al Pokémon activo del equipo 1 si queda
    if (!empty($equipo2)) {
        $atacante = $equipo2[0];
        $defensor = $equipo1[0];
        $damage = rand(10, 20);
        $defensor['vida'] -= $damage;

        logCombate("El Pokémon {$atacante['nombre']} ataca a {$defensor['nombre']} infligiendo $damage puntos de daño.");

        // Verificar si el Pokémon del equipo 1 ha sido derrotado
        if ($defensor['vida'] <= 0) {
            logCombate("¡{$defensor['nombre']} ha sido derrotado!");
            array_shift($equipo1); // Remover el Pokémon derrotado

            // Verificar si el equipo 1 ha perdido todos sus Pokémon
            if (empty($equipo1)) {
                logCombate("¡El equipo 2 ha ganado el combate!");
                return true; // Terminar el combate
            }
        }
    }

    // Actualizar variables de sesión
    $_SESSION['equipo1'] = $equipo1;
    $_SESSION['equipo2'] = $equipo2;
    return false; // Combatir sigue
}

// Verificar si se ha pulsado el botón para avanzar el turno
$combateTerminado = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['cerrar_sesion'])) {
    $combateTerminado = realizarCombate($equipo1, $equipo2);
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
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida']); ?>hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($equipo1)): ?>
                <div class="pkAct1">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($equipo1[0]['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($equipo1[0]['vida']); ?>hp</p>
                    <?php echo ($equipo1[0]['img']); ?>
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
                        <p><?php echo htmlspecialchars(ucfirst($pk['nombre'])); ?> <br> <?php echo htmlspecialchars($pk['vida']); ?>hp</p>
                        <div class="pokemon-image">
                            <?php echo ($pk['img']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($equipo2)): ?>
                <div class="pkAct2">
                    <h4>Pokémon Activo: <?php echo htmlspecialchars(ucfirst($equipo2[0]['nombre'])); ?></h4>
                    <p>HP: <?php echo htmlspecialchars($equipo2[0]['vida']); ?>hp</p>
                    <?php echo ($equipo2[0]['img']); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Registro de combate -->
    <aside>
        <h1>Registro del Combate</h1>
        <div class="log">
            <?php foreach ($log as $entry): ?>
                <p><?php echo htmlspecialchars($entry); ?></p>
            <?php endforeach; ?>
        </div>
    </aside>
</body>
</html>
