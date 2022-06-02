<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\Personne;
use App\Form\AdresseType;
use Doctrine\ORM\EntityRepository;
use App\Repository\SportRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array('required' => true))
            ->add('prenom', TextType::class)
            ->add('adresse', AdresseType::class)
            ->add('sports', EntityType::class, [
                'class' => Sport::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('s');
                },
                'label' => 'Sports préférés',
                'multiple' => true
            ])
            ->add('accepter', CheckboxType::class, ['mapped' => false])
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $personne = $event->getData();
                if (!isset($personne['accepter']) || !$personne['accepter']) {
                    exit;
                }
            })
            ->add('save', SubmitType::class, ['label' => 'Ajouter une personne']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
