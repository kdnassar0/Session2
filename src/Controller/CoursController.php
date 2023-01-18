<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="app_cours")
     */
    public function index(): Response
    {

     
        return $this->render('cours/index.html.twig', [
          
        ]);
    }
}
