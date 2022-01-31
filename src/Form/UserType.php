<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class UserType extends AbstractType
{
    private $societe;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' => new Email(),
                    'attr' => [
                        'placeholder' => 'Email',
                    ],
                ]
            )
            ->add('password', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'password',
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'attr' => [
                    'placeholder' => 'confirm password',
                ],
            ])
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
            ]
        );
    }
}
