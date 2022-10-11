<?php

namespace App\Security\Voter;

use App\Entity\Product;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ProductsVoter extends Voter
{
    // les permissions
    public const PRODUCT_EDIT = 'PRODUCT_EDIT';
    public const PRODUCT_DELETE = 'PRODUCT_DELETE';

    protected function supports(string $attribute, $product): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        //  est ce que les attributs que l on va passer ds le is_granted sont bien la et est ce que le produit est bien une instance de produit
        return in_array($attribute, [self::PRODUCT_EDIT, self::PRODUCT_DELETE])
            && $product instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::PRODUCT_EDIT:
                // logic to determine if the user can EDIT
                // return true or false
                break;
            case self::PRODUCT_DELETE:
                // logic to determine if the user can VIEW
                // return true or false
                break;
        }

        return false;
    }
}
