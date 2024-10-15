# PokemonDaw

Enunciado
Vamos a realizar una página web de combates Pokemon en el servidor. A continuación se
especifican los requisitos mínimos de la aplicación
• La página debe tener un título.
• Tendremos una página principal donde se elegirá el modo de combate (PVE o PVP). Si es
PVE jugaremos nosotros contra el ordenador, si es PVP habrá dos jugadores humanos.
• Los Pokemon almacenarán la siguiente información, utiliza una matriz para guardar todo:
    ◦ Nombre
    ◦ Puntos de vida
    ◦ Ataque
    ◦ Defensa
    ◦ Velocidad
    ◦ Imagen
    • Dependiendo del modo de juego, se generarán otros formularios para la elección de los
Pokemon a emplear (6 por usuario humano)
• Los datos de los Pokemon pueden estar en memoria (podemos crear a los pokemon de
antemano y simplemente utilizarlos en el programa)
• Una vez se han rellenado los Pokemon a emplear en el combate en orden, se envía el
formulario para entrar en combate.
• El cálculo del daño en combate es el siguiente:
◦ Por turno, el daño a cada Pokemon es igual al ataque del atacante – defensa del defensor
+ 2. Esto es para evitar que un Pokemon que tiene 10 de defensa no reciba nada de daño
de un Pokemon con 10 de ataque.
◦ En caso de que el resultado sea menor a 0, el daño mínimo será de 1 punto de vida.
◦ El primer atacante por ronda será el Pokemon con mayor puntuación de velocidad
• Se debe utilizar un bucle para iterar los turnos, permitiendo a los Pokemon atacar hasta que
uno de los dos tenga 0 o menos puntos de vida, en ese caso se inicia la siguiente ronda, con
el siguiente Pokemon del entrenador perdedor.
• Cuando un entrenador se queda sin Pokemon se dice que el otro ha sido el ganador. No
puede haber empate.
• Hay que mostrar por cada ronda qué dos Pokemon se enfrentan, y por cada turno el daño
que le inflige cada uno al otro.
• Hay que anunciar las derrotas de cada Pokemon con un “X se ha debilitado”
• Hay que mostrar el entrenador ganador del combate, y en ese momento, el enlace para
volver al inicio.
• Hay que esperar 0,1 segundos por cada turno. Mira la función sleep u otra similar.
(Opcional)
• Hay que tener estilo con CSS.
