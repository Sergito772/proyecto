<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de tipos</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/tabla.css">
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
    <main id="appTabla">
        <div class="principal">
            <h1 class="tituloTabla">Tabla de Tipos de Pokémon Go</h1>
            <table id="tabla-tipos">
                <thead>
                    <tr>
                        <th></th>
                        <th><img src="../img/tipos/acero.webp" title="Acero" alt="Acero" width="36" height="36"></th>
                        <th><img src="../img/tipos/agua.webp" title="Agua" alt="Agua" width="36" height="36"></th>
                        <th><img src="../img/tipos/bicho.webp" title="Bicho" alt="Bicho" width="36" height="36"></th>
                        <th><img src="../img/tipos/dragon.webp" title="Dragon" alt="Dragon" width="36" height="36"></th>
                        <th><img src="../img/tipos/electrico.webp" title="Electrico" alt="Electrico" width="36" height="36"></th>
                        <th><img src="../img/tipos/fantasma.webp" title="Fantasma" alt="Fantasma" width="36" height="36"></th>
                        <th><img src="../img/tipos/fuego.webp" title="Fuego" alt="Fuego" width="36" height="36"></th>
                        <th><img src="../img/tipos/hada.webp" title="Hada" alt="Hada" width="36" height="36"></th>
                        <th><img src="../img/tipos/hielo.webp" title="Hielo" alt="Hielo" width="36" height="36"></th>
                        <th><img src="../img/tipos/lucha.webp" title="Lucha" alt="Lucha" width="36" height="36"></th>
                        <th><img src="../img/tipos/normal.webp" title="Normal" alt="Normal" width="36" height="36"></th>
                        <th><img src="../img/tipos/planta.webp" title="Planta" alt="Planta" width="36" height="36"></th>
                        <th><img src="../img/tipos/psiquico.webp" title="Psiquico" alt="Psiquico" width="36" height="36"></th>
                        <th><img src="../img/tipos/roca.webp" title="Roca" alt="Roca" width="36" height="36"></th>
                        <th><img src="../img/tipos/siniestro.webp" title="Siniestro" alt="Siniestro" width="36" height="36"></th>
                        <th><img src="../img/tipos/tierra.webp" title="Tierra" alt="Tierra" width="36" height="36"></th>
                        <th><img src="../img/tipos/veneno.webp" title="Veneno" alt="Veneno" width="36" height="36"></th>
                        <th><img src="../img/tipos/volador.webp" title="Volador" alt="Volador" width="36" height="36"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="atk in tipos">
                        <th><img :src="`../img/tipos/${normalizarTipo(atk.nombre)}.webp`" :title="atk.nombre" :alt="atk.nombre" width="36" height="36"></th>

                        <td v-for="def in tipos">
                            <div class="porcentaje" :style="{backgroundColor: colorPorMultiplicador(obtenerMultiplicador(atk, def.id))}">
                                <p>{{ obtenerMultiplicador(atk, def.id) }}</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div id="combinaciones">
                <h3 class="tituloCombinaciones">Combinaciones de Tipo</h3>
                <p class="explicacion">Selecciona dos tipos pokémon usando los deslizadores de abajo. Se mostraran las debilidades y resistencias de la combinación con sus porcentajes correspondientes</p>

                <label class="explicacion">Tipo 1:</label>
                <div class="dropdown" @click="abrir1 = !abrir1">
                    <div class="dropdown-selected">
                        <img v-if="tipo1" :src="`../img/tipos/${normalizarTipo(tipo1.nombre)}.webp`">
                        {{ tipo1 ? tipo1.nombre : "Selecciona un tipo" }}
                    </div>

                    <div v-if="abrir1" class="dropdown-menu">
                        <div class="dropdown-item"
                            v-for="t in tipos"
                            @click.stop="seleccionarTipo1(t)">
                            <img :src="`../img/tipos/${normalizarTipo(t.nombre)}.webp`">
                            {{ t.nombre }}
                        </div>
                    </div>
                </div>

                <label class="explicacion">Tipo 2:</label>
                <div class="dropdown" @click="abrir2 = !abrir2">
                    <div class="dropdown-selected">
                        <img v-if="tipo2" :src="`../img/tipos/${normalizarTipo(tipo2.nombre)}.webp`">
                        {{ tipo2 ? tipo2.nombre : "Selecciona un tipo" }}
                    </div>

                    <div v-if="abrir2" class="dropdown-menu">
                        <div class="dropdown-item"
                            v-for="t in tipos"
                            @click.stop="seleccionarTipo2(t)">
                            <img :src="`../img/tipos/${normalizarTipo(t.nombre)}.webp`">
                            {{ t.nombre }}
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

        <script src="../js/tablaTipos.js"></script> 
</body>
</html>