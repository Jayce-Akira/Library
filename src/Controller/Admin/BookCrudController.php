<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): crud
    {
        return $crud
            ->setEntityLabelInPlural('Livres')
            ->setEntityLabelInSingular('Livre')
            ->setPageTitle("index","Chapelle-Curreaux / Administration des Livres")
            ->setPaginatorPageSize(20);
    }
   
    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('title','Titre'),
            TextField::new('author', 'Auteur'),
            DateField::new('date_published', 'date de publication')
                ->hideOnIndex(),
            TextField::new('editor', 'Editeur'),
            IntegerField::new('nb_of_book', 'Nombre de livre'),
            AssociationField::new('type','Catégorie'),
            TextEditorField::new('description', 'Déscritption')
            ->hideOnIndex(),
            TextField::new('img_cover', 'Image de couverture')
                ->hideOnIndex(),
            
        ];
    }
   
}
