<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'empty_data' => '',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an username'
                    ]),
                    new Length([
                        'max' => 180,
                        'maxMessage' => 'You can type maximum {{ limit }} characters'
                    ])
                ]
            ])
            ->add('password', RepeatedType::class, array(
                'mapped' => false,
                'required' => true,
                'empty_data' => [],
                'type' => PasswordType::class,
                'invalid_message' => 'The password fields must match.',
                'first_options'  => array('label' => 'Password'),
                'second_options' => array('label' => 'Confirm Password'),
                'constraints' => array(
                    new NotBlank([
                        'message' => 'Please enter a password'
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'You have to type at least {{ limit }} characters',
                        'max' => 255,
                        'maxMessage' => 'You can type maximum {{ limit }} characters'
                    ])
                )
            ));
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
