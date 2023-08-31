<?php

namespace App\Form;

use App\Entity\Annonces;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Titre",
                'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
            ])
            ->add('texte', TextareaType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Description",
                'label_attr' => ['style' => 'color:#b26f66; font-weight: bold;'],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Télécharger une photo',
                'mapped' => false,
                'required' => false,
                'data_class' => null,
                'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
            ])
        ;
        if ($options['is_immobilier']) {
            $builder
                ->add('ville', TextType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Ville",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('region', TextType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Région",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('pays', CountryType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Pays",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('prix', NumberType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Prix",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
        ;
        }
        if($options['is_vm']){
            $builder->add('marque', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width',
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ],
                'label' => "Marque",
                'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
            ])
            ->add('prix', NumberType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Prix",
                'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
            ])
        ;
        }
        if($options['is_service']){
            $builder
                ->add('typeservice', TextType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Service",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('prix', NumberType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Prix",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
        ;
        }
        if($options['is_vetements']){
            $builder
                ->add('marque', TextType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Marque",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('prix', NumberType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Prix",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
        ;
        }
        if($options['is_mt']){
            $builder
                ->add('marque', TextType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Marque",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('prix', NumberType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Prix",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
        ;
        }
        if($options['is_autre']){
            $builder
            ->add('typeservice', TextType::class, [
                'attr' => [
                    'class' => 'h-full-width'
                ],
                'label' => "Type",
                'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
                ->add('prix', NumberType::class, [
                    'attr' => [
                        'class' => 'h-full-width'
                    ],
                    'label' => "Prix",
                    'label_attr' => ['style' => 'color: #b26f66; font-weight: bold;'],
                ])
        ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonces::class,
            'is_immobilier' => false,
            'is_vm' => false,
            'is_service'=>false,
            'is_vetements'=>false,
            'is_mt'=>false,
            'is_autre'=>false,
        ]);
    }
}