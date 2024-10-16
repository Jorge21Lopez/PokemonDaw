<?php
session_save_path("E:/JORGEE/2ºA DAW/Desarrollo Servidor/Practicas/sesiones");
session_start();

// Inicialización de las variables de sesión
if (!isset($_SESSION['equipo1'])) {
    $_SESSION['equipo1'] = [100, 100, 100, 100, 100, 100]; // Vida de cada Pokémon del Entrenador 1
    $_SESSION['equipo2'] = [100, 100, 100, 100, 100, 100]; // Vida de cada Pokémon del Entrenador 2
    $_SESSION['pk1'] = 0; // Índice del Pokémon activo del Entrenador 1
    $_SESSION['pk2'] = 0; // Índice del Pokémon activo del Entrenador 2
    $_SESSION['fin1'] = 0; // Pokémon derrotados del Entrenador 1
    $_SESSION['fin2'] = 0; // Pokémon derrotados del Entrenador 2
    $_SESSION['log'] = []; // Inicializa el log de combate
}

// Recuperar estado del combate
$equipo1 = $_SESSION['equipo1'];
$equipo2 = $_SESSION['equipo2'];
$pk1 = $_SESSION['pk1'];
$pk2 = $_SESSION['pk2'];
$fin1 = $_SESSION['fin1'];
$fin2 = $_SESSION['fin2'];
$log = &$_SESSION['log']; // Referencia al registro

// Función para agregar un mensaje al log
function logCombate($message)
{
    global $log; // Usar la variable de sesión
    $log[] = $message; // Añadir el mensaje al log
}

// Verificar si se ha pulsado el botón para avanzar el turno
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Generar daño aleatorio entre 10 y 20 puntos por cada turno
    $damage1 = rand(10, 20); // Daño del Entrenador 1
    $damage2 = rand(10, 20); // Daño del Entrenador 2

    // Entrenador 1 ataca primero
    $equipo2[$pk2] -= $damage1;
    logCombate("Entrenador 1 ataca al Pokémon $pk2 del Entrenador 2 infligiendo $damage1 puntos de daño.");

    // Verificar si el Pokémon del Entrenador 2 ha sido derrotado
    if ($equipo2[$pk2] <= 0) {
        logCombate("El Pokémon $pk2 del Entrenador 2 ha sido derrotado!");
        $fin2++;
        $pk2++;
        if ($pk2 >= 6) {
            logCombate("El Entrenador 1 ha ganado el combate!");
            session_destroy();
            exit;
        }
    } else {
        // Entrenador 2 ataca solo si su Pokémon no ha sido derrotado
        $equipo1[$pk1] -= $damage2;
        logCombate("Entrenador 2 ataca al Pokémon $pk1 del Entrenador 1 infligiendo $damage2 puntos de daño.");

        // Verificar si el Pokémon del Entrenador 1 ha sido derrotado
        if ($equipo1[$pk1] <= 0) {
            logCombate("El Pokémon $pk1 del Entrenador 1 ha sido derrotado!");
            $fin1++;
            $pk1++;
            if ($pk1 >= 6) {
                logCombate("El Entrenador 2 ha ganado el combate!");
                session_destroy();
                exit;
            }
        }
    }

    // Actualizar variables de sesión
    $_SESSION['equipo1'] = $equipo1;
    $_SESSION['equipo2'] = $equipo2;
    $_SESSION['pk1'] = $pk1;
    $_SESSION['pk2'] = $pk2;
    $_SESSION['fin1'] = $fin1;
    $_SESSION['fin2'] = $fin2;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combate</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <!-- Jugador 1 -->
        <div class="player1">
            <div class="equipo1">
                <h3>Equipo 1</h3>
                <!-- Imágenes del equipo del Jugador 1 -->
                <img alt="imagen1" src="https://shorturl.at/Ii1jk">
                <img alt="imagen2" src="https://shorturl.at/Ii1jk">
                <img alt="imagen3" src="https://shorturl.at/Ii1jk">
                <img alt="imagen4" src="https://shorturl.at/Ii1jk">
                <img alt="imagen5" src="https://shorturl.at/Ii1jk">
                <img alt="imagen6" src="https://shorturl.at/Ii1jk">
            </div>
            <div class="pkAct1">
                <p>Nombre_Pokemon_1</p>
                <p>Vida: <?php echo $equipo1[$pk1] > 0 ? $equipo1[$pk1] : "0"; ?></p>
                <img alt="imagenPk" src="https://shorturl.at/Ii1jk" id="pkCombat">      
                <form method="post">
                    <button type="submit">Atacar</button>
                </form>
            </div>
        </div>

        <!-- Jugador 2 -->
        <div class="player2">
            <div class="equipo2">
                <h3>Equipo 2</h3>
                <!-- Imágenes del equipo del Jugador 2 -->
                <img alt="imagen1" src="https://shorturl.at/Ii1jk">
                <img alt="imagen2" src="https://shorturl.at/Ii1jk">
                <img alt="imagen3" src="https://shorturl.at/Ii1jk">
                <img alt="imagen4" src="https://shorturl.at/Ii1jk">
                <img alt="imagen5" src="https://shorturl.at/Ii1jk">
                <img alt="imagen6" src="https://shorturl.at/Ii1jk">
            </div>
            <div class="pkAct2">
                <p>Nombre_Pokemon_2</p>
                <p>Vida: <?php echo $equipo2[$pk2] > 0 ? $equipo2[$pk2] : "0"; ?></p>
                <img alt="imagenPk" src="https://shorturl.at/Ii1jk" id="pkCombat">
            </div>
        </div>
    </div>

    <!-- Registro de combate -->
    <aside>
        <h1>Registro del Combate</h1>
        <?php if (!empty($log)): ?>
            <div class="log">
                <?php foreach ($log as $entry): ?>
                    <p class="log"><?php echo $entry; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </aside>
</body>
</html>
