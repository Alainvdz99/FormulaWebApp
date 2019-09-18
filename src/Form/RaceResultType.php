<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\RaceResult;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RaceResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fastestTime', TextType::class, [
                'label' => 'raceResult.fastestTime.label',
            ])
            ->add('fastestDriverInQuali', EntityType::class, [
                'class' => Driver::class,
                'label' => 'raceResult.fastestDriverInQuali.label'
            ])
            ->add('fastestDriverInRace', EntityType::class, [
                'class' => Driver::class,
                'label' => 'raceResult.fastestDriverInRace.label'
            ])
            ->add('firstPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => 'raceResult.firstPlaceDriver.label'
            ])
            ->add('secondPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => 'raceResult.secondPlaceDriver.label'
            ])
            ->add('thirdPlaceDriver', EntityType::class, [
                'class' => Driver::class,
                'label' => 'raceResult.thirdPlaceDriver.label'
            ])
            ->add('tierMax', ChoiceType::class, [
                'choices'  => [
                    'Rood' => 'Rood',
                    'Geel' => 'Geel',
                    'Wit'  => 'Wit',
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'raceResult.save.label'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RaceResult::class,
        ]);
    }
}
