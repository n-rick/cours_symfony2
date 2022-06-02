<?php

namespace App\Form;

use App\Form\PersonneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OnlyPersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('adresse')
            ->remove('sports');
    }

    public function getParent()
    {
        return PersonneType::class;
    }
}
