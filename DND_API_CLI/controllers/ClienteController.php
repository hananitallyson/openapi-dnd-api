<?php

require_once '../config/suapConnection.php';

$conn = new suapConnection();

var_dump($dados = $conn->getDados());
