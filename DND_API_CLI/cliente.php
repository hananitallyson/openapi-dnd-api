<?php

require_once 'config/suapConnection.php';

require_once 'controllers/GuzzleController.php';

$client = new GuzzleController("http://127.0.0.1:8000/api/");

$array = [
    "index" => "arc123123dadaado",
    "nome"=> "Arco Curto",
    "alcance"=> 22,
    "dano"=> "1D6",
    "tipo_de_dano"=> "Perfudarante",
    "propriedade"=> "Leve"

];
print_r($client->updateArma($array,"arco"));
