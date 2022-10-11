<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserEditFormType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    $builder
      ->add('username', TextType::class, [
        'label_format' => 'Pseudonyme',
        "required" => true,
        'attr' => ['class' => 'form-control mb-3'],
        "constraints" => [
          new Length(["min" => 2, "max" => 180, "minMessage" => "Le nom d'utilisateur ne doit pas faire moins de 2 caractères", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 180 caractères"]),
          new NotBlank(["message" => "Le nom d'utilisateur ne doit pas être vide !"])
        ]
      ])

      ->add('Roles', ChoiceType::class, [
        'attr' => ['class' => 'form-control mb-3'],
        'required' => true,
        'multiple' => false,
        'expanded' => false,
        'choices'  => [
          'User' => 'ROLE_USER',
          'Admin' => 'ROLE_ADMIN',
          'Super-Admin' => 'ROLE_SUPER_ADMIN',
        ],
      ]);
    // Data transformer
    $builder->get('Roles')
      ->addModelTransformer(new CallbackTransformer(
        function ($rolesArray) {
          // transform the array to a string
          return count($rolesArray) ? $rolesArray[0] : null;
        },
        function ($rolesString) {
          // transform the string back to an array
          return [$rolesString];
        }
      ));
  }








  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => User::class,


    ]);
  }
}
