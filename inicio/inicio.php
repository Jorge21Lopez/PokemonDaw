<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combates pokemon</title>
</head>

<body>
    <form action="inicio.php" method="post">
        <p>Elige el modo</p>
        <input type="submit" name="pve" value="pve">
        <input type="submit" name="pvp" value="pvp">
    </form>

    <?php

    function preaty_print($arr){
        echo "<pre>";
        print_r($arr);
        echo "</pre>";

    }

    include '../pokedex.php';
    $player1 = []; //jugaror 1
    $player2 = []; //jugador 2 o la IA
    $modo = "undefined";

    if (isset($_POST["pve"])) {
        $modo = "pve";
    } elseif (isset($_POST["pvp"])) {
        $modo = "pvp";
    } else {
        echo "ningun boton pulsado";
    }

    function equipo_random($pokedex){
        
        $equipo = [];
        for($i = 0; $i < 3 ; $i++){
            $random = rand(0,5);
            $repe = false;
            $poke_random = $pokedex[$random];
            foreach($equipo as $poke){
                if($poke_random["name"]==$poke["name"]){
                    $repe = true;
                }
            }
            if($repe){
                $i--;
            }
            if(!$repe){
                $equipo[] = $poke_random;
            }
            
        }
        return $equipo;

    }
    ?>






</body>

</html>