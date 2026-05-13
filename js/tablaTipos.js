var appTabla = new Vue({
    el: "#appTabla",
    data: {
        tipos: [],
        tipo1: null,
        tipo2: null,
        abrir1: false,
        abrir2: false
    },
    methods:{
        cargarTipos() {
            axios.post("../php/crud.php", { opcion: 7 })
            .then(res => {
                this.tipos = res.data;
            });
        },

        obtenerMultiplicador(atacante, defensorId){
            const parse = (str) => str ? str.split(",").map(Number) : []

            const eficaz = parse(atacante.eficaz)
            const poco = parse(atacante.poco_eficaz)
            const inmune = parse(atacante.inmune_contra)

            if (inmune.includes(defensorId)) return "39%"
            if (eficaz.includes(defensorId)) return "160%"
            if (poco.includes(defensorId)) return "63%"

            return "100%"
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

        normalizarTipo(nombre) {
        return nombre
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/\s+/g, "");
        },

        colorPorMultiplicador(valor) {
            switch (valor) {
                case "160%":
                    return "#ff6b6b";
                case "100%":
                    return "#d9d9d9";
                case "63%":
                    return "#6bdd7a";
                case "39%":
                    return "#0ae356";
                default:
                    return "transparent";
            }
        },

        seleccionarTipo1(t) {
            this.tipo1 = t;
            this.abrir1 = false;
            this.combinarTipos()
        },
        seleccionarTipo2(t) {
            this.tipo2 = t;
            this.abrir2 = false;
            this.combinarTipos()
        },

        redondear(valor) {
            return Math.floor(valor * 100) / 100
        },

        combinarTipos() {
            if (!this.tipo1) return null

            let resistencias = []
            let debilidades = []
            let superDebilidades = []
            let = superResistencias = []

            this.tipos.forEach(atacante => {
                const p1 = this.obtenerCombinacion(this.tipo1, atacante.id)
                const p2 = this.tipo2 ? this.obtenerCombinacion(this.tipo2, atacante.id) : 1

                const total = this.redondear(p1 * p2)

                if (total <= 0.39) superResistencias.push(atacante.nombre)
                else if (total < 1) resistencias.push(atacante.nombre)
                else if (total >= 2.56) superDebilidades.push(atacante.nombre)
                else if (total > 1) debilidades.push(atacante.nombre)
            });

            return { resistencias, debilidades, superDebilidades, superResistencias }
        }
    },
    mounted() {
        console.log("Vue cargado correctamente")
    },
    created: function(){
        this.cargarTipos()
    },
    computed: {
        resultado() {
            return this.combinarTipos();
        }
    }
})