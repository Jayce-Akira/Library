<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Type::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setEntityLabelInPlural('Catégories')
            ->setEntityLabelInSingular('Catégorie')
            ->setPageTitle("index","Chapelle-Curreaux / Administration des Catégories de Livre")
            ->setPaginatorPageSize(20);
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
