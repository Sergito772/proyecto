const p = document.getElementById("idPokemon")
const parametros = new URLSearchParams(window.location.search)

const idPokemon = parametros.get("id")

p.textContent = "El id del pokemon es " +idPokemon