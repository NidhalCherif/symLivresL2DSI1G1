<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_livres')]
    public function findAll(LivresRepository $rep): Response
    { $livres= $rep->findAll();
       //dd($livres);
        return $this->render('Livres/findAll.html.twig',['livres'=>$livres]);
    }
    #[Route('/admin/livres/find/{id}', name: 'app_livres_find_id')]
    public function find(Livres $livre): Response
    {   dd($livre);
    }

    #[Route('/admin/livres/add', name: 'app_livres_add')]
    public function add(ManagerRegistry $doctrine): Response
    { $livre=new Livres();
        $date= new \DateTime('2022-01-01');
        $livre->setLibelle('Réseaux locaux')
              ->setImage('https://via.placeholder.com/300')
              ->setPrix(200)
              ->setEditeur('DUNOD')
              ->setDateEdition($date)
             ->setResume('text...............');
        $em=$doctrine->getManager();
        $em->persist($livre);
        $em->flush();
        dd($livre);

    }
    #[Route('/admin/livres/update/{id}', name: 'app_livres_update_id')]
    public function update_price(Livres $livre,ManagerRegistry $doctrine): Response
    {

        $livre->setPrix(110);
        $em=$doctrine->getManager();
        $em->flush();
        dd($livre);
    }
    #[Route('/admin/livres/delete/{id}', name: 'app_livres_delete_id')]
    public function delete(Livres $livre,ManagerRegistry $doctrine): Response
    {

        $em=$doctrine->getManager();
        $em->remove($livre);
        $em->flush();
        dd($livre);
    }


}
