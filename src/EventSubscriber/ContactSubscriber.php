<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use App\Event\ContactSentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSubscriber implements EventSubscriberInterface
{


    // on injecte le logger
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }



    public function onContactSendEvent(ContactSentEvent $event): void
    {
        $this->logger->info(sprintf(' !!!!!!!!!!!!!!!!!!!!!!!!!!!"%s"  vous a envoyé un message:  "%s" depuis l\'adresse mail: "%s"  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!', $event->getName(), $event->getContent(),$event->getEmail()));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactSentEvent::class => 'onContactSendEvent',
        ];
    }
}
