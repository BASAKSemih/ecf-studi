<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('topic', ChoiceType::class, [
                'required' => true,
                'label' => false,
                'choices' => [
                    'Je souhaite poser une réclamation' => 'Je souhaite poser une réclamation',
                    'Je souhaite commander un service supplémentaire' => 'Je souhaite commander un service supplémentaire',
                    'Je souhaite en savoir plus sur une suite' => 'Je souhaite commander un service supplémentaire',
                    "J'ai un souci avec cette application" => "J'ai un souci avec cette application"
                ],
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('context', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'btn btn-lg btn-primary mt-2',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
