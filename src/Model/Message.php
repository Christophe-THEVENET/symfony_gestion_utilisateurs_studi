<?php // src/Model/Message.php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    /**
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $email;

    /**
     * @Assert\NotBlank
     */
    private $subject;

    /**
     * @Assert\NotBlank
     */
    private $content;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}