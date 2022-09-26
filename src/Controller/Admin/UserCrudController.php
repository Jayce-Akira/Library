<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle("index","Chapelle-Curreaux / Administration des Utilisateurs")
            ->setPaginatorPageSize(20);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            BooleanField::new('is_confirmed'),
            TextField::new('email'),
            TextField::new('mobile_phone'),
            TextField::new('phone')
                ->hideOnIndex(),
            TextField::new('address')
                ->hideOnIndex(),
            TextField::new('zipcode')
                ->hideOnIndex(),
            TextField::new('city')
                ->hideOnIndex(),
            DateTimeField::new('created_at')
                ->hideOnIndex()
                ->setFormTypeOption('disabled', 'disabled'),
            ArrayField::new('roles')
                ->hideOnIndex(),
            DateTimeField::new('date_of_birth')
                ->hideOnIndex(),
        ];
    }
    
}