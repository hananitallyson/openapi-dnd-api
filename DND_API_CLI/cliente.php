<?php

require_once 'config/suapConnection.php';

require_once 'controllers/GuzzleController.php';

$client = new GuzzleController("http://127.0.0.1:8000/api/");

print_r($client->deleteArma("espada-longa"));
