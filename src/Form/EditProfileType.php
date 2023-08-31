<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Nom",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Prénom",
                'label_attr' => ['class' => 'text'],
            ])
            ->add('numtel', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
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
                    'Male' => 'male',
                    'Female' => 'female'],
                'label_attr' => ['class' => 'text'],
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Ville",                
                'label_attr' => ['class' => 'text']
            ])
            ->add('region', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Région",
                'label_attr' => ['class' => 'text']
            ])
            ->add('pays', CountryType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Pays",
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