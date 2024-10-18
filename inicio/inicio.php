<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combates pokemon</title>
    <link rel="stylesheet" href="inicio.css">
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
    $longitud_pokedex = count($pokedex)-1;

    if (isset($_POST["pve"])) {
        $modo = "pve";
        header("Location: ../pve/pve.php");
        exit;
        
    } elseif (isset($_POST["pvp"])) {
        $modo = "pvp";
        header("Location: ../pvp/pvp.php");
        exit;
    } else {
        echo "ningun boton pulsado";
    }


    if($modo == "pve"){
        ?>
        <form action="inicio.php" mehtod="post">
            <select id="equipo1_poke1" name="equipo1_poke1">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>
            <select id="equipo1_poke2" name="equipo1_poke2">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>
            <select id="equipo1_poke3" name="equipo1_poke3">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>
            <select id="equipo1_poke4" name="equipo1_poke4">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>
            <select id="equipo1_poke5" name="equipo1_poke5">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>
            <select id="equipo1_poke6 name="equipo1_poke6">
            <?php 
                for($i=0;$i<$longitud_pokedex; $i++){
                    $pokemon = $pokedex[$i];
                    echo "<option value='$pokedex[$i]'>".$pokemon['name']."</option>";
                }
            ?>
            </select>

            <input type="submit" value="equipo1">
        </form>

        <?php
        if(isset($_POST["equipo1_poke1"])&&isset($_POST["equipo1_poke2"])&&isset($_POST["equipo1_poke3"])&&isset($_POST["equipo1_poke4"])&&isset($_POST["equipo1_poke5"])&&isset($_POST["equipo1_poke6"])){
            for($i=1;$i<=6;$i++){
                $player1[]=$_POST["equipo_poke".$i];
            }

            preaty_print($player1);
        }

    }
    var_dump($_POST);

        
        

    


    //funcion para generar equipos aleatorios sin pokemons repetidos
    function equipo_random($pokedex){
        
        $equipo = [];
        $tamaño_pokedex = count($pokedex)-1;
        for($i = 0; $i < 3 ; $i++){
            $random = rand(0,$tamaño_pokedex);
            $repe = false;
            $poke_random = $pokedex[$random];
            foreach($equipo as $poke){
                if($poke_random["name"]==$poke["name"]){
                    $repe = true;
                    break;
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