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
        urlImagen: ""
    },
    methods: {
        detallePokemon:async function() {
            const response = await axios.post('../php/crud.php?numero_pokedex=' +id, {opcion: 4})

            this.poke = response.data
            console.log(this.poke)
            this.tipoTitulo = this.poke[0].tipos.split(",")[0]

            this.varianteSeleccionada = this.poke[0]

            const responseAnterior = await axios.post('../php/crud.php', {opcion: 6, numero_pokedex: id - 1})
            const responseSiguiente = await axios.post('../php/crud.php', {opcion: 6, numero_pokedex: id + 1})

            this.enlaces = [
                ...responseAnterior.data,
                ...responseSiguiente.data
            ]

            console.log(this.enlaces)
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
                }
            }

            // 2. Gigamax
            if (name.includes("Gigamax") || name.includes("Gmax")) {
                return `${num}-Gmax.png`;
            }

            // 3. Alola
            if (name.includes("Alola")) {
                return `${num}-Alola.png`;
            }

            // 4. Hisui
            if (name.includes("Hisui")) {
                return `${num}-Hisui.png`;
            }

            if (name.includes("Paldea")) {
                return `${num}-Paldea.png`;
            }

            // 5. Otras formas (Sunny, Rainy, Frost, etc.)
            const formKeywords = ["Sunny", "Rainy", "Snowy", "Frost", "Attack", "Defense", "Speed"];
            for (const form of formKeywords) {
                if (name.includes(form)) {
                    return `${num}-${form}.png`;
                }
            }

            return `${num}.png`;
        }
        
    },
    mounted() {
        console.log("Vue cargado correctamente")
    },
    created: function(){
        this.detallePokemon()
    },
})