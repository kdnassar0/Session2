<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;

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
     * @Route("/session/{id}", name="show_session")
     */
      
    public function show(Session $session,session $stagiaire  ): Response
    {
       
        return $this->render('session/show.html.twig', [
           'session'=>$session ,
           'stagiaires'=>$stagiaire
           
        ]);
    }


}
