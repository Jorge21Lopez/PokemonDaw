<?php

include("tabla_tipos.php");

$garchomp = [   
    "name"=>"garchomp",
    "hp"=>108,
    "ataque"=>130,
    "def"=>95,
    "spe"=>102,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/garchomp.gif' alt='Garchomp'></a>",
    "tipo1" => "dragón",
    "tipo2" => "tierra"
];

$charizard = [
    "name"=>"charizard",
    "hp"=>78,
    "ataque"=>84,
    "def"=>78,
    "spe"=>100,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/charizard.gif' alt='Charizard'></a>",
    "tipo1" => "fuego",
    "tipo2" => "volador"
];

$typhlosion = [
    "name"=>"typhlosion",
    "hp"=>78,
    "ataque"=>84,
    "def"=>78,
    "spe"=>100,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/typhlosion.gif' alt='Typhlosion'></a>",
    "tipo1" => "fuego",
    "tipo2" => ""
];

$umbreon = [
    "name"=>"umbreon",
    "hp"=>95,
    "ataque"=>65,
    "def"=>110,
    "spe"=>65,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/umbreon.gif' alt='Umbreon'></a>",
    "tipo1" => "siniestro",
    "tipo2" => ""
];

$vaporeon = [
    "name"=>"vaporeon",
    "hp"=>130,
    "ataque"=>65,
    "def"=>60,
    "spe"=>65,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/vaporeon.gif' alt='Vaporeon'></a>",
    "tipo1" => "agua",
    "tipo2" => ""
];

$gengar = [
    "name"=>"gengar",
    "hp"=>60,
    "ataque"=>130,
    "def"=>60,
    "spe"=>110,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/gengar.gif' alt='Gengar'></a>",
    "tipo1" => "fantasma",
    "tipo2" => "veneno"
];

$hydreigon = [
    "name"=>"hydreigon",
    "hp"=>92,
    "ataque"=>105,
    "def"=>90,
    "spe"=>98,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/hydreigon.gif' alt='Hydreigon'></a>",
    "tipo1" => "dragón",
    "tipo2" => "siniestro"
];

$crobat = [
    "name"=>"crobat",
    "hp"=>85,
    "ataque"=>90,
    "def"=>80,
    "spe"=>130,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/crobat.gif' alt='Crobat'></a>",
    "tipo1" => "veneno",
    "tipo2" => "volador"
];

$muk = [
    "name"=>"muk",
    "hp"=>105,
    "ataque"=>105,
    "def"=>75,
    "spe"=>50,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/muk.gif' alt='Muk'></a>",
    "tipo1" => "veneno",
    "tipo2" => ""
];

$gliscor = [
    "name"=>"gliscor",
    "hp"=>75,
    "ataque"=>95,
    "def"=>125,
    "spe"=>95,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/gliscor.gif' alt='Gliscor'></a>",
    "tipo1" => "tierra",
    "tipo2" => "volador"
];

$aggron = [
    "name"=>"aggron",
    "hp"=>70,
    "ataque"=>110,
    "def"=>180,
    "spe"=>50,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/aggron.gif' alt='Agron'></a>",
    "tipo1" => "acero",
    "tipo2" => "roca"
];

$haxorus = [
    "name"=>"haxorus",
    "hp"=>76,
    "ataque"=>147,
    "def"=>90,
    "spe"=>97,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/haxorus.gif' alt='haxorus'></a>",
    "tipo1" => "dragón",
    "tipo2" => ""
];

$electivire = [
    "name"=>"electivire",
    "hp"=>75,
    "ataque"=>123,
    "def"=>125,
    "spe"=>95,
    "img"=>"<img src='https://img.pokemondb.net/sprites/black-white/anim/normal/electivire.gif' alt='Electivire'></a>",
    "tipo1" => "eléctrico",
    "tipo2" => ""
]; 

$pokedex = [$garchomp,$charizard,$typhlosion,$umbreon,$vaporeon,$gengar,$hydreigon,$crobat,$muk,$gliscor,$aggron,$haxorus,$electivire];

/**
 * Proporciona el array de datos de un pokemon según su nombre, con probabilidad de que sea variocolor
 * @param mixed $nombrePk nombre del pokemon
 * @return mixed retorna el array con la información o null si no lo encuentra
 */
function infoPokemon($nombrePk) {
    global $pokedex;

    foreach ($pokedex as $pokemon) {    // recorre el archivo buscando el pokemon según el name
        if ($pokemon['name'] === strtolower($nombrePk)) {
            $pokemonCopia = $pokemon;
            $esShiny = rand(1, 100) <= 10; //calcula la probabilidad de shiny
            if ($esShiny) {
                $pokemonCopia['img'] = cambiarEnlaceAShiny($pokemonCopia['img']);
            }
            return $pokemonCopia;
        }
    }
    return null;
}

function cambiarEnlaceAShiny($url) {
    if (strpos($url, 'normal') !== false) {
        $urlModificado = str_replace('normal', 'shiny', $url);
        return $urlModificado;
    } else {
        return $url;
    }
}

function ataqueTipos($pk1, $pk2) {
    global $tabla_efectividad;

    $tipoAtacante1 = ucfirst(strtolower($pk1['tipo1']));

    $tipoDefensor1 = ucfirst(strtolower($pk2['tipo1']));
    $tipoDefensor2 = ucfirst(strtolower($pk2['tipo2']));

    $multiplicador = 1;

    if (isset($tabla_efectividad[$tipoAtacante1][$tipoDefensor1])) {
        $multiplicador *= $tabla_efectividad[$tipoAtacante1][$tipoDefensor1];
    }

    if (!empty($tipoDefensor2) && isset($tabla_efectividad[$tipoAtacante1][$tipoDefensor2])) {
        $multiplicador *= $tabla_efectividad[$tipoAtacante1][$tipoDefensor2];
    }

    return $multiplicador;
}

