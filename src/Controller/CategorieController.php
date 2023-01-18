<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="app_categorie")
     * @Route("/categorie/add", name="add_categorie")
     * @Route("/cours/add", name="add_cours")
     */
    public function index(CategorieRepository $c,ManagerRegistry $doctrine,Categorie $categorie=null,Request $request,Cours $cours=null): Response
    {

        $categories = $c->findBy([],['nomCategorie'=>'ASC']);


        $form =$this->createForm(CategorieType::class,$categorie); 
        $form->handleRequest($request);

        $form1 =$this->createForm(CoursType::class,$cours); 
        $form1->handleRequest($request);



        if( $form->isSubmitted() && $form->isValid())
        {
            $categorie =$form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');


        }
        if( $form1->isSubmitted() && $form1->isValid())
        {
            $cours =$form1->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($cours);
            $entityManager->flush();

            return $this->redirectToRoute('app_categorie');


        }


        return $this->render('categorie/index.html.twig', [
           'categories'=>$categories,
           'formAddCategorie'=>$form->createView(),
           'formAddCours'=>$form1->createView()
        ]);
    }




}