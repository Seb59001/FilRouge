<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Creneau;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreneauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle_jour', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Jour'
            ])
            ->add('heure_debut', TimeType::class, [
                'attr' => [
                    'class' => 'b-form-timepicker'
            ]
            ])
            ->add('heure_fin', TimeType::class, [
                'attr' => [
                    'class' => 'b-form-timepicker'
            ]
            ])
            ->add('numero_semaine', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
            ]
            ])

            ->add('appartientcours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'libelee_cour',
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
            'data_class' => Creneau::class,
        ]);
    }
}
