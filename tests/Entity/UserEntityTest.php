<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserEntityTest extends KernelTestCase
{
    private const EMAIL_CONSTRAINT_MESSAGE = 'L\'email n\'est pas valide';
    private const NOT_BLANK_MESSAGE = "Veuillez saisir une valeur";
    private const INVALID_EMAIL_VALUE = "elhadibeddarem@gmail";
    private const VALID_EMAIL_VALUE = "elhadibeddarem@gmail.com";
    private const VALID_PASSWORD_VALUE = "password";
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->validator = $kernel->getContainer()->get('validator');
        
    }
}
