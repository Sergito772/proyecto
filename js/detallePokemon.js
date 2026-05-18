var url = '../php/crud.php';

const queryString = window.location.search;

const urlParams = new URLSearchParams(queryString)
const id = Number(urlParams.get('numero_pokedex'))

var appDetalle = new Vue({
    el: "#appDetalle",
    data: {
        poke: [],
        enlaces: [],
        typeColors: {
            Normal: "#A8A77A",
            Fuego: "#EE8130",
            Agua: "#6390F0",
            Eléctrico: "#F7D02C",
            Planta: "#7AC74C",
            Hielo: "#96D9D6", 
            Lucha: "#C22E28",
            Veneno: "#A33EA1",
            Tierra: "#E2BF65",
            Volador: "#A98FF3",
            Psíquico: "#F95587",
            Bicho: "#A6B91A",
            Roca: "#B6A136",
            Fantasma: "#735797", 
            Dragón: "#6F35FC",
            Siniestro: "#705746",
            Acero: "#B7B7CE",
            Hada: "#D685AD"
        },
        tipoTitulo: "",
        i: 0,
        mostrarVariantes: false,
        varianteSeleccionada: null,
        urlImagen: "",
        niveles: [],
        resistencias: [],
        debilidades: [],
        tiposPoke: [],
        tipos: [],
        movs: [],
        tablaMovs: [],
        fast: [],
        charged: [],
        cadena: [],
        entradas: []
    },
    methods: {
        detallePokemon:async function() {
            const response = await axios.post('../php/crud.php?numero_pokedex=' +id, {opcion: 4})

            this.poke = response.data
            console.log(this.poke)
            this.tipoTitulo = this.poke[0].tipos.split(",")[0]

            this.varianteSeleccionada = this.poke[0]

            const [prev, next, niveles, tipos, tiposPoke, movs, cadena, entradas] = await Promise.all([
                axios.post('../php/crud.php', { opcion: 6, numero_pokedex: id - 1 }),
                axios.post('../php/crud.php', { opcion: 6, numero_pokedex: id + 1 }),
                this.api(8, this.varianteSeleccionada.id ),
                this.api(7),
                this.api(9, this.varianteSeleccionada.id ),
                this.api(10, this.varianteSeleccionada.id),
                this.api(11, this.varianteSeleccionada.id ),
                this.getEntradasPokedex()
            ]);

            this.enlaces = [
                ...prev.data,
                ...next.data
            ]
            this.niveles = niveles;
            this.tipos = tipos;
            this.tiposPoke = tiposPoke;
            this.movs = movs;
            this.cadena = cadena;

            console.log(this.movs)

            this.combinarTipos();
            this.generarTablaMovimientos();

            console.log(this.enlaces)
        },

        /*getCpm: async function(){
            this.niveles = await this.api(8, this.varianteSeleccionada.id);
            console.log(this.niveles)
        },

        getTipos: async function() {
            this.tipos = await this.api(7);
        },

        getTiposPoke: async function() {
            this.tiposPoke = await this.api(9, this.varianteSeleccionada.id);
            console.log(this.tiposPoke)
            this.combinarTipos()
        },

        getMovimientos: async function () {
            this.movs = await this.api(10, this.varianteSeleccionada.id);
            this.generarTablaMovimientos()
        },

        getEvos: async function () {
            this.cadena = await this.api(11, this.varianteSeleccionada.id);
        },*/

        getEntradasPokedex: async function () {
            const response = await axios.get(`https://pokeapi.co/api/v2/pokemon-species/${this.varianteSeleccionada.numero_pokedex}/`)

            this.entradas = response.data.flavor_text_entries
                .filter(e => e.language.name === "es")
                .map(e => ({
                    texto: e.flavor_text.replace(/\n|\f/g, " "),
                    version: e.version.name
                }));
        },

        async api(opcion, id = null) {
            const url = id 
                ? `../php/crud.php?id=${id}` 
                : `../php/crud.php`;

            const response = await axios.post(url, { opcion });
            return response.data;
        },

        getTipoImageByIndex: function(pokemon, index){
            if (!pokemon || !pokemon.tipos) return "";
            const tipo = pokemon.tipos.split(",")[index]
            return `${this.normalizarTipo(tipo)}.webp`
        },

        getTipoSecundarioImage: function(pokemon){
            if (!pokemon || !pokemon.tipos) return "";
            const tipos = pokemon.tipos.split(",")
            return `${this.normalizarTipo(tipos[1])}.webp`
        },

        seleccionarVariante(pokemon) {
            this.varianteSeleccionada = pokemon
            this.mostrarVariantes = false
            this.getCpm()
        },

        normalizarTipo(nombre) {
        return nombre
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/\s+/g, "");
        },

        getImageName: function(pokemon){
            const num = pokemon.numero_pokedex.toString().padStart(4, '0');
            const name = pokemon.nombre;

            // 1. Mega evoluciones
            if (name.includes("Mega")) {
                // Mega Venusaur → 003-Mega
                // Mega Charizard X → 006-Mega-X
                const parts = name.split(" ");
                if (parts.length === 2) {
                    return `${num}-Mega.png`;
                } else if (parts.length === 3) {
                    return `${num}-Mega-${parts[2]}.png`; // X o Y
                } else if (parts.length === 4){
                    return `${num}-Mega-${parts[3]}.png`;
                }
            }

            if (name.includes("Primigenio")) {
                return `${num}-Primal.png`;
            }

            if (name.includes("Origen")) {
                return `${num}-Origin.png`;
            }

            // 2. Gigamax
            if (name.includes("Gigamax") || name.includes("Gmax")) {
                return `${num}-Gmax.png`;
            }

            // 3. Alola
            if (name.includes("Alola")) {
                return `${num}-Alola.png`;
            }

            if (name.includes("Galar(Normal)")) {
                return `${num}-Galar-Standard.png`;
            }

            if (name.includes("Galar(Daruma)")) {
                return `${num}-Galar-Zen.png`;
            }

            // 4. Galar
            if (name.includes("Galar")) {
                return `${num}-Galar.png`;
            }

            // 5. Hisui
            if (name.includes("Hisui")) {
                return `${num}-Hisui.png`;
            }

            if (name.includes("Paldea(fuego)")) {
                return `${num}-Paldea-Blaze-Breed.png`;
            }

            if (name.includes("Paldea(agua)")) {
                return `${num}-Paldea-Aqua-Breed.png`;
            }

            if (name.includes("Paldea(combate)")) {
                return `${num}-Paldea-Combat-Breed.png`;
            }

            // 6. Paldea
            if (name.includes("Paldea")) {
                return `${num}-Paldea.png`;
            }

            // 7. Otras formas (Sunny, Rainy, Frost, etc.)
            const formKeywords = ["Sunny", "Rainy", "Snowy", "Frost", "Attack", "Defense", "Speed", "Sandy", "Trash", "Sunshine", "Fan", "Heat", "Mow", "Wash", "Sky", "Zen", "Therian", "White", "Black", "Resolute", "Piroutte", "10", "50-Power-Construct", "Complete", "Unbound", "Pau", "Pom-Pom", "Sensu", "Dusk", "Midnight", "Dawn", "DuskS", "Ultra", "Noice", "CrownedC", "CrownedZ", "Hero", "Three-Segment", "Droopy", "Stretchy", "East", "West", "School"];
            const formasClave = ["Sol", "Lluvia", "Nieve", "Nevera", "Ataque", "Defensa", "Velocidad", "Arena", "Basura", "Soleado", "Ventilador", "Horno", "Cortacesped", "Lavadora", "Cielo", "Daruma", "Tótem", "Blanco", "Negro", "Brio", "Danza", "10%", "50%", "100%", "Desatado", "Plácido", "Animado", "Refinado", "crepuscular", "nocturna", "Alas de Alba", "Melena Crepuscular", "Ultra", "deshielo", "Espada Suprema", "Escudo Supremo", "Heroica", "Trinodular", "Lánguida", "Recta", "Este", "Oeste", "banco"]
            /*for (const form of formKeywords) {
                if (name.includes(form)) {
                    return `${num}-${form}.png`;
                }
            }*/


            for(let i = 0; i<formKeywords.length; i++){
                if(name.includes(formasClave[i])){
                    return `${num}-${formKeywords[i]}.png`
                }
            }

            return `${num}.png`;
        },

        obtenerCombinacion(atacante, defensorId){
            const parse = (str) => str ? str.split(",").map(Number) : []

            const debilidades = parse(atacante.debilidades)
            const resistencias = parse(atacante.resistencias)
            const inmune = parse(atacante.inmune_a)

            if (inmune.includes(defensorId)) return 0.39
            if (debilidades.includes(defensorId)) return 1.6
            if (resistencias.includes(defensorId)) return 0.63

            return 1
        },

        combinarTipos() {
            if (!this.tiposPoke) return null

            this.tipos.forEach(atacante => {
                const p1 = this.obtenerCombinacion(this.tiposPoke[0], atacante.id)
                const p2 = this.tiposPoke[1] ? this.obtenerCombinacion(this.tiposPoke[1], atacante.id) : 1

                const total = this.redondear(p1 * p2)

                const entry = { nombre: atacante.nombre, porcentaje: `${total * 100}%` };
                
                if (total < 1) this.resistencias.push(entry)
                else if (total > 1) this.debilidades.push(entry)
            });
        },

        redondear(valor) {
            return Math.floor(valor * 100) / 100
        },

        generarTablaMovimientos() {
            this.fast = this.movs.filter(m => m.cargado == 0);
            this.charged = this.movs.filter(m => m.cargado == 1);

            /*const resultados = [];

            this.fast.forEach(f => {
                this.charged.forEach(c => {
                    const { dps, tdo } = this.calcularCombinacion(f, c);

                    resultados.push({
                        rapido: f.nombre,
                        cargado: c.nombre,
                        dps: dps.toFixed(2),
                        tdo: tdo.toFixed(1),
                        score: (dps * 0.7 + tdo * 0.3).toFixed(2) // fórmula estándar
                    });
                });
            });

            this.tablaMovs = resultados.sort((a,b) => b.score - a.score)*/

            this.tablaMovs = this.fast.flatMap(f =>
            this.charged.map(c => {
                const { dps, tdo } = this.calcularCombinacion(f, c);
                return {
                    rapido: f.nombre,
                    cargado: c.nombre,
                    dps: dps.toFixed(2),
                    tdo: tdo.toFixed(1),
                    score: (dps * 0.7 + tdo * 0.3).toFixed(2)
                };
            })
        ).sort((a, b) => b.score - a.score);
        },

        calcularCombinacion(fast, charged) {
            const dpsFast = fast.potencia_incursion / fast.duracion
            const eps = fast.energia_incursion / fast.duracion
            const tpcf = charged.energia_incursion / eps
            const tpc = tpcf + charged.duracion
            const dpc = (dpsFast * tpcf) + charged.potencia_incursion
            const dpsCharged = charged.potencia_incursion / charged.duracion

            const dps = (dpsFast * tpcf + charged.potencia_incursion) / tpc;
            const tdo = dps + (this.varianteSeleccionada.PV + this.varianteSeleccionada.defensa /2);

            return { dps, tdo };
        }
        
    },
    computed: {
        tipoImagen(){
            return this.getTipoImageByIndex(this.varianteSeleccionada, 0);
        },
        tipoImagenSecundario(){
            return this.getTipoImageByIndex(this.varianteSeleccionada, 1);
        }
    },
    mounted() {
        console.log("Vue cargado correctamente")
    },
    created: function(){
        this.detallePokemon()
    },
})