<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class PackageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $min = $options['min'];
        $max = $options['max'];
        $categoryName = $options['categoryName'];
        $params = $options['paramsInput'];
        $unitPrice = $options['price'];


        if ($min && $max && $min != $max && $max != 1) {

            $builder
                ->add('quantity', IntegerType::class, [
                    "constraints" => [
                        new NotBlank([
                            "message" => "quantity is required"
                        ]),
                        new GreaterThanOrEqual(
                            $min,
                            null,
                            'The min quantity is: ' .$min
                        ),
                        new LessThanOrEqual(
                            $max,
                            null,
                            'The max quantity is: ' .$max
                        )
                    ]
                    ,
                    "attr" => [
                        "value" => $min,
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
                        let price = Math.floor((input.value * $unitPrice)*100)/100;

                        let priceSpan = document.querySelector('.price');
                            if(value.includes('.')){
                                input.value = 0;
                                
                            }
                            
                            if(value >= $min && value <= $max){
                                priceSpan.innerHTML = price +'$';
                            
                            }else{
                                priceSpan.innerHTML = 'Range is ' + $min + ' - ' + $max;
                            }
                            

                        
                        };
                    "
                    ]
                ]);
        }


        for ($i = 0; $i < count($params); $i++) {

            $builder
                ->add(str_replace(" ", "", $params[$i]), TextType::class, [
                    "label" => ucwords($params[$i]),
                    "attr" => [
//                        "placeholder" => ucwords($params[$i]),

                    ],
                    "constraints" => [
                        new NotBlank([
                            "message" => ucfirst($params[$i]) . " is required"
                        ])
                    ]

                ]);
        }


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            "min" => null,
            "max" => null,
            "paramsInput" => null,
            "categoryName" => null,
            "price" => null
        ]);
    }
}
