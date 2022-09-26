<?php

namespace App\Form;

use App\Entity\Loan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;

class LoanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date_reserved', HiddenType::class)
        ->add('date_loan', HiddenType::class)
        ->add('date_return', HiddenType::class)
        ->add('status', HiddenType::class)
        ->add('is_late', HiddenType::class, [
            'data' => 0,
        ])
        ->add('book', HiddenType::class)
        ->add('users', HiddenType::class)
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-marronClaire btn-lg mt-5 text-sable fw-normal'
            ],
            'label' => 'Réservation'
        ]);
        $builder
        ->get('date_reserved')
        ->addModelTransformer(new DateTimeToStringTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Loan::class,
        ]);
    }
}
