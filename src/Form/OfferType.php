<?php

namespace Offerum\Form;

use Offerum\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Length([
                        'min' => 4,
                        'minMessage' => 'Wartość zbyt krótka, musi mieć minimalnie {{ limit }} znaki',
                        'max' => 64,
                        'maxMessage' => 'Wartość zbyt długa, musi mieć maksymalnie {{ limit }} znaków'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Opis',
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Length([
                        'min' => 32,
                        'minMessage' => 'Wartość zbyt krótka, musi mieć minimalnie {{ limit }} znaki',
                        'max' => 4000,
                        'maxMessage' => 'Wartość zbyt długa, musi mieć maksymalnie {{ limit }} znaków'
                    ])
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Obraz',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Obraz dla oferty jest wymagany!',
                        'groups' => ['Create']
                    ]),
                    new File([
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg'
                        ],
                        'mimeTypesMessage' => 'Nieprawidłowy format pliku',
                        'maxSize' => '1M',
                        'maxSizeMessage' => 'Plik jest zbyt duży! Może mieć maksymalnie 1 MB'
                    ])
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Cena',
                'currency' => 'PLN',
                'divisor' => 100,
                'constraints' => [
                    new NotBlank([
                        'message' => 'To pole nie może być puste'
                    ]),
                    new Range([
                        'min' => 100,
                        'minMessage' => 'Wartość zbyt niska, musi być minimalnie 1.00 PLN'
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class
        ]);
    }
}