<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class EditProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $firstName = $options['firstName'];
        $lastName = $options['lastName'];
        $phoneNumber = $options['phoneNumber'];

        $builder
            ->add('firstName', TextType::class, [
                "required" => true,
                "attr" => [
                    'value' => $firstName
                ],
                "constraints" => [
                    new Regex ([
                        'pattern' => '/^[a-zA-Z]+$/',
                        "message" => "Only letters and no white spaces"
                    ]),
                    new NotBlank([
                        'message' => 'First Name is required'
                    ])
                ]

            ])
            ->add('lastName', TextType::class, [
                "required" => true,
                "attr" => [
                    'value' => $lastName
                ],
                "constraints" => [
                    new Regex ([
                        'pattern' => '/^[a-zA-Z]+$/',
                        "message" => "Only letters and no white spaces"
                    ]),
                    new NotBlank([
                        'message' => 'Last Name is required'
                    ])
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                "required" => true,
                "attr" => [
                    'value' => $phoneNumber
                ],
                "constraints" => [
                    new Regex ([
                        'pattern' => '/^0\d*$/',
                        "message" => "Only Numbers are allowed"
                    ]),
                    new NotBlank([
                        'message' => 'Phone number is required'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'firstName' => null,
            'lastName' => null,
            'phoneNumber' => null
        ]);
    }
}
