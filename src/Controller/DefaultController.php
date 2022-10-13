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



        return $this->render('default/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}

