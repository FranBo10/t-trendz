<?php

namespace App\Controller;

use App\Entity\Membre;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Service\CartService;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\request;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(CartService $cs): Response
    {
        $dataPanier = $cs->dataPanier();
        $total = $cs->total();              

        return $this->render('cart/index.html.twig', [
            'dataPanier' => $dataPanier,
            'total' => $total
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add($id, CartService $cs) {
        $cs->add($id);
        
       
        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/remove/{id}', name:'cart_remove')]
    public function remove($id, CartService $cs) {

        $cs->remove($id);
        

        return $this->redirectToRoute('app_cart');
    }

    #[Route('/cart/commandes', name: 'commandes')]
    public function commande(EntityManagerInterface $manager, ProduitRepository $repo,  CartService $cs) : Response {
        $dataPanier = $cs->datapanier();        
  
        foreach($dataPanier as $item) {
            $produit = $item['produit'];
            $quantite = $item['quantite'];
            $commande = new Commande;
            $commande->setProduit($produit)
                ->setMembre($this->getUser())
                ->setQuantite($quantite)
                ->setMontant($produit->getPrix() * $quantite)
                ->setEtat("En cours d'enregistrement")
                ->setDateEnregistrement(new \DateTime());        

        $manager->persist($commande);
        
        }    

        $manager->flush();
        $this->addFlash("success", "La commande a été bien mise en compte");
        return $this->redirectToRoute('home');
    }
    
    
    #[Route('/cart/commandes/delete/{id}', name: 'commande_delete')]
    public function deleteCommande(EntityManagerInterface $manager, Commande $commande)
{
    $manager->remove($commande);
    $manager->flush();
    $this->addFlash("success", "La commande a été supprimée");
    return $this->redirectToRoute('commandes');
}

#[Route('/cart/commandes/show', name: 'cart_show')]
public function show(CommandeRepository $repo) {
    $commandes = $repo->findAll();

    return $this->render('cart/commandes.html.twig', [
        'commandes' => $commandes, 
    ]);
}
}
