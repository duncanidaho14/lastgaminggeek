<?php

namespace App\Tests\Func;

use Faker\Factory;
use App\Tests\Func\AbstractEndPoint;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserTest extends AbstractEndPoint
{
    private string $userPayload = '{"email": "%s", "password": "password", "pseudo": "%s", "firstName": "%s", "lastName": "%s", "avatar": "%s"}';
    /** @test */
    public function testGetUsers(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_GET, '/api/utilisateurs');
        $responseContent = $response->getContent();
        $responseDecoded = \json_decode($responseContent);

        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
        
    }

    /** @test */
    public function testPostUser(): void
    {
        $response = $this->getResponseFromRequest(Request::METHOD_POST, '/api/utilisateur/1', $this->getPayload());
        $responseContent = $response->getContent();
        $responseDecoded = json_decode($responseContent);

                dd($responseDecoded);


        self::assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        self::assertJson($responseContent);
        self::assertNotEmpty($responseDecoded);
    }

    private function getPayload(): string
    {
        $faker = Factory::create();
        
        return \sprintf($this->userPayload, $faker->email(), $faker->name(), $faker->firstName(), $faker->lastName(), $faker->imageUrl());
    }
}
