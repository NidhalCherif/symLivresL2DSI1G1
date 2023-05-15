<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{



    #[Route('admin/categories/add', name: 'categories_add')]
    public function add(Request $request,ManagerRegistry $doctrine): Response
    {
        $cat=new Categories();
        $form=$this->createForm(CategorieType::class,$cat);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())
        { $cat=$form->getData();
            $em=$doctrine->getManager();
            $em->persist($cat);
            $em->flush();
            return new Response("l'objet catégorie est ajouté avec succees");

            // hydratation de l'objet categorie avec les données reçues via l'objet Request

        }


        return  $this->render('categories/add.html.twig',['f'=>$form]);


        // traitement
        //recupération des données via l'objet Request
        //persister l'objet categorie

        //Creturn  $this->render('categories/add.html.twig',['f'=>$form]);

    }
}
