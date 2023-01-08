<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Repository\StagiaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagiaireController extends AbstractController
{
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
