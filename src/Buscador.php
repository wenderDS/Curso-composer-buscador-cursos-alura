<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ClientException;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    /**
     * @param ClientInterface $httpClient
     * @param Crawler         $crawler
     */
    public function __construct(private readonly ClientInterface $httpClient, private readonly Crawler $crawler)
    {
    }


    /**
     * @param string $url
     * @return array
     * @throws BadResponseException
     */
    public function search(string $url): array
    {
        try {
            $response = $this->httpClient->request(method: 'GET', uri: $url);
        } catch (ClientException $e) {
            throw new BadResponseException(
                message: $e->getMessage(),
                request: $e->getRequest(),
                response: $e->getResponse()
            );
        }

        $html = $response->getBody();

        $this->crawler->addHtmlContent(content: $html);

        $cursos = $this->crawler->filter(selector: 'span.card-curso__nome');

        $arrayCursos = [];
        foreach ($cursos as $curso) {
            $arrayCursos[] = $curso->textContent;
        }

        return $arrayCursos;
    }
}
