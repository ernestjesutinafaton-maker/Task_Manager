<?php

namespace App\Form;

use App\Entity\ToDo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Title',
                'attr' => [
                    'placeholder' => 'Enter the title of the ToDo',
                ],
            ])
            ->add('content', TextType::class, [
                'label' => 'Content',
                'attr' => [
                    'placeholder' => 'Enter the content of the ToDo',
                ],
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'To Do' => 0,
                    'In Progress' => 1,
                    'Done' => 2,
                ],
            ])
            ->add('AssignedTo', TextType::class, [
                'label' => 'Assigned To',
                'attr' => [
                    'placeholder' => 'Enter the name of the person assigned to this ToDo',
                ],
            ])
            ->add('date', DateType::class)
            ->add('save', SubmitType::class, [
                'label' => 'Save ToDo',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToDo::class,
        ]);
    }
}
