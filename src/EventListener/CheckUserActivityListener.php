<?php

// src/EventListener/CheckUserActivityListener.php
namespace App\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\LastActivityInterface;

class CheckUserActivityListener
{

    public function __construct(private TokenStorageInterface $tokenStorage, private AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = $this->tokenStorage->getToken()->getUser();

        // Check user inactivity Vérifier le temps d'inactivité de l'utilisateur ici
        // If user is inactive disconnect it Si l'utilisateur est inactif depuis un certain temps, déconnectez-le

        // Disconnect user if inactive since 30 min déconnexion si l'utilisateur est inactif depuis 30 minutes
        $inactiveTime = 30 * 60; // 30 min in seconds 30 minutes en secondes
        if ($user instanceof LastActivityInterface && $user->getLastActivity() < (time() - $inactiveTime)) {
            $this->authorizationChecker->denyAccess();
        }
    }
}

