<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use App\Event\ContactSentEvent;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;




class ContactSubscriber implements EventSubscriberInterface
{

    // on injecte le logger et le mailer
    public function __construct(LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->logger = $logger;
        $this->mailer = $mailer;
    }



    // ***************** ecoute l evenement **********************************
    public function onContactSendEvent(ContactSentEvent $event): void
    {
        // recupère le message
        $message = $event->getMessage();

        // *************************log le message **************************************
        $this->logger->info(sprintf(' !!!!!!!!!!!!!!!!!!!!!!!!!!!"%s"  vous a envoyé un message. Objet "%s", message: "%s"  depuis l\'adresse mail: "%s"  !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!', $message->getName(), $message->getSubject(), $message->getContent(), $message->getEmail()));
        // ******************************************************************************



        // ************************* envoie email **************************************
        $email = (new TemplatedEmail())
            ->from('christophethevenet2.0@gmail.com')
            ->to('christophethevenet@yahoo.fr')
            ->replyTo(new Address($message->getEmail(), $message->getName()))
            ->subject($message->getSubject())
            ->context([
                'message' => $message,
                'content' => $message->getContent()
            ])
            ->htmlTemplate('emails/message.html.twig');
        $this->mailer->send($email);
        // ******************************************************************************


    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactSentEvent::class => 'onContactSendEvent',
        ];
    }
}
