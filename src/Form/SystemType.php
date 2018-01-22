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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SystemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        -> add ('nom', TextType::class, array('required' => true, 'label'=>'Nom :'))
        -> add ('url', TextType::class, array('required' => true, 'label'=>'URL : '))
        -> add('categSysteme', EntityType::class, array(
            'required' => true,
            'label'=>'Categorie :',
            'class' => CategSysteme::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('cs')
                    ->orderBy('cs.categorie', 'ASC');
            },
            'choice_label' => 'categorie',))

            -> add('user', EntityType::class, array(
                'required' => true,
                'label'=>'Utilisateur référent (recevras les notifications de pannes) :',
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.identifiant', 'ASC');
                },
                'choice_label' => 'identifiant',))


            ->add('niveauUrgence', ChoiceType::class, array(
                'choices' => array(
                    'Urgent' => 1,
                    'Mineur' => 0,

                )))

        -> add ('requete', TextareaType::class, array('required' => false, 'label'=>'Requête JSON (pour API): '))
        -> add ('resultatAttendu', TextType::class, array('required' => false, 'label'=>'Résultat attendu à la requête (Pour API): '))
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
