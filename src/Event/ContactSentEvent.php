<?php // src/Event/ContactSentEvent.php

namespace App\Event;
use App\Model\Message;
use Symfony\Contracts\EventDispatcher\Event;





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
