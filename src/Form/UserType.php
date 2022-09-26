<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control text-center',
                        'placeholder' => 'Votre E-mail',
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-3',
                    ],
                    'label' => 'E-mail',
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control text-center',
                        'placeholder' => 'Confirmer l\'E-mail',
                    ],
                    'label_attr' => [
                        'class' => 'form-label mt-3',
                    ],
                    'label' => 'Confirmation de votre E-mail',
                ],
                'invalid_message' => 'Les E-mail ne correspondent pas',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
            ])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Mot de passe',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' =>
                            'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Votre prénom',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'Prénom',
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Votre nom',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'Nom',
            ])
            ->add('date_of_birth', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'form-control text-center',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'Date de Naissance',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Votre adresse',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'adresse',
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Code Postal',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'constraints' => [
                    new Regex(
                        '/^[0-9]{5}$/',
                        "Votre code postal n'est pas valide."
                    ),
                ],
                'label' => 'Code Postal',
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => 'Commune',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'label' => 'Ville',
            ])
            ->add('phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => '(+33/0)123456789',
                ],
                'constraints' => [
                    new Regex(
                        '/^(0|\+33)[0-9]{9}$/',
                        "Votre numéro n'est pas valide."
                    ),
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'required' => false,
                'label' => 'Téléphone fixe (facultatif)',
            ])
            ->add('mobile_phone', TextType::class, [
                'attr' => [
                    'class' => 'form-control text-center',
                    'placeholder' => '(+33/0)123456789',
                ],
                'label_attr' => [
                    'class' => 'form-label mt-3',
                ],
                'constraints' => [
                    new Regex(
                        '/^(0|\+33)[0-9]{9}$/',
                        "Votre numéro n'est pas valide."
                    ),
                ],
                'required' => false,
                'label' => 'Téléphone mobile (facultatif)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
