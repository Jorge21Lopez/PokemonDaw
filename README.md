# PokemonDaw

## Enunciado
Vamos a realizar una página web de combates Pokemon en el servidor. A continuación se especifican los requisitos mínimos de la aplicación.

### Requisitos

1. **Título**:
   - La página debe tener un título.

2. **Página Principal**:
   - Tendremos una página principal donde se elegirá el modo de combate:
     - **PVE**: Jugaremos nosotros contra el ordenador.
     - **PVP**: Dos jugadores humanos competirán entre sí.

3. **Almacenamiento de Pokémon**:
   - Los Pokémon almacenarán la siguiente información utilizando una matriz:
     - **Nombre**.
     - **Puntos de vida (HP)**.
     - **Ataque**.
     - **Defensa**.
     - **Velocidad**.
     - **Imagen**.

4. **Selección de Pokémon**:
   - Dependiendo del modo de juego, se generarán formularios para la elección de los Pokémon a emplear (6 por usuario humano).
   - Los datos de los Pokémon pueden estar almacenados en memoria. Se pueden crear los Pokémon de antemano para ser utilizados en el programa.

5. **Inicio del Combate**:
   - Una vez se han seleccionado los Pokémon en orden, se envía el formulario para comenzar el combate.

6. **Cálculo del Daño en Combate**:
   - Por turno, el daño que recibe un Pokémon será igual a:
     ```
     Daño = Ataque del Atacante - Defensa del Defensor + 2
     ```
   - Si el resultado es menor a 0, el daño mínimo será **1** punto de vida.
   - El primer atacante por ronda será el Pokémon con mayor velocidad.

7. **Iteración de Turnos**:
   - Se utilizará un bucle para iterar por los turnos.
   - Los Pokémon atacarán hasta que uno de los dos tenga **0 o menos** puntos de vida.
   - En ese caso, se inicia la siguiente ronda con el siguiente Pokémon del entrenador perdedor.

8. **Victoria**:
   - Cuando un entrenador se queda sin Pokémon, se declarará ganador al otro entrenador.
   - No puede haber empate.

9. **Visualización del Combate**:
   - Se debe mostrar por cada ronda qué dos Pokémon se enfrentan.
   - Por cada turno, se debe mostrar el daño infligido por cada Pokémon.
   - Se anunciarán las derrotas de cada Pokémon con un mensaje tipo: `X se ha debilitado`.
   - Al final del combate, se mostrará el entrenador ganador y un enlace para volver al inicio.

10. **Tiempo entre Turnos**:
    - Se debe esperar **0,1 segundos** por cada turno. Usa la función `sleep` o similar.

11. La página debe tener **estilo con CSS** para mejorar la apariencia.

