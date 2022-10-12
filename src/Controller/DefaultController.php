<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class DefaultController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(MailerInterface $mailer): Response
    {

        $email = (new Email())
        ->from('christophethevenet2.0@gmail.com')
        ->to('christophethevenet@yahoo.fr')
        ->subject('This e-mail is for testing purpose')
        ->text('This is the text version')
        ->html('<p>This is the HTML version</p>')
    ;
    $mailer->send($email);


        return $this->render('default/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
