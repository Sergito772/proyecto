<?php 
require_once "../php/conexion.php"; 

$id = $_GET['id'] ?? null; 
$tipos = array();

if ($id) { 
    $stmt = $pdo->prepare("
        SELECT 
            p.*,
            t.nombre AS tipo, 
            m.nombre AS movimiento,
            g.nombre AS nombre_generacion, 
            ce.id AS cadena_evo
        FROM 
            pokemon p
        LEFT JOIN 
            generacion g ON p.id_generacion = g.id
        LEFT JOIN 
            cadena_evolutiva ce ON p.id_cadena_evo = ce.id
        LEFT JOIN 
            pokemon_tipo pt ON p.id = pt.id_pokemon
        LEFT JOIN 
            tipo t ON pt.id_tipo = t.id
        LEFT JOIN 
            pokemon_movimiento pm ON p.id = pm.id_pokemon
        LEFT JOIN 
            movimientos m ON pm.id_movimiento = m.id
        WHERE p.id = ?;
    ");
    $stmt->execute([$id]);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    $pokemon = [ 
        "id" => $resultados[0]["id"], 
        "nombre" => $resultados[0]["nombre"], 
        "Ataque" => $resultados[0]["Ataque"], 
        "defensa" => $resultados[0]["defensa"], 
        "PV" => $resultados[0]["PV"], 
        "generacion" => $resultados[0]["nombre_generacion"],
        "cadena_evo" => $resultados[0]["cadena_evo"],
        "tipos" => [],
        "movimientos" => []
    ]; 
    
    foreach ($resultados as $fila) { 
        // Agregar tipos sin duplicar 
        if (!in_array($fila["tipo"], $pokemon["tipos"]) && $fila["tipo"] !== null) {
            $pokemon["tipos"][] = $fila["tipo"]; 
        } 

        // Agregar movimientos sin duplicar 
        if (!in_array($fila["movimiento"], $pokemon["movimientos"]) && $fila["movimiento"] !== null) {
            $pokemon["movimientos"][] = $fila["movimiento"]; 
        }
    }
}
?>
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
                <a href="./index.html" class="logoEnlace">
                    <img src="../img/GOENCICLOPEDIA.png" 
                        style="position: absolute; height: 100%; width: 100%; left: 0; bottom: 0;  object-fit: contain;">
                </a>
            </section>
        </header>
        <main>
            <h1><?= $pokemon['nombre'] ?></h1> 
            <p>Ataque: <?= $pokemon['Ataque'] ?></p> 
            <p>Defensa: <?= $pokemon['defensa'] ?></p> 
            <p>PV: <?= $pokemon['PV'] ?></p> 
            <p>Generación: <?= $pokemon['generacion'] ?></p>
            <p>Cadena evolutiva: <?= $pokemon['cadena_evo'] ?></p>
            <p>Tipos: <?= implode(", ", $pokemon['tipos']) ?></p>
            <p>Movimientos: <?= implode(", ", $pokemon['movimientos']) ?></p>

            <div class="container"> 
                <div class="left-panel"> 
                    <div class="card pokemon-info">...</div> 
                <div class="card stats">...</div> </div>
                <div class="right-panel"> 
                    <div class="card moves-section">...</div>
                </div> 
            </div>
        </main>

        <script src="../js/detallePokemon.js"></script>
        <!--Vue.JS -->    
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>              
        <!--Axios -->      
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>
    </body>
</html>