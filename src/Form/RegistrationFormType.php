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
            ->add("firstName", TextType::class, [
                "constraints" => [
                    new Regex ([
                        'pattern' => '/^[a-zA-Z]+$/',
                        "message" => "First name: Only letters and no white spaces"
                    ]),
                    new NotBlank([
                        "message" => "First Name required"
                    ])
                ]
            ])
            ->add("lastName", TextType::class, [
                "constraints" => [
                    new Regex ([
                        'pattern' => '/^[a-zA-Z]+$/',
                        "message" => "Last name: Only letters"
                    ]),
                    new NotBlank([
                        "message" => "Last Name required"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
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
            ->add("phoneNumber", TextType::class, [

                "constraints" => [
                    new Regex([
                        "pattern" => "/^0\d*$/",
                        "message" => "Number Format Error"
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' => 'Password',
                    "attr"=> [
                        'placeholder'=>'Enter your password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Repeat Password',
                    "attr"=> [
                        'placeholder'=>'Retype the password'
                    ]
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Regex([
                        "pattern" => "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/",
                        "message" => "At least 8 characters with at least one uppercase letter, one lowercase letter, one digit and one special character."
                    ])
                ],

            ])
            ->add("isVerified", HiddenType::class, [
                "mapped" => false,
                "label" => false,

            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
