<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\RacePrediction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RacePredictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fastestTime', TextType::class, [
                'label' => 'Snelste tijd kwalificatie',
            ])
            ->add('fastestDriverInQuali', EntityType::class, [
                'class' => Driver::class,
                'label' => 'Snelste coureur kwalificatie'
            ])
            ->add('fastestDriverInRace', EntityType::class, [
                'class' => Driver::class,
                'label' => 'Snelste coureur race'
            ])
            ->add('firstPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => '1e plaats'
            ])
            ->add('secondPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => '2e plaats'
            ])
            ->add('thirdPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => '3e plaats'
            ])
            ->add('tierMax', ChoiceType::class, [
                'choices'  => [
                    'Rood' => 'Rood',
                    'Geel' => 'Geel',
                    'Wit'  => 'Wit',
                    'Blauw'  => 'Blauw',
                    'Groen'  => 'Groen',
                ],
                'label' => 'Band Max'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Opslaan'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RacePrediction::class,
        ]);
    }
}
