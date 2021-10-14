<?php

namespace App\Tests\Func;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractEndPoint extends WebTestCase
{
    private array $serverInformation = ['ACCEPT'=>'application/ld+json', 'CONTENT_TYPE'=>'application/ld+json'];
    
    public function getResponseFromRequest(string $method, string $uri, string $payload = ''): Response
    {
        $client = self::createClient();

        $client->request($method, $uri, [], [], $this->serverInformation, $payload);
        
        //dd($client->getResponse());
        return $client->getResponse();
    }
}