<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Jeuxvideo;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JeuxvideoTest extends WebTestCase
{
    private Jeuxvideo $jeuxvideo;
    private const VALID_NAME_VALUE = "hunter";
    private const VALID_NAME_MESSAGE = "Le nom du jeux video est obligatoire";
    private const VALID_DESCRIPTION_VALUE = "Une belle description";
    private const VALID_DESCRIPTION_MESSAGE = "La description du jeux video est obligatoire";
    private const VALID_PRICE_VALUE = 12;
    private const VALID_PRICE_MESSAGE = "Le prix du jeux video est obligatoire";
    private const VALID_USER_VALUE = "kirua";
    private const VALID_USER_MESSAGE = "L'utilisateur du jeux video est obligatoire";
    private ValidatorInterface $validator;
    
    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get('validator');
    }

    public function testJeuxvideoEntityIsValid(): void
    {
        $jeuxvideo = new Jeuxvideo();

        $jeuxvideo->setName(self::VALID_NAME_VALUE)
                ->setDescription(self::VALID_DESCRIPTION_VALUE)
                ->setPrice(self::VALID_PRICE_VALUE)
        ;

        $this->getValidationErrors($jeuxvideo, 1);
    }

    private function getValidationErrors(Jeuxvideo $jeuxvideo, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($jeuxvideo);
        $this->assertCount($numberOfExpectedErrors, $errors);
        return $errors;
    }
}