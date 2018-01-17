<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add ('identifiant', TextType::class)
        -> add ('password', TextType::class)
        -> add ('tel', TextType::class)
        -> add ('email',TextType::class)
        -> add ('libelle', ChoiceType::class, [
          'choice_label' => function($entreprise, $key, $index) {
            /** @var Entreprise $entreprise */
            return strtoupper($entreprise->getLibelle());
          },
        ])
        -> add ('role', ChoiceType::class,array('choices' => array(
            'Utilisateur'=>'User',
            'Administrateur'=> 'Admin'
        ),))
        -> add ('save', SubmitType::class, array('label'=>'Création utilisateur'))
        ;


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => User::class,
        ]);
    }
}
