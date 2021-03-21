<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\Team;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Naam'
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'label' => 'Team'
            ])
            ->add('avatarFile', VichFileType::class , [
                'label' => 'Avatar'
            ])
            ->add('modalAvatarFile', VichFileType::class , [
                'label' => 'Modal Avatar'
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Opslaan'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
        ]);
    }
}
