<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Symfony\Component\Validator\ConstraintViolationList;

class UserEntityTest extends KernelTestCase
{
    private const EMAIL_CONSTRAINT_MESSAGE = 'L\'email n\'est pas valide';
    private const NOT_BLANK_CONSTRAINT_MESSAGE = "Le mot de passe est obligatoire";
    private const INVALID_EMAIL_VALUE = "elhadibeddarem@gmail";
    private const VALID_EMAIL_VALUE = "elhadibeddarem@gmail.com";
    private const NO_EMAIL_MESSAGE = "L'adresse email est obligatoire";
    private const VALID_PASSWORD_VALUE = "password";
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get('validator');
        
    }

    public function testUserEntityIsValid(): void
    {
        $user = new User();
        $user->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE)
        ;
        $this->getValidationErrors($user, 4);
    }

    public function testUserEntityIsInvalidBecauseNoEmailEntered(): void
    {
        $user = new User();
        
        $user->setPassword(self::VALID_PASSWORD_VALUE);
        
        $errors = $this->getValidationErrors($user, 5);

        $this->assertEquals(self::NO_EMAIL_MESSAGE, $errors[0]->getMessage());

    }

    public function testUserEntityIsInvalidBecauseNoPasswordEntered(): void
    {
        $user = new User();
        
        $user->setEmail(self::VALID_EMAIL_VALUE);
        
        $errors = $this->getValidationErrors($user, 5);

        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    private function getValidationErrors(User $user, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);
        $this->assertCount($numberOfExpectedErrors, $errors);
        return $errors;
    }

    
}
