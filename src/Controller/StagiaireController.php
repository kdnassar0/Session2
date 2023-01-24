<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

     //doctrine pour pouvoir communicer avec la base 
     // stagiaire pour linier a notre classs
     //methode request

class StagiaireController extends AbstractController
{

    
    /**
     * 
     * @Route("/stagiaire/", name="app_stagiaire")
     * @Route("/stagiaire/add", name="add_stagiaire")
     * @Route("/stagiaire/edit/{id}",name="edit_stagiaire")
     * 
     */

    public function toutsLesStagiaire(StagiaireRepository $s,ManagerRegistry $doctrine,Stagiaire $stagiaire =null,Request $request)
     
    {
        if (!$stagiaire){
            $stagiaire = new Stagiaire() ;

        }
       $stagiaires =$s->findBy([],['nomStagiaire' =>'ASC']);



       $form = $this->createForm(StagiaireType::class,$stagiaire) ;
       $form->handleRequest($request);   


       //isvalid pour verifier les donnees
       if($form->isSubmitted() && $form->isValid())
       {
        $stagiaire = $form->getData();
        $entityManager = $doctrine->getManager();

        //prepare
        $entityManager ->persist($stagiaire);
        //insert into (exucute)
        $entityManager->flush();

        return $this->redirectToRoute('app_stagiaire') ;

       }

       return $this->render('stagiaire/index.html.twig', [
          'stagiaires' =>$stagiaires,
          'formAddStagiaire'=>$form->createView(),
           
           
        ]);

    }

   

  

    /**
     * @Route("/stagiaire/{id}/supprimer",name="supprimer_stagiaire")
     */

     public function supprimerUnStagiaire(ManagerRegistry $doctrine,
     Stagiaire $stagiaire){
        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($stagiaire);
        $entityManager->flush();

        return $this->redirectToRoute('app_stagiaire');

     }





    /**
     * @Route("/stagiaire/{id}/delete/{idStagiaire}", name="delete_stagiaire")
     */

     public function supprimerStagiaire(ManagerRegistry $doctrine,Session $session,int $idStagiaire)
     {
        $entityManager = $doctrine->getManager();
        $stagiaire =$entityManager->getRepository(Stagiaire::class)->find($idStagiaire);
        $session->removeStagiaire($stagiaire);
        $entityManager ->flush();
         
        return $this->redirectToRoute('show_session', ["id" => $session->getId()]) ;
     }
    /**
     * @Route("/stagiaire/{id}/ajouter/{idStagiaire}", name="ajouter_stagiaire")
     */

     public function ajouterStagiaire(ManagerRegistry $doctrine,Session $session,int $idStagiaire)
     {
        $entityManager = $doctrine->getManager();
        // dd($entityManager->getRepository(Stagiaire::class)->find($idStagiaire));
        $stagiaire =$entityManager->getRepository(Stagiaire::class)->find($idStagiaire);
        $session->addStagiaire($stagiaire);
        $entityManager ->flush();
         
        return $this->redirectToRoute('show_session', ["id" => $session->getId()]) ;
     }






    /**
     * @Route("/stagiaire/{id}", name="show_stagiaire")
     */

    public function index(Stagiaire $stagiaire,Stagiaire $sessions ): Response
    {
        return $this->render('stagiaire/show.html.twig', [
           'stagiaire'=>$stagiaire ,
           'sessions'=>$sessions
           
        ]);
    }

  

}
