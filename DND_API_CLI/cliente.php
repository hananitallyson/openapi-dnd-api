<?php

require_once 'config/suapConnection.php';

$conn = new suapConnection();

$dados = $conn->getDados();

echo "Usuário Logado
--------------
Token de acesso: {$dados["token"]}
Nome: {$dados['nome_usual']}
Matrícula: {$dados['matricula']}
Vínculo: {$dados['tipo_vinculo']}
";

