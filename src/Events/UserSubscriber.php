<?php

namespace App\Events;

use App\Entity\User;
use DateTime;
use App\Classes\UserAuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private array $methodNotAllowed = [
        Request::METHOD_POST,
        Request::METHOD_GET
    ];

    private $userAuthorizationChecker;

    public function __construct(UserAuthorizationChecker $userAuthorizationChecker, TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->userAuthorizationChecker = $userAuthorizationChecker;
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
        //$decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['check', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function encodePassword(): void
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($user instanceOf User && !in_array($method, $this->methodNotAllowed, true)) {
            $this->userAuthorizationChecker->check($user, $method);
            $user->setUpdatedAt(new DateTime());
        }
    }

    public function check()
    {
        
    }
}