<?php

namespace App\Controller;

use App\Entity\Reference;
use App\Form\ReferenceType;
use App\Repository\ReferenceRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferenceController extends AbstractController
{
    /**
     * @Route("/reference/{id}", name="show_reference")
     * @Route("/reference", name="app_reference")
     */
    public function index(ManagerRegistry $doctirne,ReferenceRepository $re, $id = null,Reference $reference=null,Request $request): Response
    { 
    
      

        $references = $re ->findBy([],['nomRefernce'=>'ASC']);
        $oneReference = $doctirne->getRepository(Reference::class)->findOneBy(['id'=>$id]) ;
        
        
        
        $form =$this->createForm(ReferenceType::class,$reference);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $reference= $form->getData();
            $entityManager = $doctirne->getManager();
            $entityManager->persist($reference);
            $entityManager->flush();

            return $this->redirectToRoute('app_reference');
        }
        

        return $this->render('reference/index.html.twig', [
            'references'=>$references ,
            'oneReference'=>$oneReference,
            'formAddReference'=>$form->createView()
           
          
        ]);
    }





}
