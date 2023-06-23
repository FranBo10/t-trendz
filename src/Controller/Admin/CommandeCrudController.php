<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('membre'),
            AssociationField::new('produit'),
            IntegerField::new('quantite', 'Quantité'),
            MoneyField::new('total', 'Total')->setCurrency('EUR'),
            TextField::new('etat', 'En cours d\'enregistrement'),
            DateTimeField::new('date_enregistrement', 'Date de la commande')->setFormat('d/M/Y')->hideOnForm(),
        ];
    }

    


    public function createEntity(string $entityFqcn) 
    {
        $commande = new $entityFqcn;
        $commande->setDateEnregistrement(new Datetime);
        return $commande;
    }

}