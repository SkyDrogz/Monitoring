<?php

namespace App\Form;

use App\Entity\Systeme;
use App\Entity\CategSysteme;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SystemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add ('nom', TextType::class, array('label'=>false,
        'attr' => array(
            'required' => true,
            'placeholder' => 'Nom du système',
       ),))
        -> add ('url', TextType::class, array('label'=>false,
        'attr' => array(
            'required' => true,
            'placeholder' => 'URL du système',
       ),))
       -> add ('repetition', IntegerType::class, array('label'=>false,
       'attr' => array(
         'required' => true,
           'value' => null,
           'placeholder' => 'Répétition des alertes en cas de dysfonctionnement (temps en minutes)',
      ),))
        -> add('categSysteme', EntityType::class, array(
            'required' => true,
            'label'=>false,
            'class' => CategSysteme::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cs')
                    ->orderBy('cs.categorie', 'ASC');
            },
            'placeholder' => 'Selectionner une catégorie système',
            'choice_label' => 'categorie',))

            -> add('user', EntityType::class, array(
                'required' => true,
                'label'=>false,
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.identifiant', 'ASC');
                },
                'placeholder' => 'Selectionner un utilisateur référent',
                'choice_label' => 'identifiant',))


            ->add('niveauUrgence', ChoiceType::class, array(
                'label'=>false,
                'choices' => array(
                    'Urgent' => 1,
                    'Mineur' => 0,

                ),
                'placeholder' => "Selectionner un niveau d'urgence",
                ))

        -> add ('requete', TextareaType::class, array('required' => false, 'label'=>false,
        'attr' => array(
            'placeholder' => 'Rêquete JSON (pour API)',
       ),))
        -> add ('resultatAttendu', TextType::class, array('required' => false, 'label'=>false,
        'attr' => array(
            'placeholder' => 'Resultat attendu (pour API)',
       ),))
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
