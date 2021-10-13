<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Jeuxvideo;


class JeuxvideoControllerTest extends WebTestCase
{
    private Jeuxvideo $jeuxvideo;

    /** @test */
    protected function setUp(): void
    {
        parent::setUp();

        $this->jeuxvideo = new Jeuxvideo();
    }

    /** @test */
    public function testGetName(): void
    {
        $value = "Nom du test";
        $response = $this->jeuxvideo->setName($value);

        self::assertInstanceOf(Jeuxvideo::class, $response);
        self::assertEquals($value, $this->jeuxvideo->getName());
    }

    /** @test */
    public function testGetContent(): void
    {
        $value = "Contenu du test";
        $response = $this->jeuxvideo->setDescription($value);

        self::assertInstanceOf(Jeuxvideo::class, $response);
        self::assertEquals($value, $this->jeuxvideo->getDescription());
    }

    /** @test */
    public function testGetGamer(): void
    {
        $value = new User();

        $response = $this->jeuxvideo->setUser($value);

        self::assertInstanceOf(Jeuxvideo::class, $response);
        self::assertInstanceOf(User::class, $this->jeuxvideo->getUser());
        
    }
}
