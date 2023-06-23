<?php 

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService {
    private $repo;

    private $rs;

    public function __construct(ProduitRepository $repo, RequestStack $rs) {
        
        $this->rs = $rs;

        $this->repo = $repo;
        
    }

    public function add($id) {

        $session = $this->rs->getSession();

        $panier = $session->get("panier", []);
        $qt = $session->get("qt", 0);
        
        if(!empty($panier[$id])) {
            $panier[$id]++;
            $qt++;
        }else {
            $panier[$id] = 1;
            $qt++;
        }

        $session->set('panier', $panier);
        $session->set('qt', $qt);
    }

    public function remove($id) {
        $session = $this->rs->getSession();

        $panier = $session->get("panier", []);
        $qt= $session->get("qt", 0);

        if(!empty($panier[$id])) {
            $qt-=$panier[$id];
            unset($panier[$id]);

        } if($qt<0) {
            $qt=0;
        }

        $panier = $session->set("panier", $panier);
        $qt = $session->set("qt", $qt);
    }

    public function dataPanier() {

        $session = $this->rs->getSession();

        $panier = $session->get('panier', []);

        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite) {


            $produit = $this->repo->find($id);
            $dataPanier[] = [
                'produit' => $produit,
                'quantite' => $quantite,
            ];
            $total = $produit->getPrix() * $quantite;

        } 

        return $dataPanier;
    }

    public function total() {
        $dataPanier = $this->dataPanier();
        $total = 0;

        foreach($dataPanier as $item) {
            $totalItem = $item['produit']->getPrix() * $item['quantite'];
            $total += $totalItem;
        }

        return $total;
    }
}

