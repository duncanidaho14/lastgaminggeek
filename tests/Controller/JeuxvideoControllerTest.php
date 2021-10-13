<?php

namespace App\Tests\Controller;
use App\Entity\User;
use App\Entity\Jeuxvideo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JeuxvideoControllerTest extends WebTestCase
{
    private Jeuxvideo $jeuxvideo;

    /** @test */
    protected function setUp()
    {
        parent::setUp();

        $this->jeuxvideo = new Jeuxvideo();
    }

    /** @test */
    public function testGetName()
    {

    }

    /** @test */
    public function testGetContent()
    {

    }

    /** @test */
    public function testGetGamer()
    {
        $value = new User();
        
    }
}
