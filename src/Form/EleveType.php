<?php

namespace App\Form;

use Assert\length;
use App\Entity\Eleve;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;


class EleveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prenom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Telephone',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'choices' => [
                    'Féminin' => "Féminin",
                    'Masculin' => "Masculin"
                ],
                'label' => 'Sexe',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])
            ->add('niveau_etude', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => "Niveau d'études",
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ], 
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank(),
     
                ]
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-5'
                ],
                'label' => 'Valider'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleve::class,
        ]);
    }
}
