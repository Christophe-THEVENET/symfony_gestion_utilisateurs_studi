<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseSubscriber implements EventSubscriberInterface
{




    public function __construct(private readonly LoggerInterface $logger)
    {
    }


    public function onKernelResponse(ResponseEvent $event): void
    {
        $this->logger->info($event->getRequest());
    }

    // liste des évenements auquels on s'abonne
    public static function getSubscribedEvents(): array
    {
        return [
            // c'est un evenement natif symfony kernel.response qui sera déclenché a chaque éxecution d'une réponse
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }
}
