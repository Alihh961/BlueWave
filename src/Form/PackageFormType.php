<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PackageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $min = $options['min'];
        $max = $options['max'];
        $categoryName = $options['categoryName'];


        $builder
            ->add('id', TextType::class , [
                "label" => "ID",
                "attr" => [
                    "placeholder" => "Your ID in $categoryName app",

                ],
                "constraints" => [
                    new NotBlank([
                        "message"=> "id is required"
                    ])
                ]

            ] )
            ->add('quantity' , IntegerType::class , [
                "constraints" => [
                    new NotBlank([
                        "message" => "quantity is required"
                    ])
                ]
                ,
                "attr"=>[
                    "value" =>$min,
                    'min' => $min,
                    'max' => $max,
                    'minMessage' => 'The minimium value is ' . $min,
                    'maxMessage' => 'The max value is ' . $max,

                    'inputmode' => 'numeric',
                    'oninput' => "
                    handleInput(event);
                        function handleInput(event){
                        let input = document.querySelector('#package_form_quantity');
                        
                            let value = event.target.value;
                            
                            if(value.includes('.')){
                                input.value = 0;
                            }
                        };
                    "
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "min" => null ,
            "max" => null,
            "categoryName" => null
        ]);
    }
}
