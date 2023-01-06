<?php

namespace App\Controller;

use App\Repository\CoursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/cours", name="app_cours")
     */
    public function index(CoursRepository $c): Response
    {
        $cours = $c -> findBy([],['nomCours'=>'ASC']) ;
        return $this->render('cours/index.html.twig', [
           'Cours'=>$cours
        ]);
    }
}
