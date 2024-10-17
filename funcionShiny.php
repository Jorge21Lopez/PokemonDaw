function cambiarEnlaceAShiny($url) {
    if (strpos($url, 'normal') !== false) {
        $urlModificado = str_replace('normal', 'shiny', $url);
        return $urlModificado;
    } else {
        return $url;
    }
}
