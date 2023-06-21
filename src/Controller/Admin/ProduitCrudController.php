<?php

namespace App\Controller\Admin;

use Datetime;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre', 'Titre'),
            TextEditorField::new('description', 'Description')->onlyOnForms(),
            TextField::new('couleur', 'Couleur'),
            TextField::new('taille', 'Taille'),
            TextField::new('collection', 'Collection'),
            ImageField::new('photo', 'Image')->setBasePath('images/produit')->setUploadDir('public/images/produit')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'),
            IntegerField::new('stock', 'Stock'),
            DateTimeField::new('date_enregistrement')->setFormat('d/M/Y à H:m:s')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn) 
    {
        $produit = new $entityFqcn;
        $produit->setDateEnregistrement(new Datetime);
        return $produit;
    }
    
}
