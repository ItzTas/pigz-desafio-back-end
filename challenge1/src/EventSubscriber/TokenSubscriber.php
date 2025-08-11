<?php

namespace App\EventSubscriber;

use ApiPlatform\Metadata\Exception\AccessDeniedException;
use App\Controller\TokenAuthenticatedControler;
use App\Service\TokenService;
use App\Utils\AuthUtils;
use Firebase\JWT\ExpiredException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private TokenService $tokenService,
    ) {}

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

        $token = AuthUtils::getBearerToken($event->getRequest());

        try {
            $decoded = $this->tokenService->decode($token);
            $event->getRequest()->attributes->set('jwt_payload', $decoded);
        } catch (ExpiredException) {
            throw new AccessDeniedException('Token expired');
        } catch (\Exception) {
            throw new UnauthorizedHttpException('Bearer', 'Invalid token');
        }
    }
}
