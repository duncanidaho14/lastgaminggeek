<?php

namespace App\Tests\Func;

use App\Tests\Func\AbstractEndPoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JeuxvideoTest extends AbstractEndPoint
{
    public function testJeuxvideo(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/jeuxvideos');
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

        

        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);

    }
}