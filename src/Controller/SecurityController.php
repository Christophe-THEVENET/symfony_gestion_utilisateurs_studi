<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();




        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

        /* 

    pour activer l option se souvenir de moi au login il faut injecter ds le security.yaml:
                           
       remember_me:
        secret:   '%kernel.secret%'
        lifetime: 604800 # 1 week in seconds
         path: / 
         
         et modifier le template login:

            <div class="checkbox mb-3">
                <label>
                      <input type="checkbox" name="_remember_me"> Remember me
                 </label>
            </div>
         
         */
    }




    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
