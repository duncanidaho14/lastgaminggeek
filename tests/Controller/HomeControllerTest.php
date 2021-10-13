<?php

namespace App\Tests\Controller;
use PHPUnit\Framework\Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\Tools\SchemaTool;

class HomeControllerTest extends WebTestCase
{
    private $content;
    private $client;
    private $em;
    private $crawler;

    /** @test */
    protected function setUp(): void
    {
        parent::setUp();
                
        $this->client = static::createClient();

        $this->em = static::$container->get('doctrine')->getManager();

        // // transaction
        // $this->em->getConnection()->beginTransaction();
        // $this->em->getConnection()->setAutoCommit(false);

        static $metadata;

        if (! isset($metadata)) {
            # code...
            $metadata = $this->em->getMetadataFactory()->getAllMetadata();
        }

        // Supprimer la bdd
        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        
        if (! empty($metadata)) {
            // Recréer la bdd
            $schemaTool->createSchema($metadata);
        }
    }
    

    /** @test */
    public function homepage_should_display_all_game()
    {
        
        self::bootKernel();

        
        $this->crawler = $this->client->request('GET', '/');
        $this->content = $this->client->getResponse()->getContent();

        
        $this->assertResponseIsSuccessful();
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        
        
    }

    /**
     * Retourne les erreurs lorsque la méthode n'est pas appelé correctement
     *
     * @param \Throwable $t
     * @return void
     */
    protected function onNotSuccessfulTest(\Throwable $t): void
    {
        // Test si le crawler et le nombre d'erreur dans h1 exception message
        if($this->crawler && $this->crawler->filter('h1.exception-message')->count() > 0) {
            $exceptionClass = \get_class($t);
            throw new $exceptionClass($t->getMessage() . ' | ' . $this->crawler->filter('h1.exception-message')->eq(0)->text());
        }
        throw $t;
    }

    /** @test */
    protected function tearDown(): void 
    {
        parent::tearDown();

        // // Transaction La bdd est toujours vide sauf lorsque le test est execute
        // $this->em->getConnection()->rollback();
        // Afin d'éviter les fuites de mémoires
        $this->em->close();
        $this->em = null; 
    }
    
}