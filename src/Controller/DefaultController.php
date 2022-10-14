<?php

namespace App\Controller;

use App\Model\Message;
use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    //**************** HOME ************************* */
    #[Route('/home', name: 'app_home')]
    public function index(MailerInterface $mailer): Response
    {

        return $this->render('default/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }


    //**************** CONTACT ************************* */
    #[Route('/contact', name: 'app_contact')]
    public function addContactMessage(MailerInterface $mailer, Request $request,FlashyNotifier $flashy): Response
    {

        $message = new Message();

        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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

            $flashy->success('Votre message a bien été envoyé', '');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('default/contact-message.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
