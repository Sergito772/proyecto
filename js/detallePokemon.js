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
        tipoTitulo: ""
    },
    methods: {
        detallePokemon:async function() {
            const response = await axios.post('../php/crud.php?numero_pokedex=' +id, {opcion: 4})

            this.poke = response.data
            console.log(this.poke)
            this.tipoTitulo = this.poke[0].tipos.split(",")[0]

            const responseAnterior = await axios.post('../php/crud.php', {opcion: 6, numero_pokedex: id - 1})
            const responseSiguiente = await axios.post('../php/crud.php', {opcion: 6, numero_pokedex: id + 1})

            this.enlaces = [
                ...responseAnterior.data,
                ...responseSiguiente.data
            ]
            console.log(this.enlaces)

        }
    },
    mounted() {
        console.log("Vue cargado correctamente")
    },
    created: function(){
        this.detallePokemon()
    },
})