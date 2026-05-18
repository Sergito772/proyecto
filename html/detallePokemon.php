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
                                @click="seleccionarVariante(p)"
                                class="variantePoke"
                            >{{ p.nombre }}
                            </button>
                        </div>
                        <div>
                            <img v-if="varianteSeleccionada" class="imagenDetalle" :src="`../img/images/${getImageName(varianteSeleccionada)}`">
                        </div>
                        <div>
                            <table style="margin-left: auto; margin-right: auto;">
                                <tr>
                                    <td><img v-if="tipoImagen" :src="`../img/tipos/${tipoImagen}`"></td>
                                    <td><img v-if="tipoImagenSecundario" :src="`../img/tipos/${tipoImagenSecundario}`"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="titulo-seccion">
                            <h2>Estadisticas y PC máximo de {{ varianteSeleccionada?.nombre }}</h2>
                        </div>
                        <div class="stats-flex">
                            <div class="stat-box atq">
                                <span>{{ varianteSeleccionada?.Ataque }}</span>
                                <p>ATQ</p>
                            </div>

                            <div class="stat-box def">
                                <span>{{ varianteSeleccionada?.defensa }}</span>
                                <p>DEF</p>
                            </div>

                            <div class="stat-box ps">
                                <span>{{ varianteSeleccionada?.PV }}</span>
                                <p>PS</p>
                            </div>
                        </div>

                        <div class="pc-max">
                            <table style="border: 1px solid white; width: 100%; border-radius: 6px;" v-if="niveles">
                                <tr style="border-bottom: 1px solid white;">
                                    <td style="text-align: start; color: white; padding: 6px;"><strong>Nivel 50</strong></td>
                                    <td style="text-align: end; color: greenyellow; padding: 6px;">{{niveles[49]?.pc_nivel}} PC</td>
                                </tr>
                                <tr>
                                    <td style="text-align: start; color: white; padding: 6px;"><strong>Nivel 40</strong></td>
                                    <td style="text-align: end; color: greenyellow; padding: 6px;">{{niveles[39]?.pc_nivel}} PC</td>
                                </tr>
                                <tr>
                                    <td style="text-align: start; color: white; padding: 6px;"><strong>Nivel 30</strong></td>
                                    <td style="text-align: end; color: greenyellow; padding: 6px;">{{niveles[29]?.pc_nivel}} PC</td>
                                </tr>
                                <tr>
                                    <td style="text-align: start; color: white; padding: 6px;"><strong>Nivel 20</strong></td>
                                    <td style="text-align: end; color: greenyellow; padding: 6px;">{{niveles[19]?.pc_nivel}} PC</td>
                                </tr>
                                <tr>
                                    <td style="text-align: start; color: white; padding: 6px;"><strong>Nivel 10</strong></td>
                                    <td style="text-align: end; color: greenyellow; padding: 6px;">{{niveles[9]?.pc_nivel}} PC</td>
                                </tr>
                            </table>
                        </div>

                        <div class="titulo-seccion">
                            <h2>Resistencias y debilidades de {{ varianteSeleccionada?.nombre }}</h2>
                        </div>
                        <div class="tablaTipos">
                            <div>
                                <h3>Débil contra</h3>
                                <div class="tipos" v-if="debilidades && debilidades.length">
                                    <div class="tipo" v-for="d in debilidades">
                                        <img :src="`../img/tipos/${normalizarTipo(d.nombre)}.webp`">
                                        
                                        <p>{{d.nombre}}  <span style="color: green;">{{d.porcentaje}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div style="margin-top: 20px;">
                                <h3>Resistente a</h3>
                                <div class="tipos" v-if="resistencias && resistencias.length">
                                    <div class="tipo" v-for="r in resistencias">
                                        <img :src="`../img/tipos/${normalizarTipo(r.nombre)}.webp`">
                                        
                                        <p>{{r.nombre}}  <span style="color: green;">{{r.porcentaje}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="card stats">
                        <h1 class="titulo-apartado"
                            :style="{ backgroundColor: typeColors[tipoTitulo] }"
                            v-if="varianteSeleccionada">
                            Tabla de PC de {{ varianteSeleccionada.nombre }}
                        </h1>
                        <p style="color: white; font-size: 20px;" v-if="niveles && niveles.length">El PC máximo de Venusaur es de {{ niveles[49].pc_nivel }}. En incursiones su rango de PC es de {{ niveles[19].pc_nivel_10 }} 
                            a {{ niveles[19].pc_nivel }} y si cuenta con bonus de clima el rango sube de {{ niveles[24].pc_nivel_10 }} 
                            a {{ niveles[24].pc_nivel }}. En investigación de campo, el rango va de {{ niveles[14].pc_nivel_10 }} 
                            a {{ niveles[14].pc_nivel }}.
                        </p>

                        <table v-if="niveles && niveles.length" class="tabla-pc">
                            <tbody>
                                <tr>
                                    <th rowspan="2">
                                        <div class="th-icon pcmax"></div>
                                        PC Máximo
                                    </th>
                                    <td>Nivel 50 (IVs 15/15/15)</td>
                                </tr>
                                <tr>
                                    <td>{{ niveles[49].pc_nivel }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="2">
                                        <div class="th-icon investigacion"></div>
                                        Investigación
                                    </th>
                                    <td>Nivel 15 (IVs minimos 10/10/10)</td>
                                </tr>
                                <tr>
                                    <td>{{ niveles[14].pc_nivel_10 }} - {{ niveles[14].pc_nivel }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="2">
                                        <div class="th-icon huevo"></div>
                                        Huevos
                                    </th>
                                    <td>Nivel 20 (IVs minimos 10/10/10)</td>
                                </tr>
                                <tr>
                                    <td>{{ niveles[19].pc_nivel_10 }} - {{ niveles[19].pc_nivel }}</td>
                                </tr>
                                <tr>
                                    <th rowspan="4">
                                        <div class="th-icon pcmax"></div>
                                        Incursiones
                                    </th>
                                    <td>Nivel 20 (IVs minimos 10/10/10)</td>
                                </tr>
                                <tr>
                                    <td>{{ niveles[19].pc_nivel_10 }} - {{ niveles[19].pc_nivel }}</td>
                                </tr>
                                <tr>
                                    <td>Con bonus climático Nivel 25 (IVs minimos 10/10/10)</td>
                                </tr>
                                <tr>
                                    <td>{{ niveles[24].pc_nivel_10 }} - {{ niveles[24].pc_nivel }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="titulo-seccion">
                            <h2>Tabla de PC máximo por nivel</h2>
                        </div>
                        <p style="color: white; font-size: 20px;" v-if="varianteSeleccionada">Aquí mostraremos ahora una tabla por nivel de {{varianteSeleccionada.nombre}} donde se veran los PC máximos 
                            que podra tener el pokémon por nivel.
                        </p>

                        <table v-if="niveles && niveles.length" class="tabla-niveles">
                            <tr>
                                <th>Nivel</th>
                                <th>PC Máximo</th>
                                <th>Nivel</th>
                                <th>PC Máximo</th>
                            </tr>
                            <tr v-for="i in Math.ceil(niveles.length / 2)" :key="i">
                                <td>{{ niveles[(i - 1) * 2].nivel }}</td>
                                <td>{{ niveles[(i - 1) * 2].pc_nivel }}</td>

                                <td v-if="niveles[(i - 1) * 2 + 1]">
                                    {{ niveles[(i - 1) * 2 + 1].nivel }}
                                </td>
                                <td v-if="niveles[(i - 1) * 2 + 1]">
                                    {{ niveles[(i - 1) * 2 + 1].pc_nivel }}
                                </td>

                                <!-- Si el último nivel es impar, deja las celdas vacías -->
                                <td v-else></td>
                                <td v-else></td>
                            </tr>
                        </table>
                    </div> 
                </div>
                <div class="right-panel"> 
                    <div class="card moves-section">
                        <h1 id="titulo-movimientos" 
                            :style="{ backgroundColor: typeColors[tipoTitulo] }">
                            Análisis de ataques
                        </h1>
                        <div v-if="varianteSeleccionada">
                            <h2 style="color: white;">Mejores combinaciones de movimientos</h2>
                            <table class="tabla-movimientos" v-if="tablaMovs && tablaMovs.length">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ataque Rápido</th>
                                        <th>Ataque Cargado</th>
                                        <th>DPS</th>
                                        <th>TDO</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(fila, index) in tablaMovs" :key="index">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ fila.rapido }}</td>
                                        <td>{{ fila.cargado }}</td>
                                        <td>{{ fila.dps }}</td>
                                        <td>{{ fila.tdo }}</td>
                                        <td>{{ fila.score }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="titulo-seccion">
                            <h2>Ataques Rápidos</h2>
                        </div>
                        <div class="lista-movs">
                            <div class="movimiento"
                                v-for="f in fast" 
                                v-if="fast && fast.length" 
                                :key="f.id"
                                :style="{ borderLeft: '6px solid ' + typeColors[f.tipo_nombre] }">

                                <div class="mov-info">
                                <p class="mov-nombre">
                                    {{ f.nombre }}
                                    <span v-if="f.legacy" class="legacy">*</span>
                                </p>
                                <p class="mov-datos">
                                    {{ f.potencia_incursion }} daño · 
                                    {{ f.energia_incursion }} energía · 
                                    {{ f.duracion }}s
                                </p>
                            </div>

                            <img class="mov-icono" 
                                :src="`../img/tipos/${normalizarTipo(f.tipo_nombre)}.webp`">
                            </div>
                        </div>
                        <div class="titulo-seccion">
                            <h2>Ataques Cargados</h2>
                        </div>
                        <div class="lista-movimientos">
                            <div class="movimiento" 
                                v-for="c in charged" 
                                :key="c.id"
                                :style="{ borderLeft: '6px solid ' + typeColors[c.tipo_nombre] }">

                                <div class="mov-info">
                                    <p class="mov-nombre">
                                        {{ c.nombre }}
                                        <span v-if="c.legacy" class="legacy">*</span>
                                    </p>

                                    <p class="mov-datos">
                                        {{ c.potencia_incursion }} daño · 
                                        {{ c.energia_incursion }} energía · 
                                        {{ c.duracion }}s
                                    </p>
                                </div>

                                <img class="mov-icono" 
                                    :src="`../img/tipos/${normalizarTipo(c.tipo_nombre)}.webp`">
                            </div>
                        </div>
                    </div>
                    <div class="card info-pokedex">
                        <h1 class="titulo-apartado"
                            :style="{ backgroundColor: typeColors[tipoTitulo] }">
                            Información de la Pokédex
                        </h1>

                        <div class="titulo-seccion">
                            <h2>Cadena evolutiva</h2>
                        </div>

                        <div v-for="p in cadena" :key="p.id" class="evo-row" v-if="p.id_destino">
                            <div class="poke">
                                <img :src="`../img/images/${String(p.numero_pokedex).padStart(4,'0')}.png`">
                                <p style="color: white;">{{ p.nombre }}</p>
                            </div>

                            <div class="requisitos" v-if="p.caramelos || p.objeto_evolucion || p.condicion_especial">
                                <p v-if="p.caramelos">{{ p.caramelos }} Caramelos</p>
                                <p v-if="p.objeto_evolucion">{{ p.objeto_evolucion }}</p>
                                <p v-if="p.condicion_especial">{{ p.condicion_especial }}</p>
                            </div>

                            <div class="poke" v-if="p.id_destino">
                                <img :src="`../img/images/${String(p.pokedex_destino).padStart(4,'0')}.png`">
                                <p style="color: white;">{{ p.nombre_destino }}</p>
                            </div>
                        </div>

                        <div class="pokedex-entries" v-if="entradas && entradas.length">
                            <div class="titulo-seccion">
                                <h2>Entradas de la Pokédex</h2>
                            </div>

                            <div class="entrada" v-for="e in entradas" :key="e.version">
                                <h4>{{ e.version.toUpperCase() }}</h4>
                                <p>{{ e.texto }}</p>
                            </div>
                        </div>
                    </div>
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