<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Programe;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Doctrine\ORM\EntityManager;
use App\Form\ProgrameTypePhpType;
use App\Repository\SessionRepository;
use App\Repository\ProgrameRepository;
use App\Repository\StagiaireRepository;
// use Symfony\Component\BrowserKit\Request;
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
     * @Route("/session/edit/{id}",name="edit_session")
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
      
    public function show(Session $session,Session $stagiaire,StagiaireRepository $sr,ProgrameRepository  $pr ,Programe $programe = null,Request $request,ManagerRegistry $doctrine,int $id  ): Response
    {
        
        $session_id = $session->getId();
        $nonIncrits = $sr ->findStagiaireNonInscrits($session_id);
        $stagiaires =$session->getStagiaires();

        $nonProgramees = $pr->findCoursNonProgrammees($session_id);
       

        $tableau = [] ;
        foreach($nonProgramees as $index => $cours){
                 $programe = new Programe() ;
                 $programe->setCours($cours);
                 $programe->setSession($session);
                 $index = $this->createForm(ProgrameTypePhpType::class,$programe)  ;
                 $index->handleRequest($request);
                 $tableau [] = $index->createView();

                 if($index->isSubmitted() &&  $index->isValid()){
                  
                    $programe =$index->getData();
                    
                    $entityManager =$doctrine->getManager();
                    $session=$entityManager->getRepository(Session::class)->find($id);
                    $session->addPrograme($programe);
                    $entityManager ->persist($programe);
                    $entityManager->flush();

        return $this->redirectToRoute('show_session',['id'=>$id]);


                 }

        }

       
        return $this->render('session/show.html.twig', [
           'session'=>$session ,
           'stagiaires'=>$stagiaires ,
           'nonInscrits'=>$nonIncrits,
           'nonProgramees'=>$nonProgramees,
           'tableau'=>$tableau
         
           
        ]);
    }




}
