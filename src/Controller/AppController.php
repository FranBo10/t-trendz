<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/app', name: 'home')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig');
    }

    #[Route('/app/show', name: 'app_show')]
    public function show(ProduitRepository $repo) {
        $produits = $repo->findAll();

        return $this->render('app/show.html.twig', [
            'produits' => $produits,
        ]);

    }
}
