<?php // src/Form/ContactType.php

namespace App\Form;

use Assert\Email;
use App\Model\Message;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label_format' => 'Nom',
                "required" => true,
                'attr' => ['class' => 'form-control mb-3'],
                "constraints" => [
                    new Length(["min" => 2, "max" => 180, "minMessage" => "Le nom d'utilisateur ne doit pas faire moins de 2 caractères", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 180 caractères"]),
                    new NotBlank(["message" => "Le nom d'utilisateur ne doit pas être vide !"])
                ]
            ])
            ->add('email', EmailType::class, [
                'label_format' => 'Email',
                "required" => true,
                'attr' => ['class' => 'form-control mb-3'],
                'constraints' => [
                    new Assert\Email([
                        'message' => 'Le format d\'email est incorrect'
                    ]),
                ]
            ])

            ->add('subject', TextType::class, [
                'label_format' => 'Objet',
                "required" => true,
                'attr' => ['class' => 'form-control mb-3'],
                "constraints" => [
                    new Length(["min" => 2, "max" => 180, "minMessage" => "Le nom d'utilisateur ne doit pas faire moins de 2 caractères", "maxMessage" => "Le nom d'utilisateur ne doit pas faire plus de 180 caractères"]),
                    new NotBlank(["message" => "Le nom d'utilisateur ne doit pas être vide !"])
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control mb-3'],
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
