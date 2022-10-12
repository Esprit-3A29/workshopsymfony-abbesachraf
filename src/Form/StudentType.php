<?php

namespace App\Form;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nce')
            ->add('username')
            ->add('moyenne')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'null' => Student::class,
        ]);
    }
}