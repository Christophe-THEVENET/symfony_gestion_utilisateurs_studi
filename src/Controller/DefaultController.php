<?php

namespace App\Controller;

use App\Model\Message;
use App\Form\ContactType;
use Psr\Log\LoggerInterface;
use App\Event\ContactSentEvent;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    //**************** HOME ************************* */
    #[Route('/home', name: 'app_home')]
    public function index(LoggerInterface $logger): Response
    {
        /* $logger->info('Mon premier log'); */
        return $this->render('default/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    //**************** CONTACT ************************* */
    #[Route('/contact', name: 'app_contact')]
    public function addContactMessage(MailerInterface $mailer, Request $request, FlashyNotifier $flashy, EventDispatcherInterface $dispatcher): Response
    {

        $message = new Message();

        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ****************** envoie d'email *****************
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
            $mailer->send($email);
            // ****************************************************


            // ***************** envoie evenement *****(mesage ds log)**********
            $data = $form->getData();
            $event = new ContactSentEvent(($data->getEmail()), ($data->getName()));
            /*     $event = new ContactSentEvent('toto', 'tata'); */
            $dispatcher->dispatch($event);
            // ****************************************************

            // ***************** notif succée login ***************
            $flashy->success('Votre message a bien été envoyé', '');
            // ****************************************************


            return $this->redirectToRoute('app_contact');
        }

        return $this->render('default/contact-message.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    //********************************************************** */


}
