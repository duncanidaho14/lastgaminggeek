<?php

namespace App\Classes;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserAuthorizationChecker
{
    private $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];

    private ?UserInterface $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function check(UserInterface $user, string $method): void
    {
        $this->isAuthenticated();
        
        if ($this->checkMethod($method) && $user->getId() !== $this->user->getId()) {
            $errorMessage = "Ce n'est pas vôtre ressource ! ";
            throw new UnauthorizedHttpException($errorMessage, $errorMessage);
        }
    }

    public function isAuthenticated(): void
    {
        if(null === $this->user){
            $error = "Vous n'êtes pas connecté";
            throw new UnauthorizedHttpException($error, $error);
        }
    }

    public function checkMethod(string $method): bool
    {
        return in_array($method, $this->methodAllowed, true);
    }
}