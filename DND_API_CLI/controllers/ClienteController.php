<?php

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . '/../config/suapConnection.php';
require_once __DIR__ . '/GuzzleController.php';

use Seld\CliPrompt\CliPrompt;

class ClienteController
{
    private $serverColor = "\033[32m";
    private $inputColor = "\033[33m";
    private $resetColor = "\033[0m";
    private $data;
    private $response = "";

    public function login()
    {
        $this->cleanTerminal();
        $this->displayTitle(0);
        $this->startSystem("login no Suap\n");


        $matricula = $this->getUserInput("Digite sua matrícula do Suap");
        $senha = $this->getHiddenUserInput("Digite sua senha do Suap");

        $this->data = new suapConnection($matricula, $senha);

        $this->pause(3);

        $this->cleanTerminal();

        if (is_string($this->data)) {
            echo $this->data;
        } else {
            $this->data = $this->data->getDados();
            $this->displayMenu();
        }
    }

    private function displayMenu()
    {
        while (true) {
            $options = [
                1 => "Visualizar Todas as Armas",
                2 => "Cadastrar Arma",
                3 => "Visualizar Uma Arma",
                4 => "Atualizar Dados da Arma",
                5 => "Deletar Arma",
                0 => "Sair do Sistema"
            ];

            $this->displayTitle(1);

            foreach ($options as $key => $value) {
                echo "\n" . $this->serverColor . "[$key] - $value" . $this->resetColor;
            }

            $choice = $this->getUserInput("\nEscolha a operação desejada");

            $this->cleanTerminal();

            $this->switchRequest($choice);
        }
    }

    private function switchRequest(int $choice)
    {
        $guzzle = new GuzzleController("http://127.0.0.1:8000/api/");
        switch ($choice) {
            case 1:
                $this->startSystem("visualizar todas as armas");
                $this->pause(1);
                $this->format($guzzle->getArmas(), 'GET');
                break;
            case 2:
                $this->startSystem("cadastrar arma");
                $this->pause(1);
                break;
            case 3:
                break;
            case 4:
                break;
            case 5:
                break;
            case 0:
                break;
            default:
                break;
        }
    }



    private function displayTitle(int $choice)
    {
        if ($choice == 0) {
            echo "$this->serverColor
            \r---------------------------------------------------------------------
            \r                            D&D API
            \r---------------------------------------------------------------------
            $this->resetColor";
        } else {
            echo "$this->serverColor
            \r---------------------------------------------------------------------
            \r                            D&D API
            \r---------------------------------------------------------------------
            \r
            \rMATRICULA: {$this->data['matricula']}
            \rUSUÁRIO: {$this->data['nome_usual']}
            \rVÍNCULO: {$this->data['tipo_vinculo']}
            \r
            \r{$this->response}
            \r---------------------------------------------------------------------
            $this->resetColor";
        }
    }

    private function format(array $array, $method)
    {
        $this->clearResponse();
        if (!isset($array["message"]) && $method == "GET") {
            foreach ($array as $value) {
                $this->response .=
                    "\n
                $this->serverColor
                \r|Index: {$value->Index}
                $this->resetColor";
            }
        }
    }

    /**
     * Limpa a tela do terminal.
     */
    private function cleanTerminal()
    {
        echo "\033c";
    }

    private function startSystem(string $string)
    {
        echo "\n" . $this->serverColor . "INICIANDO O SISTEMA DE " . strtoupper($string) . $this->resetColor;
    }

    private function getUserInput(string $prompt): string
    {
        return readline($this->inputColor . "$prompt: " . $this->resetColor);
    }

    private function getHiddenUserInput(string $prompt): string
    {
        echo $this->inputColor . "$prompt: " . $this->resetColor;
        return CliPrompt::hiddenPrompt();
    }

    private function pause(int $time)
    {
        for ($i = 0; $i < $time; $i++) {
            echo "\n" . $this->serverColor . "." . $this->resetColor;
            sleep(1);
        }
    }

    private function clearResponse()
    {
        $this->response = "";
    }
}
