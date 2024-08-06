<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class AddBalanceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user', EntityType::class, [
                "class"=> User::class,
                'label'=> 'Choose an email / user',
                "constraints" => [
                    new NotBlank([
                        'message' => 'You must choose an email'
                    ])
                ]
            ])
        ->add('amount' , NumberType::class , [
                'constraints' => [

                    new NotBlank([
                        'message'=> 'Amount cant be empty'
                    ]),
                    new Regex([
                        'pattern' => '/^-?\d+(\.\d+)?$/',
                        'message' => 'Only numeric values'
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 0 ,
                        'message' => 'Value must be greater than zero'
                    ])
                ]
        ])
        ->add('transactionType' , ChoiceType::class , [
            'label' => 'Transaction Type' ,
            'choices' => [
                'Credit +' => 1,
                'Debit -' => 0
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "emails" => null
        ]);
    }
}
