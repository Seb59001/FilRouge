<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('old_password', PasswordType::class, [
            'label' => 'Mon mot de passe actuel ', 
            'label_attr' => [
                'class' => 'form-label mt-4'],

            'mapped' => false,
            'attr' => [
                'data-toggle' => 'password',
                'placeholder' => "Veuillez saisir votre mot de passe actuel ",
                'class' => 'form-control',
                
            ]            
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mon nouveau mot de passe ', 
                'label_attr' => ['class' => 'form-label mt-4'],
                'required' => true,
                'first_options' => [ 'label' => 'Mon nouveau mot de passe ',
                'attr' => [
                    'data-toggle' => 'password',
                    'placeholder' => "Merci de saisir votre nouveau mot de passe",
                    'class' => 'form-control'
                ]
            ],
                'second_options' => [ 
                    'label' => 'Confirmez votre nouveau mot de passe ',
                    'label_attr' => ['class' => 'form-label mt-4'],
                'attr' => [
                    'data-toggle' => 'password',
                    'placeholder' => "Merci de confirmer votre nouveau mot de passe",
                    'class' => 'form-control mt-4'
                ]],
            ])

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-5'
                ],
                'label' => 'Valider'
            ]);
    }}