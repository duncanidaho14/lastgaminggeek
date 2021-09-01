<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Jeuxvideo;
use App\Entity\Comment;
use App\Entity\Categorie;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setPseudo('kirua')
                    ->setFirstName('elhadi')
                    ->setLastName('beddarem')
                    ->setEmail('elhadibeddarem@gmail.com')
                    ->setPassword($this->encoder->encodePassword($adminUser, 'password'))
                    ->setAgreeTerms(1)
                    ->setIsVerified(1)
                    ->addGrade($adminRole)
                    //->setFullName('elhadi-beddarem')
                    
        ;



        $manager->persist($adminUser);

        // les utilisateurs

        $users = [];
        $genres = ['male', 'female'];

        for ($i=0; $i < 40; $i++) { 
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99). '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/'). $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user->setPseudo($faker->name())
                ->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastname)
                ->setEmail($faker->email)
                ->setPassword($hash)
                ->setIsVerified(1)
                ->setAgreeTerms(1)
                //->setFullName($faker->name())
            ;

            $manager->persist($user);
            $users[] = $user;
        }   

        for ($jeu=0; $jeu < 100; $jeu++) { 
            $jeuxvideo = new Jeuxvideo();

            for ($cate=0; $cate < 7; $cate++) { 
                $categorie = new Categorie();

                $categorie->setName($faker->name())
                        ->setImage($faker->imageUrl())
                        ->addGame($jeuxvideo)
                ;

                $manager->persist($categorie);
            }

            if (mt_rand(1, 12)) {
                $comment = new Comment();

                $comment->setTitle($faker->company())
                        ->setComment($faker->text())
                        ->setGame($jeuxvideo)
                        ->setUser($user)
                ;
                $manager->persist($comment);
            }

            $jeuxvideo->setName($faker->name())
                        ->setCoverImage($faker->imageUrl())
                        ->setDescription($faker->text())
                        ->setPrice($faker->numberBetween(0, 125))
                        ->addCategory($categorie)
                        ->addComment($comment)
                        ->setUser($user)
            ;         

            $manager->persist($jeuxvideo);
        }  
        
        $manager->flush();
    }
}
