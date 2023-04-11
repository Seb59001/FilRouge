<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Eleve;
use App\Entity\Presence;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
class PresenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_presence', DateType::class, [
                'widget' => 'single_text',
                "attr" => [
                    'class' => 'form-control'
                ],
                'label' => 'Date de Cour',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('presenceEleve', EntityType::class, [
                'class' => Eleve::class,
                'choice_label' => function (Eleve $eleve) {
                    return $eleve->getNom() . ' ' . $eleve->getPrenom();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('present',ChoiceType::class, [
        'choices' => [
            'Present' => true,
            'Absent' => false,
        ],
        'attr' => [
            'class' => 'form-control'
        ],
        'label' => 'présence',
        'label_attr' => [
            'class' => 'form-label mt-4'
        ]
    ])
            ->add('description',TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('presence_cours', EntityType::class, [
                'class'=>Cours::class,
                'choice_label' => 'libelee_cour',
                "attr" => [
                    'class' => 'form-control']
            ])
            ->add('submit', SubmitType::class,[
                'label'=>'Valider',
                "attr"=>[
                    'class' => 'btn btn-primary mt-4'
                ]

            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presence::class,
        ]);
    }
}
