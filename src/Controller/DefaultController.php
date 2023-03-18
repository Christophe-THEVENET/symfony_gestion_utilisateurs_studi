<?php

namespace App\Controller;

use App\Model\Message;
use App\Form\ContactType;
use App\Event\ContactSentEvent;
use Symfony\Component\HttpFoundation\Request;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class DefaultController extends AbstractController
{

    //**************** HOME ************************* */
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('default/home.html.twig', [
            
        ]);
    }  //********************************************* */


    //**************** CONTACT ************************* */
    #[Route('/contact', name: 'app_contact')]
    public function addContactMessage(Request $request, FlashyNotifier $flashy, EventDispatcherInterface $dispatcher): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // *******  dispatch évenement **************(envoi mail + ajout ds log)**********
            $event = new ContactSentEvent($message);
            $dispatcher->dispatch($event);
            // ********************************************************************************


            // ***************** notif succée login ***************
            $flashy->success('Votre message a bien été envoyé', '');
            // ****************************************************


            return $this->redirectToRoute('app_contact');
        }

        return $this->render('default/contact-message.html.twig', [
            'form' => $form->createView(),
        ]);
    } //********************************************************** */
    


}
