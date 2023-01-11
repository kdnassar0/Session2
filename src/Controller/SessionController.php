<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="app_session")
     */
    public function index(SessionRepository $s): Response
    {
        $sessionsPassees = $s -> findSessionsPassees() ;
        $SessionsEncours = $s -> findSessionsEncours();
        $SessionsAvenir = $s -> findSessionsAvenir();
        
        return $this->render('session/index.html.twig', [
            "SessionsPassees"=>$sessionsPassees ,
            "SessionsEncours"=>$SessionsEncours ,
            "SessionAvenir"=>$SessionsAvenir
        ]);
    }


    
    /**
     * @Route("/session/add", name="add_session")
     * @Route("/session/edit",name="edit_session")
    */

    public function addSession(ManagerRegistry $doctrine,Session $session=null,Request $request)
    {
        if(!$session){
            $session = new Session();
        }
        $form =$this->createForm(SessionType::class,$session); 
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $session =$form->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session');


        }
        return $this->render('session/add.html.twig',
        ['formAddSession'=>$form->createView()
    
    ]);


    }


     /**
     * @Route("/session/{id}/delete", name="delete_session")
     */

     public function deleteSession(ManagerRegistry $doctrine,Session $session)
     {
        $entityManager = $doctrine->getManager(); 
        $entityManager->remove($session);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_session');
     }
      





    /**
     * @Route("/session/{id}", name="show_session")
     */
      
    public function show(Session $session,session $stagiaire,StagiaireRepository $sr ): Response
    {

        $session_id = $session->getId();
        $nonIncrits = $sr ->findStagiaireNonInscrits($session_id);
        $stagiaires =$session->getStagiaires();
       
        return $this->render('session/show.html.twig', [
           'session'=>$session ,
           'stagiaires'=>$stagiaires ,
           'nonInscrits'=>$nonIncrits
           
        ]);
    }


}
