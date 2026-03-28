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
        $sql = "SELECT p.* FROM pokemon p WHERE p.numero_pokedex = :numero_pokedex";

        $params ["numero_pokedex"] = $numero_pokedex;

        $resultado = $conexion->prepare($sql);
        $resultado->execute($params);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
}
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;