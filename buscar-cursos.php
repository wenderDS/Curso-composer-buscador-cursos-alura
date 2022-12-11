<?php

require_once 'vendor/autoload.php';

use Alura\BuscadorDeCursos\Buscador;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$client  = new Client(
    [
        'base_uri' => 'https://www.alura.com.br/',
        'verify'   => false,
    ]
);
$crawler = new Crawler();

$search = new Buscador(httpClient: $client, crawler: $crawler);

$cursos = $search->search(url: 'cursos-online-programacao/php');

foreach ($cursos as $curso) {
    echo $curso . PHP_EOL;
}
