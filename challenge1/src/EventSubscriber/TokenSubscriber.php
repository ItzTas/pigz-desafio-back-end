<?php

namespace App\EventSubscriber;

use App\MiddlewareInterfaces\TokenAuthenticatedControler;
use App\Services\AuthService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controler = $event->getController();

        if (!$controler instanceof TokenAuthenticatedControler) {
            return;
        }

        $token = $this->authService->getJWTToken();
    }
}
