<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;

class suapConnection
{
    private $httpClient;
    private $token;
    private $dados;
    private $matricula;
    private $senha;

    const URL_SUAP_API = 'https://suap.ifrn.edu.br/api/v2';

    public function __construct($matricula, $senha)
    {
        $this->httpClient = new Client(['cookies' => true]);
        $this->matricula = $matricula;
        $this->senha = $senha;
        $this->loadCredentials();
    }

    private function loadCredentials()
    {
        $this->token = $this->loginSUAP($this->matricula, $this->senha);
        $this->dados = $this->acessarDados($this->token);
    }

    private function loginSUAP($usuario, $senha)
    {
        try {
            $url = self::URL_SUAP_API . '/autenticacao/token/';

            $params = [
                'form_params' => [
                    'username' => $usuario,
                    'password' => $senha
                ]
            ];

            $response = $this->httpClient->post($url, $params);

            $responseData = json_decode($response->getBody());
            $token = $responseData->access;

            return $token;
        } catch (GuzzleHttp\Exception\ClientException $e) {
            // $this->errorConection($e->getMessage());
            print_r($e);
        }
    }

    private function acessarDados($token): array
    {
        $response = $this->httpClient->get(
            self::URL_SUAP_API . '/minhas-informacoes/meus-dados/',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]
        );

        $dados = json_decode($response->getBody(), associative: true);
        $dados["token"] = $token;

        return $dados;
    }

    public function errorConection($error)
    {
        return "Ocorreu um erro ao conectar o usuário: \n" . $error;
    }

    public function getDados()
    {
        return $this->dados;
    }
}
