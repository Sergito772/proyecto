<?php
include_once 'driver.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$_POST = json_decode(file_get_contents("php://input"), true);

$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';

$id = (isset($_POST['id'])) ? $_POST['id'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$ataque = (isset($_POST['ataque'])) ? $_POST['ataque'] : '';
$defensa = (isset($_POST['defensa'])) ? $_POST['defensa'] : '';
$cp_max = (isset($_POST['cp_max'])) ? $_POST['cp_max'] : '';
$generacion = (isset($_POST['payload']['generacion'])) ? $_POST['payload']['generacion'] : '';
$tipos = (isset($_POST['payload']['tipos'])) ? $_POST['payload']['tipos'] : '';
$numero_pokedex = (isset($_POST['numero_pokedex'])) ? $_POST['numero_pokedex'] : '';

//var_dump($_POST);

switch($opcion){
    case 1:
        $consulta = "INSERT INTO pokemon (nombre, ataque, defensa, cp_max, id_generacion, numero_pokedex) 
        VALUES('$nombre', $ataque, $defensa, $cp_max, $generacion, $numero_pokedex) ";	
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                
        break;

    case 2:
        $consulta = "UPDATE pokemon SET nombre='$nombre', ataque=$ataque, defensa=$defensa, cp_max=$cp_max, generacion=$generacion 
        WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                        
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;       

    case 3:
        $consulta = "DELETE FROM pokemon WHERE id='$id' ";		
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;         

    case 4:
        $idPokemon = $_GET['numero_pokedex'] ?? null; 
        $consulta = "
            SELECT 
                p.*,
                (SELECT GROUP_CONCAT(t.nombre)
                FROM pokemon_tipo pt
                JOIN tipo t ON pt.id_tipo = t.id
                WHERE pt.id_pokemon = p.id) AS tipos,

                (SELECT GROUP_CONCAT(m.nombre)
                FROM pokemon_movimiento pm
                JOIN movimientos m ON pm.id_movimiento = m.id
                WHERE pm.id_pokemon = p.id) AS movimientos,

                g.nombre AS nombre_generacion
            FROM 
                pokemon p 
            LEFT JOIN
                generacion g ON p.id_generacion = g.id
            where 
                p.numero_pokedex = $idPokemon";

        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 5: 
        $sql = "SELECT p.*, GROUP_CONCAT(t.nombre) AS tipos
                FROM pokemon p";

        $sql .= " INNER JOIN pokemon_tipo pt ON p.id = pt.id_pokemon
                      INNER JOIN tipo t ON t.id = pt.id_tipo";

                      
        $sql .= " WHERE p.id_generacion = :generacion";

        $params [":generacion"] = $generacion;

        // Si tipos no está vacío, agregamos filtro
        if (!empty($tipos)) {
        $placeholders = [];

            foreach ($tipos as $i => $tipo) {
                $ph = ":tipo$i";
                $placeholders[] = $ph;
                $params[$ph] = $tipo;
            }

            $sql .= " AND t.nombre IN (" . implode(",", $placeholders) . ")";
        }

        $sql .= " GROUP BY p.id";

        $resultado = $conexion->prepare($sql);

        $resultado->execute($params);
        //$resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 6:
        $sql = "SELECT p.* FROM pokemon p WHERE p.numero_pokedex = :numero_pokedex LIMIT 1";

        $params ["numero_pokedex"] = $numero_pokedex;

        $resultado = $conexion->prepare($sql);
        $resultado->execute($params);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 7:
        $sql = "SELECT * FROM tipo ORDER BY nombre ASC";
        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 8:
        $idPokemon = $_GET['id'] ?? null; 
        $sql = "SELECT 
                    p.nombre,
                    c.nivel, 
                    FLOOR(
                        ( (p.Ataque + 15) * SQRT(p.defensa + 15) * SQRT(p.PV + 15) * POW(c.cpm, 2) ) / 10
                    ) AS pc_nivel, 
                    FLOOR(
                        ( (p.Ataque + 10) * SQRT(p.defensa + 10) * SQRT(p.PV + 10) * POW(c.cpm, 2) ) / 10
                    ) AS pc_nivel_10 
                FROM pokemon p 
                JOIN cpm c 
                WHERE p.id = $idPokemon 
                ORDER BY c.nivel;";

        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $data = $resultado->fetchAll((PDO::FETCH_ASSOC));
        break;

    case 9:
        $idPokemon = $_GET['id'] ?? null;
        $sql = "SELECT t.*
                FROM pokemon_tipo pt
                JOIN tipo t ON pt.id_tipo = t.id
                WHERE pt.id_pokemon = $idPokemon;";

        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $data = $resultado->fetchAll((PDO::FETCH_ASSOC));
        break;

    case 10:
        $idPokemon = $_GET['id'] ?? null;
        $sql = "SELECT m.*, pm.legacy, t.nombre AS tipo_nombre 
                FROM pokemon_movimiento pm 
                JOIN movimientos m ON pm.id_movimiento = m.id 
                JOIN tipo t ON m.id_tipo = t.id 
                WHERE pm.id_pokemon = $idPokemon;";
        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $data = $resultado->fetchAll((PDO::FETCH_ASSOC));
        break;

    case 11:
        $idPokemon = $_GET['id'] ?? null;
        $sql = "SELECT 
                    p.id,
                    p.nombre,
                    p.numero_pokedex,
                    e.caramelos,
                    e.objeto_evolucion,
                    e.condicion_especial,
                    p2.id AS id_destino,
                    p2.nombre AS nombre_destino,
                    p2.numero_pokedex AS pokedex_destino
                FROM pokemon p
                LEFT JOIN evolucion e ON p.id = e.id_pokemon_origen
                LEFT JOIN pokemon p2 ON e.id_pokemon_destino = p2.id
                WHERE p.id_cadena_evo = (
                    SELECT id_cadena_evo 
                    FROM pokemon 
                    WHERE id = $idPokemon
                )
                ORDER BY p.numero_pokedex;";
        $resultado = $conexion->prepare($sql);
        $resultado->execute();
        $data = $resultado->fetchAll((PDO::FETCH_ASSOC));
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;