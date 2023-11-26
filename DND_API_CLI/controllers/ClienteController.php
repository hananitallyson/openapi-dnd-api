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

            $this->jumpLine(2);

            $choice = $this->getUserInput("Escolha a operação desejada");

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
                $this->format($guzzle->getArmas(), 'GET', 1);
                break;
            case 2:
                $this->startSystem("cadastrar arma");
                $this->pause(1);
                echo "\nPreencha os dados da arma\n";
                $data = [
                    'index' => $this->getUserInput("Index"),
                    'nome' => $this->getUserInput("Nome"),
                    'alcance' => $this->getUserInput("Alcance"),
                    'dano' => $this->getUserInput("Dano"),
                    'tipo_de_dano' => $this->getUserInput("Tipo de dano"),
                    'propriedade' => $this->getUserInput("Propriedade")
                ];
                $this->format($guzzle->createArma($data), 'POST', 2);
                break;
            case 3:
                $this->startSystem("visualizar uma arma");
                $this->pause(1);
                $this->jumpLine(1);
                $index = $this->getUserInput("Digite o index da arma");
                $this->cleanTerminal();
                $this->format($guzzle->getArma($index), 'GET', 3);
                break;
            case 4:
                $this->startSystem("atualizar dados da arma");
                $this->pause(1);
                echo "\nAtualize os dados da arma";
                $data = [
                    'index' => $this->getUserInput("Index"),
                    'nome' => $this->getUserInput("Nome"),
                    'alcance' => $this->getUserInput("Alcance"),
                    'dano' => $this->getUserInput("Dano"),
                    'tipo_de_dano' => $this->getUserInput("Tipo de dano"),
                    'propriedade' => $this->getUserInput("Propriedade")
                ];
                $this->format($guzzle->updateArma($data, $data['index']), 'PUT', 4);
                break;
            case 5:
                $this->startSystem("deletar arma");
                $this->pause(1);
                $this->jumpLine(1);
                $index = $this->getUserInput("Digite o index da arma a ser deletada");
                $this->format($guzzle->deleteArma($index), 'DELETE', 5);
                break;
            case 0:
                echo "\n" . $this->serverColor . "SAINDO DO D&D API!" . $this->resetColor;
                $this->pause(3);
                exit(0);
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

    private function format(array $array, $method, $case)
    {
        $this->clearResponse();
        if (!isset($array["message"]) && $method == "GET" && $case == 1) {
            foreach ($array as $value) {
                $this->response .= "$this->serverColor|Index: {$value->Index}\n";
            }
        }
        if ($case == 3 && !isset($array["message"])) {
            echo $this->serverColor;
            echo "\n|Index: " . $array['Index'];
            echo "\n|Nome: " . $array['Nome'];
            echo "\n|Alcance: " . $array['Alcance'];
            echo "\n|Dano: " . $array['Dano'];
            echo "\n|Tipo de dano: " . $array['Tipo de Dano'];
            echo "\n|Propriedade: " . $array['Propriedade'] . "\n";
            echo $this->resetColor;
        }

        if (isset($array["message"])) {
            echo "\n" . $array["message"] . "\n";
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

    private function jumpLine($amount)
    {
        for ($i = 0; $i < $amount; $i++) {
            echo "\n";
        }
    }
}
