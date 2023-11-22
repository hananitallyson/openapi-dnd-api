<?php

require 'vendor/autoload.php';

use Seld\CliPrompt\CliPrompt;

echo "Digite sua senha: ";

// Use o método `hiddenPrompt` para ocultar a entrada do usuário
$senha = CliPrompt::hiddenPrompt();

echo "\nSenha digitada: $senha\n";