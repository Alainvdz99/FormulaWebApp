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
                'label' => 'Naam'
            ])
            ->add('location', TextType::class, [
                'label' => 'Locatie'
            ])
            ->add('raceDateStart', TextType::class, [
                'label' => 'Start datum race',
                'empty_data' => 'dd-mm-jjjj',
            ])
            ->add('raceDateEnd', TextType::class, [
                'label' => 'Eind datum race',
                'empty_data' => 'dd-mm-jjjj',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Opslaan',
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
