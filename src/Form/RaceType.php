<?php

namespace App\Form;

use App\Entity\Race;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'race.name.label'
            ])
            ->add('location', TextType::class, [
                'label' => 'race.location.label'
            ])
            ->add('raceDateStart', TextType::class, [
                'label' => 'race.raceDateStart.label',
                'empty_data' => 'dd-mm-jjjj',
            ])
            ->add('raceDateEnd', TextType::class, [
                'label' => 'race.raceDateEnd.label',
                'empty_data' => 'dd-mm-jjjj',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'race.save.label',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
