<?php

namespace App\Controller;

use App\Entity\Programe;
use App\Form\ProgrameTypePhpType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgrameController extends AbstractController
{
    /**
     * @Route("/programe/{id}/delete", name="delete_programe")
     */
    public function delete(ManagerRegistry $doctrine,Programe $programe): Response
    {

    $entityManager = $doctrine->getManager();
    $entityManager->remove($programe);
     $entityManager->flush();

   return $this->redirectToRoute('show_session',['id'=> $programe->getSession()->getId()
    ]);
    }  


    /**
     * @Route("/programe/add", name="add_programe")
    */

    public function addPrograme(ManagerRegistry $doctrine,Programe $programe=null,Request $request)
    {
        $form =$this->createForm(ProgrameTypePhpType::class,$programe); 
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $programe =$form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($programe);
            $entityManager->flush();

            return $this->redirectToRoute('add_programe');


        }
        return $this->render('programe/add.html.twig',
        ['formAddPrograme'=>$form->createView()
    
    ]);




    }


  

}
