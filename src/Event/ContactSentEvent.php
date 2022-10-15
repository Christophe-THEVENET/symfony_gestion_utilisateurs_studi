<?php // src/Event/ContactSentEvent.php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class ContactSentEvent extends Event
{
  private $email;
  private $content;
  private $name;

  public function __construct(string $name,string $content, string $email)
  {
    $this->email = $email;
    $this->content = $content;
    $this->name = $name;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getContent(): string
  {
    return $this->content;
  }

  /**
   * Get the value of name
   */
  public function getName()
  {
    return $this->name;
  }
}
