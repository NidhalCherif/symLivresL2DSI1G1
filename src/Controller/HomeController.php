<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\LivresRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(LivresRepository $rep): Response
    { $livres= $rep->findAll();
        //dd($livres); //tableau d'objets livre
        return $this->render('home/home.html.twig',
            ['livres'=>$livres]);
    }
    #[Route('/cat/{id}', name: 'LivresByCategorie')]
    public function LivresByCategorie(Categories $cat): Response
    {  $livres=$cat->getLivres();
        return $this->render('home/home.html.twig',
            ['livres'=>$livres]);
    }
}
