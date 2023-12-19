<?php

namespace App\Form;

use App\Entity\User;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add("firstName",TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=> "First Name required"
                    ])
                ]
            ])
            ->add("lastName",TextType::class , [
                "constraints"=> [
                    new NotBlank([
                        "message"=> "Last Name required"
                    ])
                ]
            ])
            ->add('email' , EmailType::class , [
                "constraints" => [
                    new Email([
                        "message" => "Invalid email"
                    ]),
                    new Regex([
                        "pattern" => '/^[^@\t\r\n]+@[^@\t\r\n]+\.[^@\t\r\n]+$/',
                        'message' => 'The password must be at least 6 characters long.',
                    ])
                ]
            ])
            ->add("phoneNumber" , TextType::class, [

                "constraints"=>[
                    new Regex([
                        "pattern" => "/^0\d{7}$/",
                        "message"=> "Number Format Error"
                    ])
                ]
                ])

            ->add('plainPassword', RepeatedType::class, [
                "type"=> PasswordType::class,
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                "invalid_message" => "passwords dont match",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        "pattern" => "/^.{6,}$/",
                        "message" => "At least 6 characters"
                    ])
                ],
            ])

            ->add("isVerified" , HiddenType::class , [
                "mapped"=>false,
                "label"=> false,

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
