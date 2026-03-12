async function cargarPokemonParalelo() {
  const res = await fetch("https://pokeapi.co/api/v2/pokemon?limit=50");
  const data = await res.json();
  const divPokemon = document.getElementById("pokemonCards")

  const typeColors = {
    normal: ["#A8A77A", "Normal"],
    fire: ["#EE8130", "Fuego"],
    water: ["#6390F0", "Agua"],
    electric: ["#F7D02C", "Eléctrico"],
    grass: ["#7AC74C", "Planta"],
    ice: ["#96D9D6", "Hielo"],
    fighting: ["#C22E28", "Lucha"],
    poison: ["#A33EA1", "Veneno"],
    ground: ["#E2BF65", "Tierra"],
    flying: ["#A98FF3", "Volador"],
    psychic: ["#F95587", "Psíquico"],
    bug: ["#A6B91A", "Bicho"],
    rock: ["#B6A136", "Roca"],
    ghost: ["#735797", "Fantasma"],
    dragon: ["#6F35FC", "Dragón"],
    dark: ["#705746", "Siniestro"],
    steel: ["#B7B7CE", "Ácero"],
    fairy: ["#D685AD", "Hada"]
  };

  const promesas = data.results.map(p => fetch(p.url).then(r => r.json()));
  const detalles = await Promise.all(promesas);

  detalles.forEach(info => {
    const enlace = document.createElement("a")
    const article = document.createElement("article")
    const img = document.createElement("img")
    const nombre = document.createElement("h3")
    const divInfoPokemon = document.createElement("div")
    const divTipos = document.createElement("div")
    const tipos = []
    const descripcion = document.createElement("p")

    info.types.forEach(tipo =>{
      tipos.push(tipo.type.name)
    })

    enlace.href = `detallePokemon.php?id=${info.id}`
    enlace.className = "card-link"

    article.className = "card"
    divTipos.className = "cajaTipos"

    img.src = info.sprites.front_default
    img.className = "imgpokemon"
    
    nombre.textContent = capitalizar(info.name)

    divInfoPokemon.className = "cardinfo"

    for(var i = 0; i<tipos.length; i++){
      const divTipo = document.createElement("div")
      divTipo.className = "cajaTipo"
      divTipo.textContent = typeColors[tipos[i]][1]
      divTipo.style.backgroundColor = typeColors[tipos[i]][0] || "#777";
      divTipos.appendChild(divTipo)
    }

    fetch(`https://pokeapi.co/api/v2/pokemon-species/${info.id}`)
    .then(res => res.json())
    .then(data => {
      var des = data.flavor_text_entries.find(entry => entry.language.name === "es")
      descripcion.textContent = des.flavor_text
      descripcion.style.marginTop = "10px"
    });

    enlace.appendChild(article)
    article.appendChild(img)
    article.appendChild(divInfoPokemon)
    divInfoPokemon.appendChild(nombre)
    divInfoPokemon.appendChild(divTipos)
    divInfoPokemon.appendChild(descripcion)
    divPokemon.appendChild(enlace)
  });
}

function capitalizar(nombre) {
  return nombre.charAt(0).toUpperCase() + nombre.slice(1);
}

cargarPokemonParalelo()