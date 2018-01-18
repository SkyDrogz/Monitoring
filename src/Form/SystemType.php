<?php

namespace App\Form;

use App\Entity\Systeme;
use App\Entity\CategSysteme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SystemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add ('nom', TextType::class, array('label'=>'Nom :'))
        -> add ('url', TextType::class, array('label'=>'URL : '))
        ->add('categSysteme', EntityType::class, array(
            'label'=>'Categorie :',
            'class' => categSysteme::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cs')
                    ->orderBy('cs.categorie', 'ASC');
            },
            'choice_label' => 'categorie',))
            -> add ('save', SubmitType::class, array('label'=>'Ajouter'))
            ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // uncomment if you want to bind to a class
            'data_class' => Systeme::class,
        ]);
    }
}
