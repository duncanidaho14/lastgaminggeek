<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use Symfony\Component\Validator\ConstraintViolationList;

class UserTest extends KernelTestCase
{
    private const EMAIL_CONSTRAINT_MESSAGE = 'L\'adresse email doit être valide';
    private const NOT_BLANK_CONSTRAINT_MESSAGE = "L'adresse email est obligatoire";
    private const PASSWORD_REGEX_CONSTRAINT_MESSAGE = "Le mot de passe est obligatoire";
    private const INVALID_EMAIL_VALUE = "elhadibeddarem@gmail";
    private const VALID_EMAIL_VALUE = "elhadibeddarem@gmail.com";
    private const VALID_PASSWORD_VALUE = "password";
    private const VALID_PSEUDO_VALUE = "kirua";
    private const VALID_PSEUDO_MESSAGE = "Le pseudo est obligatoire";
    private const VALID_FIRSTNAME_VALUE = "elhadi";
    private const VALID_FIRSTNAME_MESSAGE = "Le prénom est obligatoire";
    private const VALID_LASTNAME_VALUE = "beddarem";
    private const VALID_LASTNAME_MESSAGE = "Le nom est obligatoire";
    private const VALID_AVATAR_VALUE = "elhadi.svg";
    private const VALID_AVATAR_MESSAGE = "Votre avatar est obligatoire";
    private const VALID_AGREETERMS_VALUE = false;
    private const VALID_AGREETERMS_MESSAGE = "Vous avez oublié de cocher cette case";

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
            ->setPseudo(self::VALID_PSEUDO_VALUE)
            ->setFirstName(self::VALID_FIRSTNAME_VALUE)
            ->setLastName(self::VALID_LASTNAME_VALUE)
            ->setAvatar(self::VALID_AVATAR_VALUE)
            ->setAgreeTerms(self::VALID_AGREETERMS_VALUE)
        ;
        $this->getValidationErrors($user, 0);
    }

    public function testUserEntityIsInvalidBecauseNoEmailEntered(): void
    {
        $user = new User();
        
        $user->setPassword(self::VALID_PASSWORD_VALUE)
            ->setFirstName(self::VALID_FIRSTNAME_VALUE)
            ->setLastName(self::VALID_LASTNAME_VALUE)
            ->setPseudo(self::VALID_PSEUDO_VALUE)
            ->setAvatar(self::VALID_AVATAR_VALUE)
            ->setAgreeTerms(self::VALID_AGREETERMS_VALUE)
        ;
        
        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::NOT_BLANK_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    public function testUserEntityIsInvalidBecauseNoPasswordEntered(): void
    {
        $user = new User();
        
        $user->setEmail(self::VALID_EMAIL_VALUE)
            ->setFirstName(self::VALID_FIRSTNAME_VALUE)
            ->setLastName(self::VALID_LASTNAME_VALUE)
            ->setPseudo(self::VALID_PSEUDO_VALUE)
            ->setAvatar(self::VALID_AVATAR_VALUE)
            ->setAgreeTerms(self::VALID_AGREETERMS_VALUE)
        ;
        
        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::PASSWORD_REGEX_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    public function testUserEntityIsInvalidBecauseAnInvalidEmailHasBeenEntered(): void
    {
        $user = new User();
        
        $user->setEmail(self::INVALID_EMAIL_VALUE)
            ->setPassword(self::VALID_PASSWORD_VALUE)
            ->setFirstName(self::VALID_FIRSTNAME_VALUE)
            ->setLastName(self::VALID_LASTNAME_VALUE)
            ->setPseudo(self::VALID_PSEUDO_VALUE)
            ->setAvatar(self::VALID_AVATAR_VALUE)
            ->setAgreeTerms(self::VALID_AGREETERMS_VALUE)
        ;
        
        $errors = $this->getValidationErrors($user, 1);

        $this->assertEquals(self::EMAIL_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    /**
     * @dataProvider provideInvalidPasswords
     *
     * @param string $invalidPassword
     * @return void
     */
    public function testUserEntityIsInvalidBecauseAnInvalidPasswordHasBeenEntered(string $invalidPassword): void
    {
        $user = new User();
        $user->setEmail(self::VALID_EMAIL_VALUE)
            ->setPassword($invalidPassword)
            ->setFirstName(self::VALID_FIRSTNAME_VALUE)
            ->setLastName(self::VALID_LASTNAME_VALUE)
            ->setPseudo(self::VALID_PSEUDO_VALUE)
            ->setAvatar(self::VALID_AVATAR_VALUE)
            ->setAgreeTerms(self::VALID_AGREETERMS_VALUE)
        ;

        $errors = $this->getValidationErrors($user, 0);
        $this->assertEquals(self::PASSWORD_REGEX_CONSTRAINT_MESSAGE, $errors[0]->getMessage());

    }

    public function provideInvalidPasswords(): array
    {
        return [
            ['pass'],
            ['p-a-s-s-w-o-r-d'],
            ['PASSWORD'],
            ['password-de-ouf'],
        ];
    }

    private function getValidationErrors(User $user, int $numberOfExpectedErrors): ConstraintViolationList
    {
        $errors = $this->validator->validate($user);
        $this->assertCount($numberOfExpectedErrors, $errors);
        return $errors;
    }

    
}
