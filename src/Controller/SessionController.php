<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Session;
use App\Entity\Programe;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use Doctrine\ORM\EntityManager;
use App\Form\ProgrameTypePhpType;
use App\Repository\SessionRepository;
use App\Repository\ProgrameRepository;

use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SessionController extends AbstractController
{
    /**
     * @Route("/", name="app_session")
     * @Route("/session/add", name="add_session")
     * @Route("/session/edit/{id}",name="edit_session")
     */
    public function index(SessionRepository $s,ManagerRegistry $doctrine,Session $session=null,Request $request): Response
    {
        
        $sessionsPassees = $s -> findSessionsPassees() ;
        $SessionsEncours = $s -> findSessionsEncours();
        $SessionsAvenir = $s -> findSessionsAvenir();

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
        
        return $this->render('session/index.html.twig', [
            "SessionsPassees"=>$sessionsPassees ,
            "SessionsEncours"=>$SessionsEncours ,
            "SessionAvenir"=>$SessionsAvenir ,
            'formAddSession'=>$form->createView()
        ]);
    }
  

    
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
     * @Route("/session/addProgramme/{idSe}/{idCours}", name="add_module_session")
     * @ParamConverter("session", options={"mapping": {"idSe": "id"}})
     * @ParamConverter("cours", options={"mapping": {"idCours": "id"}})
     */
    public function addProgramme(ManagerRegistry $doctrine, Request $request, Session $session, Cours $cours) {

        $em = $doctrine->getManager();
        $pr = new Programe();
        $pr->setSession($session);
        $pr->setCours($cours);

        $nbJours = $request->request->get('nbJours');
        
        $pr->setDuree($nbJours);
        
        $em->persist($pr);
        $em->flush();
        
        return $this->redirectToRoute('show_session', ['id' => $session->getId()]);
    }



    




    /**
     * @Route("/session/{id}", name="show_session")
     */
      
    public function show(Session $session,Session $stagiaire,StagiaireRepository $sr,ProgrameRepository  $pr ,Programe $programe = null,Request $request,ManagerRegistry $doctrine,int $id  ): Response
    {
        
        $session_id = $session->getId();
        $nonIncrits = $sr ->findStagiaireNonInscrits($session_id);
        $stagiaires =$session->getStagiaires();






        // on difinit une variable qui va dans la requete dql que on a fait 
        $nonProgramees = $pr->findCoursNonProgrammees($session_id);
       
        // on passe une table vide
        // $tableau = [] ;

        // on fais une foreach pour pouvoir parcourir dans la requete parce que la requete va envoyer une table des cours 
        // foreach($nonProgramees as $index => $cours){
            // on veut creer un neuveau programme
                //  $programe = new Programe() ;
            // pour creer un programme j'ai besion le cours et la session par l'entity programe     
                //  $programe->setCours($cours);
                //  $programe->setSession($session);

            // on va creer le formulaire 
                //  $index = $this->createForm(ProgrameTypePhpType::class,$programe)  ;
                //  $index->handleRequest($request);
            // on va creer la vue dans la tableau      
                //  $tableau [] = $index->createView();

                //  if($index->isSubmitted() &&  $index->isValid()){
            // on recupere la data      
                    // $programe =$index->getData();
                    
                    // $entityManager =$doctrine->getManager();
            // on a basoin l'id de la session         
        //             $session=$entityManager->getRepository(Session::class)->find($id);

        //             $session->addPrograme($programe);
        //             $entityManager ->persist($programe);
        //             $entityManager->flush();

        // return $this->redirectToRoute('show_session',['id'=>$id]);


        //          }

        // }

       
        return $this->render('session/show.html.twig', [
           'session'=>$session ,
           'stagiaires'=>$stagiaires ,
           'nonInscrits'=>$nonIncrits,
           'nonProgramees'=>$nonProgramees
        //    'tableau'=>$tableau
         
           
        ]);
    }


    
}


        
    // /**
    //  * @Route("/session/add", name="add_session")
    //  * @Route("/session/edit/{id}",name="edit_session")
    // */

    // public function addSession(ManagerRegistry $doctrine,Session $session=null,Request $request)
    // {
    //     if(!$session){
    //         $session = new Session();
    //     }
    //     $form =$this->createForm(SessionType::class,$session); 
    //     $form->handleRequest($request);

    //     if( $form->isSubmitted() && $form->isValid())
    //     {
    //         $session =$form->getData();
    //         $entityManager = $doctrine->getManager();
    //         $entityManager->persist($session);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_session');


    //     }
    //     return $this->render('session/add.html.twig',
    //     ['formAddSession'=>$form->createView()
    
    // ]);


    // }



