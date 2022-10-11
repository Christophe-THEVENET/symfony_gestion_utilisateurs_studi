<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ProductsVoter extends Voter
{
    // les permissions
    public const PRODUCT_EDIT = 'PRODUCT_EDIT';
    public const PRODUCT_DELETE = 'PRODUCT_DELETE';


    // ********* récuperer le role de l'utilisateur **********
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security; // permet de vérifier les roles de l'utilisateur
    }
    // *****************************************************



    // on vérifie si on envoi les bonnes informations sinon pas de permissions
    protected function supports(string $attribute, $product): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        //  est ce que les attributs que l on va passer ds le is_granted sont bien la et est ce que le produit est bien une instance de produit
        return in_array($attribute, [self::PRODUCT_EDIT, self::PRODUCT_DELETE])
            && $product instanceof Product;
    }


    protected function voteOnAttribute(string $attribute, $product, TokenInterface $token): bool
    {
        // on récupère le user 
        $user = $token->getUser();
        // on vérifie si il est connecté (sinon pas de permissions)
        if (!$user instanceof UserInterface) {
            return false;
        }


        // on vérifie si l'utilisateur est admin (si oui il a tout les droits) et donc return true
        if ($this->security->isGranted('ROLE_ADMIN')) return true;


        // on vérifie si le produit à un vendeur
        if (null === $product->getOwner()) return false;



        // ... (vérifie le type de permissions qu on demande) ...
        switch ($attribute) {
            case self::PRODUCT_EDIT:
                // on vérifie si on peut éditer
                return $this->canEdit($product, $user);
                break;
            case self::PRODUCT_DELETE:
                // on vérifie si on peut supprimer
                return $this->canDelete();
                break;
        }

        return false;
    }

    private function canEdit(Product $product, User $user)
    {

        // le vendeur du produit peut la modifier
        return $user === $product->getOwner();
    }

    private function canDelete()
    {

        // seul l admin peut supprimer sinon return false
        if ($this->security->isGranted('ROLE_ADMIN')) return true;
        return false;


        // le vendeur du produit peut la supprimer
        /* return $user === $product->getOwner(); */
    }
}
