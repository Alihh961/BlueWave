<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SearchOrdersByUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => User::class,
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'choose an email'
                    ])
                ]
            ])
            ->add('numberOfOrders', ChoiceType::class, [
                'choices' => [
                    'Last 10 orders' => 10,
                    'All' => 'all'

                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'choose an option'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
