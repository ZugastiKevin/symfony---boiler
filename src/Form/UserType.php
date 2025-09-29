<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isEdit = $options['is_edit'];

        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'required' => !$isEdit,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'error_mapping' => [
                    '.' => 'second',
                ],
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'minlength' => 8,
                        'maxlength' => 4096,
                        'pattern' => '^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$',
                        'title' => 'Au moins 1 majuscule, 1 chiffre et 1 caractère spécial',
                    ],
                    'constraints' => [
                        ...(!$isEdit ? [new Assert\NotBlank(['message' => 'Le mot de passe est obligatoire'])] : []),
                        new Assert\Length(min: 8, minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères'),
                        new Assert\Regex('/[A-Z]/', 'Ajoutez au moins une majuscule.'),
                        new Assert\Regex('/\d/',   'Ajoutez au moins un chiffre.'),
                        new Assert\Regex('/[\W_]/','Ajoutez au moins un caractère spécial.'),
                        new Assert\NotCompromisedPassword(message: "Ce mot de passe figure dans des fuites connues, merci d'en choisir un autre."),
                    ],
                ],
                'second_options' => [
                    'label_html' => true,
                    'label' => '<span>Confirmation du mot de passe</span>',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false,
        ]);
    }
}
