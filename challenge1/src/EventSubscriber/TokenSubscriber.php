<?php

namespace App\EventSubscriber;

use App\Middleware\TokenAuthenticatedControler;
use Lexik\Bundle\JWTAuthenticationBundle\TokenExtractor\TokenExtractorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    private array $tokens;
    private TokenExtractorInterface $tokenExtractor;

    public function __construct(TokenExtractorInterface $tokenExtractor)
    {
        $this->tokenExtractor = $tokenExtractor;
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

        $token = $this->tokenExtractor->extract($event->getRequest());
    }
}
