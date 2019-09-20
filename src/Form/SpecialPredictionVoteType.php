<?php

namespace App\Form;

use App\Entity\SpecialPredictionVote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecialPredictionVoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isHappening', ChoiceType::class, [
                'choices' => [
                        '' => null,
                        'Ja' => true,
                        'Nee' => false,
                    ],
                'label' => false

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SpecialPredictionVote::class,
        ]);
    }
}
