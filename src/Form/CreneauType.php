<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Creneau;
use App\Entity\Users;
use App\Repository\CoursRepository;
use App\Repository\CreneauRepository;
use App\Repository\UsersRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
        $user = $options['user'];

        $builder
            
            ->add('date_debut_cours', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'date de début du cours'
             ])
            ->add('date_fin_cours', DateTimeType::class, [
                'date_widget' => 'single_text',
                'label' => 'date de fin du cours'
            ])
            ->add('all_day', CheckboxType::class, [
                'required' => false,
                'label' => 'Toute la journée',
            ])
            ->add('appartientcours', EntityType::class, [
                'class' => Cours::class,
                'query_builder' => function (CoursRepository $cr) use ($user) {
                    return $cr->createQueryBuilder('c')
                        ->andWhere('c.user_cours = :user')
                        ->setParameter('user', $user);
                },
                'choice_label' => 'libelee_cour',
                'label' => 'cour',
                "attr" => [
                    'class' => 'form-control']
            ])
            ->add('submit', SubmitType::class, [
                "attr" => [
                    'class' => 'btn btn-primary mt-4'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Creneau::class
        ]);
        $resolver->setRequired('user');
    }
}
