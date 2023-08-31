<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                ],
                'label' => "Nom",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                ],
                'label' => "Prénom",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                    "placeholder" => "Emain de confirmation vous sera envoyer"
                ],
                'label' => "Email",
                'label_attr' => ['class' => 'text']
            ])
            ->add('numtel', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                ],
                'label' => "Numéro de télephone",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Sexe",
                'choices' => [
                    'Male' => 'MALE',
                    'Female' => 'FEMALE'],
                'label_attr' => ['class' => 'text'],
            ])
            ->add('pays', CountryType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Pays",
                'label_attr' => ['class' => 'text']
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                ],
                'label' => "Ville",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('region', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                ],
                'label' => "Région",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password',
                'class' => 'h-full-width'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
                'label_attr' => ['class' => 'text']
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