<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
        /**
         * @Route("/formation", name="app_formation")
         * @Route("/formation/add", name="add_formation")
         */
    public function index(ManagerRegistry $doctrine,FormationRepository $fr,Request $request,Formation $formation=null): Response
    {

        $formations= $fr->findBy([],['nomFormation'=>'ASC']);

        $form = $this->createForm(FormationType::class,$formation) ;
        $form->handleRequest($request);   
 
 
        //isvalid pour verifier les donnees
        if($form->isSubmitted() && $form->isValid())
        {
         $formation = $form->getData();
         $entityManager = $doctrine->getManager();
 
         //prepare
         $entityManager ->persist($formation);
         //insert into (exucute)
         $entityManager->flush();
 
         return $this->redirectToRoute('app_formation') ;
 
        }
 



        return $this->render('formation/index.html.twig', [
            'formations'=>$formations,
            'formAddFormation'=>$form->createView(),
        ]);
    }

      /**
         * @Route("/formation/{id}/supprimer", name="supprimer_formation")
     */

    public function supprimerUnFormation(ManagerRegistry $doctrine,
    Formation $formation){
   
       $entityManager = $doctrine->getManager(); 
       $entityManager->remove($formation);
       $entityManager->flush();

       return $this->redirectToRoute('app_formation');

    }

  


}
