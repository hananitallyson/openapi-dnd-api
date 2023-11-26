<?php

require_once __DIR__ . "/../vendor/autoload.php";

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Controlador das requisições Guzzle
 */
class GuzzleController
{

    private GuzzleClient $guzzle;

    /**
     * @param string url_servico - URL da API.
     */
    public function __construct(private string $url_servico)
    {
        $this->guzzle = new GuzzleClient([
            'base_uri' => $this->url_servico,
            'http_errors' => false
        ]);
    }

    /**
     * Retorna a lista de todas as armas.
     */
    public function getArmas(): array
    {
        $resposta = $this->guzzle->request("GET", 'armas');
        $armas = json_decode($resposta->getBody());

        if ($resposta !== null) {
            return $armas->data;
        } else {
            return ["message" => "$armas->message - Código: $armas->status"];
        }
    }

    /**
     * Retorna uma arma específica.
     * @param string index Index(nome) da arma
     */
    public function getArma(string $index): array
    {
        $resposta = $this->guzzle->request("GET", "armas/$index");
        $arma = json_decode($resposta->getBody());

        if ($arma !== null && property_exists($arma, 'data')) {
            return get_object_vars($arma->data);
        } else {
            return ["message" => "$arma->message - Código: $arma->status"];
        }
    }

    /**
     * Deleta uma arma
     * @param string index Índice(nome) da arma
     */
    public function deleteArma(string $index): array
    {
        $resposta = $this->guzzle->request("DELETE", "armas/$index");
        $body = json_decode($resposta->getBody());
        return ["message" => "$body->message - Código: $body->status"];
    }

    /**
     * Cria uma nova arma
     * @param array array Array com os dados das armas
     */
    public function createArma(array $array): array
    {
        try {
            $resposta = $this->guzzle->request("POST", "armas", ["json" => $array]);
            $body = json_decode($resposta->getBody());
            if ($body !== null && is_object($body->data)) {
                return get_object_vars($body->data);
            } else {
                return $body;
            }
        } catch (\Throwable $th) {
            return ["message" => "O index já existe ou você esqueceu de passar alguma informação."];
        }
    }

    /**
     * Edita os dados da arma
     * @param array array Array com os dados das armas
     * @param string index Índice(nome) da arma
     */
    public function updateArma(array $array, string $index): array
    {

        $resposta = $this->guzzle->request("PUT", "armas/$index", ["json" => $array]);
        $body = json_decode($resposta->getBody());

        if (is_object($body)) {
            return get_object_vars($body->data);
        } else {
            return ["message" => "$body->message - Código: $body->status"];
        }
    }
}
