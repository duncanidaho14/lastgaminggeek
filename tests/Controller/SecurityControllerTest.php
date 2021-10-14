<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;
use App\Entity\Jeuxvideo;


class SecurityControllerTest extends WebTestCase
{
    private User $user;

    /** @test */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    /** @test */
    public function testGetEmail(): void
    {
        $value = "test@test.com";

        $response = $this->user->setEmail($value);
        

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $this->user->getEmail());
        self::assertEquals($value, $this->user->getUserIdentifier());
    }

    /** @test */
    public function testGetRoles(): void
    {
        $value = ["ROLE_ADMIN"];
        $response = $this->user->setRoles($value);

        self::assertInstanceOf(User::class, $response);
        self::assertContains("ROLE_ADMIN", $this->user->getRoles());
        self::assertContains("ROLE_USER", $this->user->getRoles());
    }

    /** @test */
    public function testGetPassword(): void
    {
        $value = "password";
        $response = $this->user->setPassword($value);

        self::assertInstanceOf(User::class, $response);
        self::assertContains($value, [$this->user->getPassword()]);
    }
    
    /** @test */
    public function testGetJeuxvideo()
    {
        $value = new Jeuxvideo();
        $response = $this->user->addGame($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(1, $this->user->getGame());
        self::assertTrue($this->user->getGame()->contains($value));

        $response = $this->user->removeGame($value);

        self::assertInstanceOf(User::class, $response);
        self::assertCount(0, $this->user->getGame());
        self::assertFalse($this->user->getGame()->contains($value));
    }

    // protected function tearDown()
    // {
    //     parent::tearDown();
    // }
}
