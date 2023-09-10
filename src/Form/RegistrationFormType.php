<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'CestMoiQuiRegale',
                    'class' => 'form-control my-2',
                    'aria-label' => 'Nom d\'utilisateur',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom d\'utilisateur est obligatoire.',
                    ]),
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Adresse e-mail',
                'required' => true,
                'attr' => [
                    'placeholder' => 'cestmoiquiregale@gmail.com',
                    'class' => 'form-control my-2',
                    'aria-label' => 'Email',
                ]
            ])

            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions d\'utilisation.',
                    ]),
                ],
                'label' => 'J\'accepte les <a href="{{ path(\'terms_page\') }}">conditions d\'utilisation</a> et la <a href="{{ path(\'policy_page\') }}">politique de confidentialité</a>',
                'label_html' => true,
                'invalid_message' => 'Vous devez accepter les conditions d\'utilisation.',
            ])
            ->add('plainPassword', RepeatedType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'label' => 'Mot de passe',
                ],
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'my-2',
                        'aria-label' => 'Mot de passe',
                        'placeholder' => '6 caractères minimum, dont une majuscule, un chiffre et un caractère spécial',
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                    'attr' => [
                        'class' => 'my-2',
                        'aria-label' => 'Confirmer le mot de passe',
                        'placeholder' => 'Confirmer le mot de passe',
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit avoir au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[~!@#$%^&*()_\-+=\[\]{}|\\:;\"'<>,.?\/]).{6,}$/",
                        'message' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial.'
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
