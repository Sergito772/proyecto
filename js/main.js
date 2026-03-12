var url = '../php/crud.php';

const formas = [
    "Hisui",
    "Alola",
    "Paldea",
    "Mega",
    "Galar",
    "Primigenio"
]

const formasEspeciales = {
    "tauros-paldea(fuego)": "tauros-paldea-blaze-breed",
    "tauros-paldea(agua)": "tauros-paldea-aqua-breed",
    "tauros-paldea(combate)": "tauros-paldea-combat-breed",
    "kyogre-primigenio": "kyogre-primal",
    "groudon-primigenio": "groudon-primal",
    "Deoxys (Normal)": "deoxys-normal",
    "Deoxys (Ataque)": "deoxys-attack",
    "Deoxys (Defensa)": "deoxys-defense",
    "Deoxys (Velocidad)": "deoxys-speed",
    "Castform": "castform",
    "Castform (lluvia)": "castform-rainy",
    "Castform (nieve)": "castform-snowy",
    "Castform (sol)": "castform-sunny",
    "Wormadam(Manto vegetal)": "wormadam-plant",
    "Wormadam(Manto arena)": "wormadam-sandy",
    "Wormadam(Manto basura)": "wormadam-trash",
    "Rotom Ventilador": "rotom-fan",
    "Rotom nevera": "rotom-frost",
    "Rotom Horno": "rotom-heat",
    "Rotom Lavador": "rotom-wash",
    "Dialga Origen": "dialga-origin",
    "Palkia Origen": "palkia-origin",
    "Giratina Modificado": "giratina-altered",
    "Giratina Origen": "giratina-origin",
    "Shaymin (Forma Tierra)": "shaymin-land",
    "Shaymin (Forma Cielo)": "shaymin-sky",
    "darmanitan-galar(normal)": "darmanitan-galar-standard",
    "darmanitan-galar(daruma)": "darmanitan-galar-zen",
    "Darmanitan (Daruma)": "darmanitan-zen",
    "Tornadus (Totem)": "tornadus-therian",
    "Thundurus (Totem)": "thundurus-therian",
    "Landorus (Totem)": "landorus-therian",
    "Kyurem Negro": "kyurem-black",
    "Kyurem Blanco": "kyurem-white",
    "Keldeo (Forma Brio)": "keldeo-resolute",
    "Meloetta (Forma Danza)": "meloetta-pirouette",
    "mega-floette-eterna": "Floette-Mega",
    "Oricorio (Estilo Plácido)": "oricorio-pom-pom",
    "Oricorio (Estilo Animado)": "oricorio-pau",
    "Oricorio (Estilo Refinado)": "oricorio-sensu",
    "Lycanroc (Forma nocturna)": "lycanroc-midnight",
    "Lycanroc (Forma crepuscular)": "lycanroc-dusk",
    "Wishiwashi (Forma banco)": "wishiwashi-school",
    "Minior (Núcleo expuesto)": "minior-red",
    "Necrozma Melena Crepuscular": "necrozma-dusk",
    "Necrozma Alas de Alba": "necrozma-dawn",
    "Ultra Necrozma": "necrozma-ultra",
    "Eiscue (Cara deshielo)": "eiscue-noice",
    "Indeedee (Macho)": "indeedee-male",
    "Indeedee (Hembra)": "indeedee-female",
    "Zamazenta Escudo Supremo": "zamazenta-crowned",
    "Zacian Espada Suprema": "zacian-crowned",
    "Urshifu Estilo Fluido": "urshifu-rapid-strike",
    "Urshifu Estilo Brusco": "urshifu-single-strike",
    "Enamorus (Forma Tótem)": "enamorus-therian",
    "Meowstic (Hembra)": "meowstic-female",
    "Aegislash Forma Filo": "aegislash-blade",
    "Zygarde forma 10%": "zygarde-10-power-construct",
    "Zygarde forma 100%": "zygarde-complete",
    "Hoopa Desatado": "hoopa-unbound",
    "mega-tatsugiri-(forma-curvada)": "tatsugiri-curly-mega",
    "mega-tatsugiri-(forma-languida)": "tatsugiri-droopy-mega",
    "mega-tatsugiri-(forma-recta)": "tatsugiri-stretchy-mega",
    "Tatsugiri (Forma Languida)": "tatsugiri-droopy",
    "Tatsugiri (Forma Recta)": "tatsugiri-stretchy",
    "Dudunsparce (Forma Trinodular)": "dudunsparce-three-segment",
    "Palafin (Forma Heroica)": "palafin-hero",
    "Squawkabilly (Plumaje azul)": "squawkabilly-blue-plumage",
    "Squawkabilly (Plumaje blanco)": "squawkabilly-white-plumage",
    "Squawkabilly (Plumaje amarillo)": "squawkabilly-yellow-plumage",
    "Oinkologne (Hembra)": "oinkologne-female"
};

var appLista = new Vue({
    el: "#appLista",
    data: {
        generacion: 1,
        tipos: [],
        acordeonTipos: false,
        acordeonGeneracion: false,
        pokemon: [],
        pokemonCards: [],
        loading: false,
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
        }
    },
    methods: {
        btnBuscar: async function() {
            console.log("Buscando...");
            if (this.generacion === 0) {
                alert("Selecciona una generación");
                return;
            }
            this.listarPokemon()
        },

        listarPokemon:async function(){
            const payload = {
                generacion: this.generacion
            };

            if (this.tipos.length > 0) {
                payload.tipos = this.tipos;
            }

            this.loading = true

            try{
                const response = await axios.post(url, {opcion:5, payload});
                
                this.pokemon = response.data
                console.log(this.pokemon);

                this.pokemonCards = []

                const promesas = this.pokemon.map(async (p)=> {
                    var species = ""
                    var info = ""
                    const tipos = p.tipos.split(",")

                    const esForma = formas.some(forma => p.nombre.toLowerCase().includes(forma.toLowerCase()))
                    if (esForma){
                        const forma = p.nombre.split(" ")
                        var esMega = forma[0].toLowerCase() === "mega"
                        if(p.nombre.includes("Floette") || p.nombre.includes("Tatsugiri"))
                            esMega = false
                        if(!esMega){
                            let slug = normalizarNombre(p.nombre)
                            if(formasEspeciales[slug])
                                slug = formasEspeciales[slug]
                            info = await fetch(`https://pokeapi.co/api/v2/pokemon/${slug}`).then(r => r.json());
                            species = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${p.numero_pokedex}`).then(r => r.json());
                        }else{
                            if(forma.length === 2){
                                info = await fetch(`https://pokeapi.co/api/v2/pokemon/${forma[1]}-${forma[0]}`).then(r => r.json());
                                species = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${forma[1]}`).then(r => r.json());
                            }else{
                                info = await fetch(`https://pokeapi.co/api/v2/pokemon/${forma[1]}-${forma[0]}-${forma[2]}`).then(r => r.json());
                                species = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${forma[1]}`).then(r => r.json());
                            }
                            
                        }
                    }else{
                        if(!formasEspeciales[p.nombre])
                            info = await fetch(`https://pokeapi.co/api/v2/pokemon/${p.numero_pokedex}`).then(r => r.json());
                        else
                            info = await fetch(`https://pokeapi.co/api/v2/pokemon/${formasEspeciales[p.nombre]}`).then(r => r.json());
                        
                        species = await fetch(`https://pokeapi.co/api/v2/pokemon-species/${p.numero_pokedex}`).then(r => r.json());
                    }

                    const descripcion = species.flavor_text_entries.find(e => e.language.name === "es")?.flavor_text || "";

                    return {
                        id: p.id,
                        nombre: p.nombre,
                        tipo1: tipos[0],
                        tipo2: tipos[1],
                        sprite: info.sprites.front_default,
                        descripcion: descripcion
                    };
                })

                this.pokemonCards = await Promise.all(promesas)

            }catch(error){
                console.error("Error al listar Pokémon:", error);
            }

            this.loading = false
        }
    },
    mounted() {
    console.log("Vue cargado correctamente");
    },
    created: function(){
        this.listarPokemon()
    },
    computed: {}
})


function normalizarNombre(nombre) {
    return nombre
        .toLowerCase()
        .normalize("NFD")                 // separa acentos
        .replace(/[\u0300-\u036f]/g, "")  // elimina acentos
        .replace(/['.]/g, "")             // elimina apóstrofes y puntos
        .replace(/[:]/g, "")              // elimina dos puntos (Type: Null)
        .replace(/\s+/g, "-");            // espacios → guiones
}