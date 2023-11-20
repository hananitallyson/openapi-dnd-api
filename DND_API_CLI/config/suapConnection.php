<?php

require_once __DIR__ . '/../vendor/autoload.php';

use GuzzleHttp\Client;
use Dotenv\Dotenv;

class suapConnection
{
    private $httpClient;
    private $dotenv;
    private $token;
    private $dados;

    const URL_SUAP_API = 'https://suap.ifrn.edu.br/api/v2';

    public function __construct()
    {
        $this->httpClient = new Client(['cookies' => true]);
        $this->dotenv = Dotenv::createImmutable(__DIR__.'/../');
        $this->loadCredentials();
    }

    private function loadCredentials()
    {
        $this->dotenv->load();
        $this->token = $this->loginSUAP($_ENV["USUARIO"], $_ENV["SENHA"]);
        $this->dados = $this->acessarDados($this->token);
    }

    private function loginSUAP($usuario, $senha): string
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
            $this->errorConection($e->getMessage());
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

    public function errorConection($error){
        print("Ocorreu um erro ao conectar o usuário: \n".$error);
        exit(1);
    }

    public function getDados(){
        return $this->dados;
    }
}
