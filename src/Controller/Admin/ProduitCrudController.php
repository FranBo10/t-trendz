<?php

namespace App\Controller\Admin;

use Datetime;
use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
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
            ChoiceField::new('couleur', 'Couleur')->setChoices([
                'Rouge' => 'rouge',
                'Vert' => 'vert',
                'Bleu' => 'bleu',
            ]),
            ChoiceField::new('taille', 'Taille')->setChoices([
                'Petite' => 'petite',
                'Moyenne' => 'moyenne',
                'Grande' => 'grande',
            ]),
            ChoiceField::new('collection', 'Collection')->setChoices([
                'Homme' => 'homme',
                'Femme' => 'femme',
                'Unisex' => 'unisex',
            ]),
            ImageField::new('photo', 'Image')->setBasePath('uploads/images')->setUploadDir('public/uploads/images/')->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),
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
