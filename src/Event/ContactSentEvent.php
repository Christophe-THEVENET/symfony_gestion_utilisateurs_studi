<?php // src/Event/ContactSentEvent.php

namespace App\Event;
use App\Model\Message;
use Symfony\Contracts\EventDispatcher\Event;



// ******** on crée un evenement (envoi message du formulaire de contact) ************

class ContactSentEvent extends Event
{
  private Message $message;

  public function __construct(Message $message)
  {
    $this->message = $message;
   
  }

  
  public function getMessage(): Message
  {
    return $this->message;
  }

 
 

  
}
