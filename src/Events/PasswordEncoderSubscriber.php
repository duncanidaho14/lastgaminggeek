<?php

namespace App\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use ApiPlatform\Core\EventListener\EventPriorities;

class PasswordEncoderSubscriber implements EventSubscriberInterface
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

    public function encodePassword(ViewEvent $event): void
    {
        $user = $event->getControllerResult();

        if ($user instanceOf User) {
            $hashPassword = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hashPassword);
        }
    }
}