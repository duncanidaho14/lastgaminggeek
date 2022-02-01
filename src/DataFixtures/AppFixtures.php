<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Comment;
use App\Entity\Categorie;
use App\Entity\Jeuxvideo;
use App\Entity\OrderDetails;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
                    ->setAvatar('https://pbs.twimg.com/profile_images/1184794615951560704/MuK0y8MA.png')
                    //->setImageFile('8c9b82bc035d2ec941c0eb426c31f34f79931076.gif')
                    ->addGrade($adminRole)
                    ->setRoles(["ROLE_ADMIN"])
                    
                    
        ;

        $adminUserM = new User();
        $adminUserM->setPseudo('Silvermed')
                    ->setFirstName('Meddy')
                    ->setLastName('Seize')
                    ->setEmail('meddy.seize@gmail.com')
                    ->setPassword($this->encoder->encodePassword($adminUserM, 'password'))
                    ->setAgreeTerms(1)
                    ->setIsVerified(1)
                    ->setAvatar('https://cdn.shopify.com/s/files/1/0262/4516/9245/products/image_ca191039-f492-4d10-8bdb-3c15495586af_1024x1024.jpg?v=1565831183')
                    ->addGrade($adminRole)
                    ->setRoles(["ROLE_ADMIN"])
        ;


        $manager->persist($adminUser);
        $manager->persist($adminUserM);
        
        // les utilisateurs

        $users = [];
        $genres = ['male', 'female'];

        for ($i=0; $i < 20; $i++) { 
            $user = new User();
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99). '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/'). $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user->setPseudo($faker->name())
                ->setFirstName($faker->firstname($genre))
                ->setLastName($faker->lastname())
                ->setEmail($faker->email())
                ->setPassword($hash)
                ->setIsVerified(1)
                ->setAgreeTerms(1)
                ->setAvatar($picture)
                
            ;

            $manager->persist($user);
            $users[] = $user;
        }
        $addresses = [];
        for ($addr=0; $addr < 20; $addr++) { 
            $address = new Address();

            $address->setName($faker->name())
                    ->setFirstName($faker->firstName())
                    ->setLastName($faker->lastName())
                    ->setCompany($faker->company())
                    ->setAddress($faker->address())
                    ->setCity($faker->city())
                    ->setZip($faker->postcode())
                    ->setPhone($faker->phoneNumber())
                    ->setCountry($faker->country())
                    ->setUser($users[mt_rand(0, count($users) -1)])
            ;

            $manager->persist($address);
            $addresses[] = $address;
        }

        
        $jeuxvideos = [];
        for ($jeu=0; $jeu < 20; $jeu++) { 
                $jeuxvideo = new Jeuxvideo();
                $jeuxvideo->setName($faker->name()) 
                            ->setCoverImage($faker->imageUrl())
                            ->setDescription($faker->text())
                            ->setPrice($faker->numberBetween(0, 80))
                            ->setUser($users[mt_rand(0, count($users) -1)])
                ;

                for ($cat=0; $cat < 1; $cat++) { 
                    $categorie = new Categorie();

                    $categorie->setName($faker->name())
                                ->setImage($faker->imageUrl())
                                ->addGame($jeuxvideo)
                                
                    ;

                        $manager->persist($categorie);
                }

                $jeuxvideo->addCategory($categorie);

                if (mt_rand(1, 12)) {
                    $comment = new Comment();

                    $comment->setTitle($faker->company())
                            ->setComment($faker->text())
                            ->setGame($jeuxvideo)
                            ->setUser($users[mt_rand(0, count($users) -1)])
                    ;
                    $manager->persist($comment);
                }

                $jeuxvideo->addComment($comment)
                ;
            
            $manager->persist($jeuxvideo);
            $jeuxvideos[] = $jeuxvideo;
        } 

        $carriers = [];
        for ($carr=0; $carr < 5; $carr++) { 
            $carrier = new Carrier();
            $carrier->setName($faker->company())
                    ->setDescription($faker->text())
                    ->setPrice($faker->numberBetween(0, 80))
            ;

            $manager->persist($carrier);
            $carriers[] = $carrier;
        }

        $orderss = [];
        for ($orde=0; $orde < 15; $orde++) { 
            $orders = new Order();

            $orders->setCarrierName($carriers[\mt_rand(0, count($carriers) - 1)])
                    ->setDelivery($addresses[\mt_rand(0, count($addresses) - 1)])
                    ->setCarrierPrice($faker->numberBetween(0, 20))
                    ->setIsPaid(\mt_rand(0, 1))
                    ->setReference($faker->sentence())
                    ->setUser($users[mt_rand(0, count($users) -1)])
                    ->setCreatedAt($faker->dateTime())
            ;

            $manager->persist($orders);
            $orderss[] = $orders;

            $price = $faker->numberBetween(0, 80);
            $quantity = $faker->numberBetween(1, 10);

            for ($deta=0; $deta < count($orderss); $deta++) { 
                $details = new OrderDetails();

                $details->setMyOrder($orderss[mt_rand(0, count($orderss) -1)])
                        ->setPrice($price)
                        ->setProduct($jeuxvideos[mt_rand(0, count($jeuxvideos) -1)])
                        ->setQuantity($quantity)
                        ->setTotal($price + $quantity)
                ;

                $manager->persist($details);
            }
        }
        
        $manager->flush();
    }
}
