<?php

namespace App\EventSubscriber;

use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;

class LoginSubscriber implements EventSubscriberInterface
{
    private $em;
    private $security;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->security = $security;
    }

    public function onLogin()
    {
        // code php pour mettre à jour la date de dernière connexion
        // die('JE SUIS UN EVENT');
        $user = $this->security->getUser();
        // dd($user);
        $user->setLastLoginAt(new DateTime());
        $this->em->flush();
    }

    public static function getSubscribedEvents(): array
    {
        // return the subscribed events, their methods and priorities
        return [
           LoginSuccessEvent::class => 'onLogin'
        ];
    }
}