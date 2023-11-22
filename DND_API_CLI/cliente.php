<?php

require_once 'config/suapConnection.php';

require_once 'controllers/GuzzleController.php';

$client = new GuzzleController("http://127.0.0.1:8000/api/");

$array = [
    "index" => "adaga",
    "nome" => "adaga",
    "alcance" => 10,
    "dano" => "1d4",
    "tipo_de_dano" => "Perfudarante",
    "propriedade" => "Leve"

];

print_r($client->createArma($array)["Index"]);

// print_r($client->getArma("adaga"));

// print_r($client->deleteArma("adaga"));
