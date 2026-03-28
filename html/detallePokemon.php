<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/estilos.css">
        <link rel="stylesheet" href="../css/detalle.css">
    </head>
    <body>
        <header>
            <section class="navContent">
                <a href="./index.php" class="logoEnlace">
                    <img src="../img/GOENCICLOPEDIA.png" 
                        style="position: absolute; height: 100%; width: 100%; left: 0; bottom: 0;  object-fit: contain;">
                </a>
            </section>
        </header>
        <main id="appDetalle">
            <h1>{{ poke[0]?.nombre }}</h1> 
            <p>Ataque: {{ poke[0]?.Ataque }}</p> 
            <p>Defensa: {{ poke[0]?.defensa }}</p> 
            <p>PV: {{ poke[0]?.PV }}</p> 
            <p>Generación: {{ poke[0]?.nombre_generacion }}</p>
            <p>Tipos: {{ poke[0]?.tipos }}</p>
            <p>Movimientos: {{ poke[0]?.movimientos }}</p>

            <div class="container"> 
                <div class="left-panel"> 
                    <div class="card pokemon-info">
                        <h1 id="tituloPokemon" 
                            :style="{ backgroundColor: typeColors[tipoTitulo] }">
                            {{ poke[0]?.nombre }}
                        </h1>
                        <div class="poke-select">
                            <a :class="{ disabled: poke[0]?.id <= 1 }" :href="'detallePokemon.php?numero_pokedex=' + (poke[0]?.numero_pokedex - 1) " class="card-prev-next">
                                <img class="imagenEnlace anterior" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/1.png">
                                <div style="width: 100%;" class="anterior"> {{ enlaces[0]?.nombre }} </div>
                            </a>
                            <a :href="'detallePokemon.php?numero_pokedex=' + (poke[0]?.numero_pokedex + 1)" class="card-prev-next">
                                <div style="width: 100%;" class="siguiente"> {{enlaces[1]?.nombre }} </div>
                            </a>
                        </div>
                    </div> 
                    <div class="card stats">...</div> 
                </div>
                <div class="right-panel"> 
                    <div class="card moves-section">...</div>
                </div> 
            </div>
        </main>

        <!--Vue.JS -->    
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script> 
        <!--Axios -->      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
        <script src="https://kit.fontawesome.com/7e88e242ba.js" crossorigin="anonymous"></script>

        <script src="../js/detallePokemon.js"></script>             
    </body>
</html>