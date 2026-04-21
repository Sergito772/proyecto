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
            <h1>{{ varianteSeleccionada?.nombre }}</h1> 
            <p>Ataque: {{ varianteSeleccionada?.Ataque }}</p> 
            <p>Defensa: {{ varianteSeleccionada?.defensa }}</p> 
            <p>PV: {{ varianteSeleccionada?.PV }}</p> 
            <p>Generación: {{ varianteSeleccionada?.nombre_generacion }}</p>
            <p>Tipos: {{ varianteSeleccionada?.tipos }}</p>
            <p>Movimientos: {{ varianteSeleccionada?.movimientos }}</p>

            <div class="container"> 
                <div class="left-panel"> 
                    <div class="card pokemon-info">
                        <h1 id="tituloPokemon" 
                            :style="{ backgroundColor: typeColors[tipoTitulo] }">
                            {{ poke[0]?.nombre }}
                        </h1>
                        <div class="poke-select">
                            <a :class="{ disabled: poke[0]?.id <= 1 }" :href="'detallePokemon.php?numero_pokedex=' + (poke[0]?.numero_pokedex - 1) " class="card-prev-next">
                                <i class="fa-solid fa-angle-left"></i>
                                <div style="width: 100%;" class="anterior"> {{ enlaces[0]?.nombre }} </div>
                                <img class="imagenEnlace anterior" :src="'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/'+ (poke[0]?.numero_pokedex - 1) +'.png'">
                            </a>
                            <a :href="'detallePokemon.php?numero_pokedex=' + (poke[0]?.numero_pokedex + 1)" class="card-prev-next">
                                <img class="imagenEnlace siguiente" :src="'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/'+ (poke[0]?.numero_pokedex + 1) +'.png'">
                                <div style="width: 100%;" class="siguiente"> {{enlaces[1]?.nombre }} </div>
                                <i class="fa-solid fa-angle-right"></i>
                            </a>
                        </div>
                        <button @click="mostrarVariantes = !mostrarVariantes" class="variantePoke" v-show="poke.length > 1">
                            <h3 style="width: 100%; text-align: left;">{{ varianteSeleccionada?.nombre }}</h3>
                            <i class="fa-solid fa-angle-down"></i>
                        </button>
                        <div v-if="mostrarVariantes">
                            <button 
                                v-for="p in poke" 
                                :key="p.id"
                                @click="() => { varianteSeleccionada = p; mostrarVariantes = false }"
                            >{{ p.nombre }}
                            </button>
                        </div>
                        <div>
                            <img class="imagenDetalle" :src="`../img/images/${getImageName(varianteSeleccionada)}`">
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