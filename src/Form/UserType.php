<?php

namespace Offerum\Form;

use Offerum\Command\User\SaveUserCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Nazwa użytkownika zbyt krótka, musi mieć minimalnie {{ limit }} znaków'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Email([
                        'message' => 'To nie jest prawidłowy adres email'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Hasła nie są takie same',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Hasło zbyt krótkie, musi mieć minimalnie {{ limit }} znaków',
                        'max' => 4096,
                        'maxMessage' => 'Hasło zbyt długie, musi mieć maksymalnie {{ limit }} znaków'
                    ])
                ],
                'first_options' => [
                    'label' => 'Hasło',
                ],
                'second_options' => [
                    'label' => 'Powtórz hasło'
                ]
            ])
            ->add('fullName', TextType::class, [
                'label' => 'Pełna nazwa (osoby prywatnej lub firmy)',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ])
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numer telefonu',
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/\+*\d{9,}/',
                        'message' => 'To nie jest prawidłowy number telefonu!'
                    ])
                ]
            ])
            ->add('addressStreet', TextType::class, [
                'label' => 'Ulica i numer domu',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ])
                ]
            ])
            ->add('addressPostalCode', TextType::class, [
                'label' => 'Kod pocztowy',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Regex([
                        'pattern' => '/\d{2}-\d{3}/',
                        'message' => 'To nie jest prawidłowy kod pocztowy'
                    ])
                ]
            ])
            ->add('addressCity', TextType::class, [
                'label' => 'Miasto',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ])
                ]
            ])
            ->add('addressCountry', ChoiceType::class, [
                'label' => 'Kraj',
                'choices' => [
                    'Polska' => 'Polska'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SaveUserCommand::class
        ]);
    }
}
