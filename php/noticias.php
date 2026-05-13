<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

$apiKey = "cacf4076e1eaad0ac0468da5583dc639"; // ← pon tu API key aquí

$url = "https://gnews.io/api/v4/search?q=pokemon%20go&lang=es&max=5&token=$apiKey";

$response = file_get_contents($url);

if ($response === FALSE) {
    echo json_encode(["error" => "No se pudieron obtener noticias"]);
    exit;
}

$data = json_decode($response, true);

// Normalizamos solo lo que necesitamos
$noticias = [];

foreach ($data["articles"] as $art) {
    $noticias[] = [
        "titulo" => $art["title"],
        "descripcion" => $art["description"],
        "url" => $art["url"],
        "imagen" => $art["image"],
        "fecha" => $art["publishedAt"]
    ];
}

echo json_encode($noticias);
