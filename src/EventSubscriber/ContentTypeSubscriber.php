<?php // src/EventSubscriber/ContentTypeSubscriber.php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContentTypeSubscriber implements EventSubscriberInterface
{
  private $logger;

  public function __construct(LoggerInterface $logger)
  {
    $this->logger = $logger;
  }



  public function onKernelResponse(ResponseEvent $event)
  {
    $response = $event->getResponse();

    $this->logger->info(sprintf('Symfony a retourné  "%s" comme response.', $response->headers->get('content-type', 'text/html')));
  }
  // quel event on veut écouter
  public static function getSubscribedEvents():array
  {
    return [
      ResponseEvent::class => ['onKernelResponse', 10]
    ];
  }
}
