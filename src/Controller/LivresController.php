<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_livres')]
    public function findAll(LivresRepository $rep,Request $request,PaginatorInterface $paginator): Response
    { $livres= $rep->findAll();
        $pagination = $paginator->paginate(
            $livres, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
       //dd($livres); //tableau d'objets livre
        return $this->render('Livres/findAll.html.twig',['livres'=>$pagination]);
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
        //Return $this->redirectToRoute('app_livres_update_id',['id'=>4]);
        //dd($livre);
        Return $this->redirectToRoute('app_livres');
    }


}
