<?php

namespace App\Form;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextType::class)
            ->add('datebegin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateend', DateType::class,[
                'widget' => 'single_text',
            ])
            ->add('capacity', IntegerType::class, [
                'empty_data' => 0,
            ])
            ->add('formation', EntityType::class, [
                "class" => Formation::class,
            ])
            ->add('programs', CollectionType::class, [
                'entry_type' => ProgramType::class,
                // Allowing to Add & Delete Programs
                'allow_add' => true,
                "allow_delete" => true,
                // Adds Program using JS
                'prototype' => true,
                // Because there's no setter
                "by_reference" => false,
                'entry_options' => [
                    'attr' => ['class' => 'form-options'],
                ],
            ])
            // ->add('students', CollectionType::class, [
            //     'class' => Student::class,
            //     // Allowing to Add & Delete Students
            //     'allow_add' => true,
            //     "allow_delete" => true,
            //     // Adds Student using JS
            //     'prototype' => true,
            //     // Because there's no setter
            //     "by_reference" => false,
            // ])
            ->add("submit", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
