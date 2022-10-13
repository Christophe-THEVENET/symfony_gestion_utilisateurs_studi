<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Security\LoginFormAuthenticator;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginFormAuthenticator $authenticator, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {


        setlocale(LC_TIME, "fr_FR");

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ************** envoie un email de confirmation d 'inscription ******(html twig)**************
            $email = (new TemplatedEmail())
                ->from('christophethevenet2.0@gmail.com')
                // recuperer l email d inscription de l utilisateur 
                // $contact = $form->handleRequest($request);
                // ->to($contact->get('email')->getData())
                // ou // $product->getUsers()->getEmail()
                ->to(new Address('drbalito@gmail.com', $user->getUsername()))
                ->subject('Validation de votre compte chez ToutPasCher')
                ->context([
                    'user' => $user,
                    'date' => new DateTime()
                ])
                ->htmlTemplate('emails/register-info.html.twig');
            $mailer->send($email);
            // ***************************************************************************************



            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email





            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
