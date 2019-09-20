<?php

namespace App\Form;

use App\Entity\SpecialPrediction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialPredictionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prediction', TextType::class, [
                'label' => 'specialPrediction.prediction.label'
            ])
            ->add('isHappened', CheckboxType::class, [
                'label' => 'specialPrediction.happened.label'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'racePrediction.save.label'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpecialPrediction::class,
        ]);
    }
}
