<?php

namespace App\Command;

use App\Entity\Categorie;
use App\Entity\Jeuxvideo;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\Csv\Reader;

/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class ImportCsv extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:import:csv';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports the mock CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        
        $io = new SymfonyStyle($input, $output);
        $io->title('Attempting import of Feed...');
        
        $reader = Reader::createFromPath('%kernel.root_dir%/../public/uploads/csv/vgsales.csv');

        // https://github.com/thephpleague/csv/issues/208
        $results = $reader->fetchAssoc();

        $io->progressStart(iterator_count($results));
        
        foreach ($results as $row) {
            $user = $this->em->getRepository(User::class)->findAll();

            // create new athlete
            $jeux = (new Jeuxvideo())
                ->setName($row['Name'])
                ->setCoverImage($row['Images'])
                ->setDescription($row['Platform'])
                ->setPrice($row['Global_Sales'])
                ->setUser(...$user)
            ;
                
                
                // create new Competitor
            $categorie = (new Categorie())
                ->setName($row['Genre'])
                ->setImage($row['Images'])
                ->addGame($jeux)
            ;
            $jeux->addCategory($categorie);

            $this->em->persist($jeux);
                
            $this->em->persist($categorie);
                
            $io->progressAdvance();
        }

        $this->em->flush();
        $io->progressFinish();
        $io->success('Command exited cleanly!');
    }
}