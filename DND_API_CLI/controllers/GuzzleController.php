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
        return $armas->data;
    }

    /**
     * Retorna uma arma específica.
     * @param string index Index(nome) da arma
     */
    public function getArma(string $index): object
    {
        $resposta = $this->guzzle->request("GET", "armas/$index");
        $arma = json_decode($resposta->getBody());
        return $arma->data;
    }

    /**
     * Deleta uma arma
     * @param string index Índice(nome) da arma
     */
    public function deleteArma(string $index): string
    {
        $resposta = $this->guzzle->request("DELETE", "armas/$index");
        $body = json_decode($resposta->getBody());
        return $body->message . " - Código: " . $body->status;
    }

    /**
     * Cria uma nova arma
     * @param array array Array com os dados das armas
     */
    public function createArma(array $array): object
    {
        $resposta = $this->guzzle->request("POST", "armas", ["json" => $array]);
        $body = json_decode($resposta->getBody());
        return $body->data;
    }

    /**
     * Edita os dados da arma
     * @param array array Array com os dados das armas
     * @param string index Índice(nome) da arma
     * @return object em caso de sucesso
     */
    public function updateArma(array $array, string $index): object
    {
        $resposta = $this->guzzle->request("PUT", "armas/$index", ["json" => $array]);
        $body = json_decode($resposta->getBody());

        if (is_object($body)) {
            return $body->data;
        }
    }

    /**
     * Transforma o array de erro em uma string
     * @param array array Array 
     */
    private function makeString($array): string
    {
        return $array->message . " - Código: " . $array->status;
    }
}
