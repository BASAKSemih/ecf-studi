<?php

namespace App\Form;

use App\Entity\Booking;
use App\Entity\Hotel;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingJSType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hotel', EntityType::class, [
                'mapped' => false,
                'class' => Hotel::class,
                'choice_label' => 'name',
                'placeholder' => "Choisir l'hotel",
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],

            ])
            ->add('room', ChoiceType::class, [
                'placeholder' => 'Chambre (Choisir un hotel)',
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('checkIn', DateType::class, [
                'required' => true,
                'label' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('checkOut', DateType::class, [
                'required' => true,
                'label' => false,
                'widget' => 'single_text',
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

        $formModifier = function (FormInterface $form, Hotel $hotels = null) {
            $rooms = null === $hotels ? [] : $hotels->getRooms();

            $form->add('room', EntityType::class, [
                'class' => Room::class,
                'choices' => $rooms,
                'required' => false,
                'choice_label' => 'name',
                'placeholder' => 'Chambre (Choisir un hotel)',
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false
            ]);
        };

        $builder->get('hotel')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $hotel = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $hotel);
            }
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
