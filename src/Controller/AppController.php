<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProduitRepository $repo): Response
    {
        $produits = $repo->findAll();

        return $this->render('app/index.html.twig', [
            'produits' => $produits,
        ]);
    }

    #[Route('/show/{id}', name: 'app_show')]
    public function show(ProduitRepository $repo, $id) {
        $produit = $repo->find($id);

        return $this->render('app/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/profil', name: 'profil')]
    public function profil(CommandeRepository $repo) {

        $commandes = $repo->findBy(['membre' => $this->getUser('id')]);

        return $this->render('app/profil.html.twig', [
            'commandes' => $commandes
        ]);

    }

}
