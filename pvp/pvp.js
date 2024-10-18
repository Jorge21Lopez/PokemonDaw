/*
document.getElementById("btn_ocultar_jugador1").onclick = function() {
    document.getElementById("jugador1").style.display = "none";
    
};

document.getElementById("btn_ocultar_jugador2").onclick = function() {
    document.getElementById("jugador2").style.display = "none";
    
};
*/

function ocultarJugador1(){
    let div = document.getElementById("jugador1")
    if(div.style.display === "none"){
        div.style.display = "block"
    }else{
        div.style.display = "none";
    }
}

function ocultarJugador2(){
    let div = document.getElementById("jugador2")
    if(div.style.display === "none"){
        div.style.display = "block"
    }else{
        div.style.display = "none";
    }
}