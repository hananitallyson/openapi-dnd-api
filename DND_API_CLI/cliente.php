<?php
require_once __DIR__.'/controllers/ClienteController.php';

$client = new ClienteController();

$client->login();
