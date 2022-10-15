<?php // src/EventSubscriber/ContentTypeSubscriber.php

namespace App\EventSubscriber;

use App\Controller\SecurityController;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
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

   /*  if ($event->isMainRequest() ) {} */ // astuce pour filtrer

      $this->logger->info(sprintf('Symfony a retourné  "%s" comme response.', $response->headers->get('content-type', 'text/html')));
    
  }
  // quel event on veut écouter
  public static function getSubscribedEvents(): array
  {
    return [
      ResponseEvent::class => ['onKernelResponse', 10],
     /*  SecurityController::class => ['onRegistration', 20], */
    ];
  }


  // log au login user
 /*  public function onRegistration(  User $user): void
  {
   dd('toto');
    $this->logger->info(sprintf('aaaaaaaaaaaaaaaaaaaaaaaaaaaaa'));
  } */









}
