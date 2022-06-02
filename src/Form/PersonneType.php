<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\Personne;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, array('required' => true))
            ->add('prenom', TextType::class)
            ->add('adresse', AdresseType::class)
            ->add('sports', ChoiceType::class, [
                'choices' => [
                    'Foot' => 'Foot',
                    'Tennis' => 'Tennis',
                    'Other' => null,
                ],

            ])
            ->add('save', SubmitType::class, ['label' => 'Ajouter une personne']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
