<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email', EmailType::class, [
                'constraints' => new Email(),
            ])
            ->add('question', TextareaType::class, [
                'attr' => [
                    'maxlength' => 255,
                ],
            ])
            ->add('checked')
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary btn mt-3'
                ]
            ])
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            [$this, 'preSetData']
        );
    }

    public function preSetData(FormEvent $event)
    {
        $event->getData()->setChecked(false);
        $event->getForm()->remove('checked');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
