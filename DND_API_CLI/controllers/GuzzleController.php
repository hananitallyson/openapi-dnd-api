<?php

require_once __DIR__."/../vendor/autoload.php";

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
     * @param string index Index(nome) da arma
     */
    public function deleteArma(string $index): object
    {
        $resposta = $this->guzzle->request("DELETE", "armas/$index");
        $body = json_decode($resposta->getBody());
        return $body;
    }
}
