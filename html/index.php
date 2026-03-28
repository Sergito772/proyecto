<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" href="../css/estilos.css">
        <meta charset="UTF-8">
        <title>Listado</title>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    </head>
    <body>
        <header>
            <section class="navContent">
                <a href="./index.html" class="logoEnlace">
                    <img src="../img/GOENCICLOPEDIA.png" 
                        style="position: absolute; height: 100%; width: 100%; left: 0; bottom: 0;  object-fit: contain;">
                </a>
            </section>
        </header>
        <div class="contenedor" id="appLista">
            <aside class="filtros">
                <h3>Filtrar por:</h3>
                <form method="POST">
                    <button type="button" @click="acordeonTipos = !acordeonTipos" class="accordion" >Tipos</button>
                    <div class="dropdown-panel" v-show="acordeonTipos">
                        <label><input type="checkbox" value="Planta" v-model="tipos"> Planta</label>
                        <label><input type="checkbox" value="Fuego" v-model="tipos"> Fuego</label>
                        <label><input type="checkbox" value="Agua" v-model="tipos"> Agua</label>
                        <label><input type="checkbox" value="Lucha" v-model="tipos"> Lucha</label>
                        <label><input type="checkbox" value="Veneno" v-model="tipos"> Veneno</label>
                        <label><input type="checkbox" value="Tierra" v-model="tipos"> Tierra</label>
                        <label><input type="checkbox" value="Roca" v-model="tipos"> Roca</label>
                        <label><input type="checkbox" value="Normal" v-model="tipos"> Normal</label>
                        <label><input type="checkbox" value="Eléctrico" v-model="tipos"> Eléctrico</label>
                        <label><input type="checkbox" value="Hielo" v-model="tipos"> Hielo</label>
                        <label><input type="checkbox" value="Volador" v-model="tipos"> Volador</label>
                        <label><input type="checkbox" value="Psiquico" v-model="tipos"> Psíquico</label>
                        <label><input type="checkbox" value="Bicho" v-model="tipos"> Bicho</label>
                        <label><input type="checkbox" value="Fantasma" v-model="tipos"> Fantasma</label>
                        <label><input type="checkbox" value="Dragon" v-model="tipos"> Dragón</label>
                        <label><input type="checkbox" value="Siniestro" v-model="tipos"> Siniestro</label>
                        <label><input type="checkbox" value="Acero" v-model="tipos"> Ácero</label>
                        <label><input type="checkbox" value="Hada" v-model="tipos"> Hada</label>
                    </div>

                    <button type="button" @click="acordeonGeneracion = !acordeonGeneracion" class="accordion">Generación</button>
                    <div class="dropdown-panel" v-show="acordeonGeneracion">
                        <label><input type="radio" value="1" v-model="generacion"> Kanto</label>
                        <label><input type="radio" value="2" v-model="generacion"> Jotho</label>
                        <label><input type="radio" value="3" v-model="generacion"> Hoenn</label>
                        <label><input type="radio" value="4" v-model="generacion"> Sinoh</label>
                        <label><input type="radio" value="5" v-model="generacion"> Teselia</label>
                        <label><input type="radio" value="6" v-model="generacion"> Kalos</label>
                        <label><input type="radio" value="7" v-model="generacion"> Alola</label>
                        <label><input type="radio" value="8" v-model="generacion"> Galar</label>
                        <label><input type="radio" value="9" v-model="generacion"> Paldea</label>
                    </div>

                    <button type="button" @click='btnBuscar'>Buscar</button>
                </form>
            </aside>
            <div v-if="loading" class="loader-container">
                <div class="loader"></div>
                <p>Cargando Pokémon...</p>
            </div>
            <section v-else id="pokemonCards" class="cards">
                <a v-for="poke in pokemonCards" :key="poke.id" :href="'detallePokemon.php?numero_pokedex=' + poke.numero_pokedex" class="card-link">
                    <article class="card">
                        <img :src="poke.sprite" class="imgpokemon">

                        <div class="cardinfo">
                            <h3>{{ poke.nombre }}</h3>

                            <div class="cajaTipos">
                                <div class="cajaTipo"
                                :style="{ backgroundColor: typeColors[[poke.tipo1]] }">
                                    {{ poke.tipo1 }}
                                </div>
                                <div class="cajaTipo" 
                                v-if="poke.tipo2"
                                :style="{ backgroundColor: typeColors[[poke.tipo2]] }">
                                    {{ poke.tipo2 }}
                                </div>
                            </div>

                            <p>{{ poke.descripcion }}</p>
                        </div>
                    </article>
                </a>
            </section>
            <aside class="filtros">
                <h3>Noticias</h3>
            </aside>
        </div>
        <!--Jquery -->  
        <script src="../jquery/jquery-3.3.1.min.js"></script>
        
        <!--<script src="../js/listaPokemon.js"></script>-->
        <!--<script src="../js/filtro.js"></script>-->
        <!--Vue.JS -->    
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>              
        <!--Axios -->      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>

        <script src="../js/main.js"></script>
    </body>
</html>