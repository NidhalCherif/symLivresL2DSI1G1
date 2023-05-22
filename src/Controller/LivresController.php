<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Form\LivresType;
use App\Repository\LivresRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LivresController extends AbstractController
{
    #[Route('/admin/livres', name: 'app_livres')]
    #[IsGranted("ROLE_ADMIN")]
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
    #[IsGranted("ROLE_ADMIN")]
    public function find(Livres $livre): Response
    {   dd($livre);
    }

    #[Route('/admin/livres/add', name: 'app_livres_add')]
    #[IsGranted("ROLE_ADMIN")]
    public function add(ManagerRegistry $doctrine,Request $request): Response
    { $livre=new Livres();
        $form=$this->createForm(LivresType::class,$livre);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        {
            $livre=$form->getData();
            $livre->setPrix(0);
            $em = $doctrine->getManager();
            $em->persist($livre);
            $em->flush();
            return new Response("l'objet livre est ajouté avec succees");
        }


        return $this->render('livres/add.html.twig',['f'=>$form]);

    }
    #[Route('/admin/livres/update/{id}', name: 'app_livres_update_id')]
    #[IsGranted("ROLE_ADMIN")]
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
