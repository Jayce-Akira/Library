<?php

namespace App\Form;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class TypeAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Type::class,
            'placeholder' => 'Rechercher une catégorie du livre',
            'choice_label' => 'name',
            'label' => false,


            'query_builder' => function(TypeRepository $typeRepository) {
                return $typeRepository->createQueryBuilder('type');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
