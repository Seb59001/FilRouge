<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelee_cour',TextType::class, [
                'required' => true,
                "attr" => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'libellee',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => '2', 'max' => '50']),
                    new Assert\NotBlank()
                ]
            ])
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text',
                "attr" => [
                    'class' => 'form-control'
                ],
                'label' => 'date de début',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text',
                "attr" => [
                    'class' => 'form-control'
                ],
                'label' => 'date de fin',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('usersCours',EntityType::class, [
        'class' => Users::class,
        'choice_label' => 'nom',
                "attr" => [
                    'class' => 'form-control'],
                'label' => $options['isAdmin'] ? 'Role (admin only)' : 'Formateurs',
                'required' => $options['isAdmin'],
                'disabled' => !$options['isAdmin'],
    ])
            ->add('submit', SubmitType::class,[
            "attr"=>[
                      'class' => 'btn btn-primary mt-4'
        ]

    ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
            'isAdmin'=>false
        ]);
    }
}
