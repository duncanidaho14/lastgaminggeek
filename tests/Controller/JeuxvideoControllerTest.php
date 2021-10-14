<?php

namespace App\Tests\Controller;
use App\Entity\User;
use App\Entity\Jeuxvideo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JeuxvideoControllerTest extends WebTestCase
{
    private Jeuxvideo $jeuxvideo;

    /** @test */
    public function setUp(): void
    {
        parent::setUp();

        $this->jeuxvideo = new Jeuxvideo();
    }

    /** @test */
    public function testGetName():void
    {

    }

    /** @test */
    public function testGetContent():void
    {

    }

    /** @test */
    public function testGetGamer():void
    {
        $value = new User();
        
    }
}
