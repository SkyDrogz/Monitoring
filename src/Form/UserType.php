<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Entreprise;
use App\Entity\Role;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add ('identifiant', TextType::class, array('label'=>false,
        'attr' => array(
            'placeholder' => 'Identifiant',
       ),))
        -> add ('password', PasswordType::class, array('label'=>false,
        'attr' => array(
            'placeholder' => 'Mot de passe',
       ),))
        -> add ('tel', TextType::class, array('label'=>false,
        'attr' => array(
            'placeholder' => 'Téléphone',
       ),))
        -> add ('email',TextType::class, array('label'=>false,
        'attr' => array(
            'placeholder' => 'Email',
       ),))
        ->add('entreprise', EntityType::class, array(
            'label'=>false,
            'class' => Entreprise::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('e')
                    ->where ('e.actif = 1')
                    ->orderBy('e.libelle', 'ASC');
            },
            'placeholder' => 'Selectionner une entreprise',
            'choice_label' => 'libelle',
            'required' => false
        ))
        ->add('role', EntityType::class, array(
            'label'=>false,
            'class' => Role::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('r')
                    ->orderBy('r.nomRole', 'ASC');
            },
            'placeholder' => 'Selectionner un role',
            'choice_label' => 'nomRole',
            ))
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
